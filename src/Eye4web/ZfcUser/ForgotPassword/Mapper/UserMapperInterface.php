<?php

namespace Eye4web\ZfcUser\ForgotPassword\Mapper;

use ZfcUser\Entity\UserInterface;

interface UserMapperInterface
{
    /**
     * Find user by email
     *
     * @param string $email
     * @return UserInterface
     */
    public function findByEmail($email);

    /**
     * Find user by id
     *
     * @param int $id
     * @return UserInterface
     */
    public function findById($id);

    /**
     * Change password
     *
     * @param string $password
     * @param UserInterface $user
     * @return bool
     */
    public function changePassword($password, UserInterface $user);
}
