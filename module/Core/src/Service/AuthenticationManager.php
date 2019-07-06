<?php

namespace Core\Service;

use Core\Exception\NotLoggedInException;
use Exception;
use Zend\Authentication\AuthenticationService as ZendAuthService;
use Core\Exception\AlreadyLoggedInException;

class AuthenticationManager
{
    protected $config;
    protected $authenticationService;

    public function login($email, $password)
    {
        if($this->getAuthenticationService()->getIdentity() != null) {
            throw new AlreadyLoggedInException('Already logged in');
        }

        $adapter = $this->getAuthenticationService()->getAdapter();
        $adapter->setEmail($email);
        $adapter->setPassword($password);

        return $this->getAuthenticationService()->authenticate();
    }

    public function logout()
    {
        if($this->getAuthenticationService()->getIdentity() == null) {
            throw new NotLoggedInException('Not logged in');
        }

        $this->getAuthenticationService()->clearIdentity();
    }

    public function filterAccess(string $controllerName, string $actionName) {
        $mode = isset($this->getConfig('access_filter')['options']['mode']) ?
            $this->getConfig('access_filter')['options']['mode'] :
            'restrictive';

        $validModes = ['restrictive', 'permissive'];
        if(!in_array($mode, $validModes)) {
            throw new Exception('Invalid access filter mode provided');
        }

        if(isset($this->getConfig('access_filter')['controllers'][$controllerName])) {
            $items = $this->getConfig('access_filter')['controllers'][$controllerName];

            foreach($items as $item) {
                $actionList = $item['actions'];
                $allow = $item['allow'];

                if(is_array($actionList) && in_array($actionName, $actionList) || $actionList == '*') {
                    if($allow == '*') {
                        return true;
                    } elseif($allow == '@' && $this->getAuthenticationService()->hasIdentity()) {
                        return true;
                    } else {
                        return false;
                    }
                }
            }

            if($mode == 'restrictive' && !$this->getAuthenticationService()->hasIdentity()) {
                return false;
            }

            return true;
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
