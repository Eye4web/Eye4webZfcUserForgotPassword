<?php

namespace Eye4web\ZfcUser\ForgotPassword\Options;

interface ModuleOptionsInterface
{
    /**
     * Get token entity
     *
     * @return string
     */
    public function getTokenEntity();

    /**
     * The lifetime of the tokens
     *
     * @return int
     */
    public function getTokenHours();

    /**
     * Get mail transporter
     *
     * @return string
     */
    public function getMailTransporter();
}
