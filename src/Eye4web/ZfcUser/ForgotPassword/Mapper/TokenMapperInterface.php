<?php

namespace Eye4web\ZfcUser\ForgotPassword\Mapper;

use ZfcUser\Entity\UserInterface;
use Eye4web\ZfcUser\ForgotPassword\Entity\TokenInterface;

interface TokenMapperInterface
{
    /**
     * Generate token for user
     *
     * @param UserInterface $user
     * @return TokenInterface
     */
    public function generate(UserInterface $user);

    /**
     * Find token from user
     *
     * @param UserInterface $user
     * @return TokenInterface|null
     */
    public function findByUser(UserInterface $user);

    /**
     * Remove token
     *
     * @param TokenInterface $token
     * @return bool
     */
    public function remove(TokenInterface $token);

    /**
     * Get token entity by token
     *
     * @param $token
     * @return TokenInterface
     */
    public function findByToken($token);
}
