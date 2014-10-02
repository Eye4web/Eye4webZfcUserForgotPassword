<?php

namespace Eye4web\ZfcUser\ForgotPassword\Service;

use Doctrine\Common\Persistence\ObjectManager;
use Eye4web\ZfcUser\ForgotPassword\Form\Forgot\ChangePasswordForm;
use Eye4web\ZfcUser\ForgotPassword\Form\Forgot\RequestForm;
use Eye4web\ZfcUser\ForgotPassword\Mapper\TokenMapperInterface;
use Eye4web\ZfcUser\ForgotPassword\Mapper\UserMapperInterface;
use Eye4web\ZfcUser\ForgotPassword\Entity\TokenInterface;
use ZfcUser\Entity\UserInterface;

class ForgotService
{
    /** @var RequestForm */
    protected $requestForm;

    /** @var ChangePasswordForm */
    protected $changePasswordForm;

    /** @var UserMapperInterface */
    protected $userMapper;

    /** @var TokenMapperInterface */
    protected $tokenMapper;

    /** @var MailService */
    protected $mailService;

    public function __construct(
        RequestForm $requestForm,
        ChangePasswordForm $changePasswordForm,
        UserMapperInterface $userMapper,
        TokenMapperInterface $tokenMapper,
        MailService $mailService
    ) {
        $this->requestForm = $requestForm;
        $this->changePasswordForm = $changePasswordForm;
        $this->userMapper = $userMapper;
        $this->tokenMapper = $tokenMapper;
        $this->mailService = $mailService;
    }

    /**
     * Request new password
     *
     * @param array $data
     * @return bool
     */
    public function request(array $data)
    {
        $form = $this->requestForm;
        $form->setData($data);

        if (!$form->isValid()) {
            return false;
        }

        $user = $this->userMapper->findByEmail($form->get('email')->getValue());

        if (!$user) {
            return true;
        }

        $token = $this->tokenMapper->generate($user);

        $this->mailService->sendToken($token, $user);

        return true;
    }

    /**
     * Change password for user
     *
     * @param array $data
     * @param UserInterface $user
     * @return bool
     */
    public function changePassword(array $data, UserInterface $user)
    {
        $form = $this->changePasswordForm;
        $form->setData($data);

        if (!$form->isValid()) {
            return false;
        }

        $token = $this->tokenMapper->findByUser($user);

        $this->userMapper->changePassword($form->get('new_password')->getValue(), $user);
        $this->tokenMapper->remove($token);

        return true;
    }

    /**
     * Get identity from token
     *
     * @param string $token
     * @return bool|UserInterface
     */
    public function getUserFromToken($token)
    {
        $entity = $this->tokenMapper->findByToken($token);

        if (!$entity) {
            return false;
        }

        return $this->userMapper->findById($entity->getUser());
    }
}
