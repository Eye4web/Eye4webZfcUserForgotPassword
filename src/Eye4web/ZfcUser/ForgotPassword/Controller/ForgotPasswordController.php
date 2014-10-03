<?php

namespace Eye4web\ZfcUser\ForgotPassword\Controller;

use Eye4web\ZfcUser\ForgotPassword\Form\Forgot\ChangePasswordForm;
use Eye4web\ZfcUser\ForgotPassword\Form\Forgot\RequestForm;
use Eye4web\ZfcUser\ForgotPassword\Service\ ForgotPasswordService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Stdlib\ResponseInterface as Response;

class ForgotPasswordController extends AbstractActionController
{
    /** @var RequestForm */
    protected $requestForm;

    /** @var ChangePasswordForm */
    protected $changePasswordForm;

    /** @var ForgotPasswordService */
    protected $forgotPasswordService;

    public function __construct(RequestForm $requestForm, ChangePasswordForm $changePasswordForm, ForgotPasswordService $forgotPasswordService)
    {
        $this->requestForm = $requestForm;
        $this->changePasswordForm = $changePasswordForm;
        $this->forgotPasswordService = $forgotPasswordService;
    }

    public function indexAction()
    {
        $form = $this->requestForm;
        $forgotPasswordService = $this->forgotPasswordService;

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

        if ($forgotPasswordService->request($prg)) {
            $viewModel->setTemplate('zfc-user-forgot-password/confirmation/sent-email.phtml');
            return $viewModel;
        }

        return $viewModel;
    }

    public function changePasswordAction()
    {
        $form = $this->changePasswordForm;
        $forgotPasswordService = $this->forgotPasswordService;
        $token = $this->params('token');
        $user = $forgotPasswordService->getUserFromToken($token);

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

        if ($forgotPasswordService->changePassword($prg, $user)) {
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
