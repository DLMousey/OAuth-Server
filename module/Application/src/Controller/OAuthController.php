<?php


namespace Application\Controller;

use Core\Service\ApplicationService;
use Core\Service\UserService;
use Core\Service\VerificationTokenService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class OAuthController extends AbstractActionController
{
    protected $applicationService;
    protected $verificationTokenService;
    protected $userService;

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
}
