<?php

namespace Core\Service;

use Exception;
use Zend\Authentication\AuthenticationService as ZendAuthService;

class AuthenticationManager
{
    protected $config;
    protected $authenticationService;

    public function login($email, $password)
    {
        if($this->getAuthenticationService()->getIdentity() != null) {
            throw new Exception('Already logged in');
        }

        $adapter = $this->getAuthenticationService()->getAdapter();
        $adapter->setEmail($email);
        $adapter->setPassword($password);

        return $this->getAuthenticationService()->authenticate();
    }

    public function logout()
    {
        if($this->getAuthenticationService()->getIdentity() == null) {
            throw new Exception('Not logged in');
        }

        $this->getAuthenticationService()->clearIdentity();
    }

    public function filterAccess(string $controllerName, string $actionName) {
//        $mode = isset($this->getConfig('options')['mode']) ?
//            $this->getConfig('options')['mode'] :
//            'restrictive';

        $config = $this->getConfig('options');

        if($mode != 'restrictive' || $mode != 'permissive') {
            throw new Exception('Invalid access filter mode provided');
        }

        if(isset($this->getConfig('controllers')[$controllerName])) {
            $items = $this->getConfig('controllers')[$controllerName];
            die(dump($items));
        }
    }

    /**
     * @param array $config
     * @return $this
     */
    public function setConfig(array $config)
    {
        $this->config = $config;
        return $this;
    }

    /**
     * @param string|null $key
     * @return array|null
     */
    public function getConfig(string $key = null)
    {
        if($key != null) {
            return $this->config[$key];
        }

        return $this->config;
    }

    /**
     * @param ZendAuthService $authenticationService
     * @return $this
     */
    public function setAuthenticationService(ZendAuthService $authenticationService)
    {
        $this->authenticationService = $authenticationService;
        return $this;
    }

    /**
     * @param ZendAuthService $authenticationService
     * @return ZendAuthService
     */
    public function getAuthenticationService() : ZendAuthService
    {
        return $this->authenticationService;
    }
}
