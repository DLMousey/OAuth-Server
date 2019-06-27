<?php

namespace Application\Controller;

use Application\Form\ApplicationForm;
use DateTime;

use Core\Service\ApplicationService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ApplicationController extends AbstractActionController
{
    protected $applicationService;

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
