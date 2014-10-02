<?php

namespace Eye4web\ZfcUser\ForgotPassword\Controller;

use Eye4web\ZfcUser\ForgotPassword\Form\Forgot\ChangePasswordForm;
use Eye4web\ZfcUser\ForgotPassword\Form\Forgot\RequestForm;
use Eye4web\ZfcUser\ForgotPassword\Service\ForgotService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Stdlib\ResponseInterface as Response;

class ForgotController extends AbstractActionController
{
    /** @var RequestForm */
    protected $requestForm;

    /** @var ChangePasswordForm */
    protected $changePasswordForm;

    /** @var ForgotService */
    protected $forgotService;

    public function __construct(RequestForm $requestForm, ChangePasswordForm $changePasswordForm, ForgotService $forgotService)
    {
        $this->requestForm = $requestForm;
        $this->changePasswordForm = $changePasswordForm;
        $this->forgotService = $forgotService;
    }

    public function indexAction()
    {
        $form = $this->requestForm;
        $forgotService = $this->forgotService;

        $viewModel = new ViewModel([
            'form' => $form,
        ]);

        $viewModel->setTemplate('zfc-user-forgot-password/request.phtml');

        $redirectUrl = $this->url()->fromRoute('e4w/zfc-user-forgot-password');
        $prg = $this->prg($redirectUrl, true);

        if ($prg instanceof Response) {
            return $prg;
        } elseif ($prg === false) {
            return $viewModel;
        }

        if ($forgotService->request($prg)) {
            $viewModel->setTemplate('zfc-user-forgot-password/confirmation/sent-email.phtml');
            return $viewModel;
        }

        return $viewModel;
    }

    public function changePasswordAction()
    {
        $form = $this->changePasswordForm;
        $forgotService = $this->forgotService;
        $token = $this->params('token');
        $user = $forgotService->getUserFromToken($token);


        $viewModel = new ViewModel([
            'form' => $form,
        ]);

        if (!$user) {
            $viewModel->setTemplate('zfc-user-forgot-password/expired.phtml');
            return $viewModel;
        }

        $viewModel->setTemplate('zfc-user-forgot-password/change-password.phtml');

        $redirectUrl = $this->url()->fromRoute('e4w/zfc-user-forgot-password/change-password', ['token' => $token]);
        $prg = $this->prg($redirectUrl, true);

        if ($prg instanceof Response) {
            return $prg;
        } elseif ($prg === false) {
            return $viewModel;
        }

        if ($forgotService->changePassword($prg, $user)) {
            $viewModel->setTemplate('zfc-user-forgot-password/confirmation/changed-password.phtml');
            return $viewModel;
        }

        $form->setData([
            'new_password' => null,
            'confirm_new_password' => null,
        ]);

        return $viewModel;
    }
}
