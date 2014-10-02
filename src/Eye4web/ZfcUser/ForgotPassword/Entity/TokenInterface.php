<?php

namespace Eye4web\ZfcUser\ForgotPassword\Entity;

interface TokenInterface
{
    /**
     * @return int|null
     */
    public function getId();

    /**
     * @param string $token
     */
    public function setToken($token);

    /**
     * @return string
     */
    public function getToken();

    /**
     * @return int
     */
    public function getUser();

    /**
     * @return \DateTime
     */
    public function getExpireDateTime();
}
