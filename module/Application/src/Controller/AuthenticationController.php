<?php

namespace Application\Controller;

use Application\Filter\LoginFilter;
use Application\Filter\RegisterFilter;
use Application\Form\LoginForm;
use Application\Form\RegisterForm;
use Core\Exception\AlreadyLoggedInException;
use Core\Exception\NotLoggedInException;
use Core\Service\AuthenticationManager;
use Core\Service\UserService;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Result;
use Zend\Form\Element\Password;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AuthenticationController extends AbstractActionController
{
    protected $userService;
    protected $authenticationManager;
    protected $authenticationService;

    public function loginAction()
    {
        $form = new LoginForm();
        $form->setInputFilter(new LoginFilter());

        if($this->getRequest()->isPost()) {
            $form->getInputFilter()->setData($this->params()->fromPost());
            try {
                $result = $this->getAuthenticationManager()->login(
                    $form->getInputFilter()->getValue('email'),
                    $form->getInputFilter()->getValue('password')
                );
            } catch (AlreadyLoggedInException $e) {
                return $this->redirect()->toRoute('application-list');
            }

            if($result->getCode() == Result::SUCCESS) {
                if($this->params()->fromQuery('redirectUrl')) {
                    return $this->redirect()->toUrl(urldecode($this->params()->fromQuery(('redirectUrl'))));
                } else {
                    return $this->redirect()->toRoute('application-list');
                }
            }
        }

        return new ViewModel([
            'form' => $form
        ]);
    }

    public function registerAction()
    {
        $form = new RegisterForm();
        $form->setInputFilter(new RegisterFilter());

        if($this->getRequest()->isPost()) {
            $form->setData($this->params()->fromPost());

            if($form->isValid()) {
                $this->getUserService()->create(
                    $form->getInputFilter()->getValues()
                );

                $authResult = $this->getAuthenticationManager()->login(
                    $form->getInputFilter()->getValue('email'),
                    $form->getInputFilter()->getValue('password')
                );

                if($authResult == Result::SUCCESS) {
                    if($this->params()->fromQuery('redirectUrl')) {
                        return $this->redirect()->toUrl($this->params()->fromQuery('redirectUrl'));
                    } else {
                        return $this->redirect()->toRoute('application-list');
                    }
                }
            }
        }

        return new ViewModel([
            'form' => $form
        ]);
    }

    public function logoutAction()
    {
        try {
            $this->getAuthenticationManager()->logout();
        } catch(NotLoggedInException $e) {
            die(dump($e));
        }

        return $this->redirect()->toRoute('login');

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
     * @param AuthenticationManager $authenticationManager
     * @return $this
     */
    public function setAuthenticationManager(AuthenticationManager $authenticationManager)
    {
        $this->authenticationManager = $authenticationManager;
        return $this;
    }

    /**
     * @return AuthenticationManager
     */
    public function getAuthenticationManager() : AuthenticationManager
    {
        return $this->authenticationManager;
    }

    /**
     * @param AuthenticationService $authenticationService
     * @return $this
     */
    public function setAuthenticationService(AuthenticationService $authenticationService)
    {
        $this->authenticationService = $authenticationService;
        return $this;
    }

    /**
     * @return AuthenticationService
     */
    public function getAuthenticationService() : AuthenticationService
    {
        return $this->authenticationService;
    }
}
