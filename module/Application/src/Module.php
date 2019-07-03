<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Core\Service\AuthenticationManager;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\MvcEvent;
use Zend\Session\SessionManager;

class Module
{
    const VERSION = '3.0.3-dev';

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function onBootstrap(MvcEvent $event)
    {
        $eventManager = $event->getApplication()->getEventManager();
        $sharedEventManager = $eventManager->getSharedManager();
        $sharedEventManager->attach(AbstractActionController::class,
            MvcEvent::EVENT_DISPATCH, [$this, 'onDispatch'], 100);
    }

    public function onDispatch(MvcEvent $event)
    {
        $controller = $event->getTarget();
        $controllerName = $event->getRouteMatch()->getParam('controller', null);
        $actionName = $event->getRouteMatch()->getParam('action', null);
        $actionName = str_replace('-', '', lcfirst(ucwords($actionName, '-')));

        $authManager = $event->getApplication()->getServiceManager()->get(AuthenticationManager::class);
        $guestActions = ['login', 'register'];

        if(!in_array($actionName, $guestActions) && !$authManager->filterAccess($controllerName, $actionName)) {
            die(dump('not logged in and trying to access user action'));
        }
    }
}
