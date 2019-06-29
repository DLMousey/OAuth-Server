<?php

namespace Application\Controller;

use Exception;
use DateTime;
use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;
use Application\Form\ApplicationForm;
use Core\Service\ApplicationService;

class ApplicationController extends AbstractActionController
{
    protected $applicationService;

    public function applicationDetailAction()
    {
        $application = $this->getApplicationService()->find($this->params()->fromRoute('id'));

        return new ViewModel([
            'application' => $application
        ]);
    }

    public function createFormAction()
    {
        $form = new ApplicationForm();

        if($this->getRequest()->isPost()) {
            $application = $this->getApplicationService()->create($this->params()->fromPost());

            $vm = new ViewModel(['application' => $application]);
            $vm->setTemplate('application/create-success');
            return $vm;
        }

        return new ViewModel([
            'form' => $form
        ]);
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
}
