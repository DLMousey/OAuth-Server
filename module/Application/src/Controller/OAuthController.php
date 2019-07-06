<?php


namespace Application\Controller;

use Core\Service\AccessTokenService;
use Core\Service\ApplicationService;
use Core\Service\UserService;
use Core\Service\VerificationTokenService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class OAuthController extends AbstractActionController
{
    protected $applicationService;
    protected $verificationTokenService;
    protected $userService;
    protected $accessTokenService;

    public function userConsentAction()
    {
        // @todo return credentials instead of view is user has already authorised app

        $clientId = $this->params()->fromQuery('client_id');
        if(!$application = $this->getApplicationService()->findByClientId($clientId)) {
            // @todo - tell user the app did a stupid
            return false;
        }

        return new ViewModel([
            'application' => $application
        ]);
    }

    public function userConsentGrantAction()
    {
        $clientId = $this->params()->fromQuery('client_id');
        if(!$application = $this->getApplicationService()->findByClientId($clientId)) {
            return false;
        }

        $user = $this->getUserService()->findByEmail($this->identity());

        $verificationToken = $this->getVerificationTokenService()->create($user, $application);

        $user->addApplication($application);
        $user->addVerificationToken($verificationToken);
        $this->getUserService()->save($user);

        $redirectUrl = $application->getRedirectUrl();
        $redirectUrl .= '?code=' . $verificationToken->getToken();

        return $this->redirect()->toUrl($redirectUrl);
    }

    /**
     * @TODO - consider support for other grant types
     */
    public function userConsentGrantCallbackAction()
    {
        $data = $this->params()->fromPost();
        if(!$application = $this->getApplicationService()->findByClientId($data['client_id'])) {
            return $this->errorResponse(400, 'Invalid client ID specified');
        }

        if($application->getClientSecret() != $data['client_secret']) {
            return $this->errorResponse(400, 'Invalid client secret specified');
        }

        if(!$verificationToken = $this->getVerificationTokenService()->findByToken($data['code'])) {
            return $this->errorResponse(400, 'Invalid verification token specified');
        }

        $user = $verificationToken->getUser();
        $accessToken = $this->getAccessTokenService()->create($user, $application);
        $user->addAccessToken($accessToken);

        $this->getResponse()->getHeaders()->addHeaderLine('Content-Type', 'application/json');
        $this->getResponse()->setStatusCode(201);
        $this->getResponse()->setContent(json_encode([
            'status' => 201,
            'data' => [
                'access_token' => $accessToken->getToken(),
                'token_type' => 'bearer',
                'scope' => 'todo'
            ]
        ]));

        return $this->getResponse();
    }

    private function errorResponse(int $status, string $message)
    {
        $this->getResponse()->getHeaders()->addHeaderLine('Content-Type', 'application/json');
        $this->getResponse()->setStatusCode($status);
        $this->getResponse()->setContent(json_encode([
            'status' => $status,
            'error' => $message
        ]));

        return $this->getResponse();
    }

    /**
     * @param ApplicationService $applicationService
     * @return $this
     */
    public function setApplicationService(ApplicationService $applicationService)
    {
        $this->applicationService = $applicationService;
        return $this;
    }

    /**
     * @return ApplicationService
     */
    public function getApplicationService() : ApplicationService
    {
        return $this->applicationService;
    }

    /**
     * @param VerificationTokenService $verificationTokenService
     * @return $this
     */
    public function setVerificationTokenService(VerificationTokenService $verificationTokenService)
    {
        $this->verificationTokenService = $verificationTokenService;
        return $this;
    }

    /**
     * @return VerificationTokenService
     */
    public function getVerificationTokenService() : VerificationTokenService
    {
        return $this->verificationTokenService;
    }

    /**
     * @param UserService $userService
     * @return $this
     */
    public function setUserService(UserService $userService)
    {
        $this->userService = $userService;
        return $this;
    }

    /**
     * @return UserService
     */
    public function getUserService() : UserService
    {
        return $this->userService;
    }

    /**
     * @param AccessTokenService $accessTokenService
     * @return $this
     */
    public function setAccessTokenService(AccessTokenService $accessTokenService)
    {
        $this->accessTokenService = $accessTokenService;
        return $this;
    }

    /**
     * @return AccessTokenService
     */
    public function getAccessTokenService() : AccessTokenService
    {
        return $this->accessTokenService;
    }
}
