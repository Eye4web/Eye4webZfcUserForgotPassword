<?php

namespace Eye4web\ZfcUser\ForgotPassword\Options;

use Zend\ServiceManager\ServiceManager;
use Zend\Stdlib\AbstractOptions;

class ModuleOptions extends AbstractOptions implements ModuleOptionsInterface
{
    /** @var string */
    protected $tokenEntity = 'Eye4web\ZfcUser\ForgotPassword\Entity\Token';

    /** @var int */
    protected $tokenHours = 24;

    /**
     * @var string
     */
    protected $mailTransporter = 'Soflomo\Mail\Service\MailService';

    /**
     * Ensure that the entity has the correct name
     *
     * @param $entityClass
     * @return string
     */
    public function correctEntity($entityClass)
    {
        if (substr($entityClass, 0, 1) !== '\\') {
            $entityClass = '\\' . $entityClass;
        }

        return $entityClass;
    }

    /**
     * @param string $tokenEntity
     */
    public function setTokenEntity($tokenEntity)
    {
        $this->tokenEntity = $tokenEntity;
    }

    /**
     * @return string
     */
    public function getTokenEntity()
    {
        return $this->correctEntity($this->tokenEntity);
    }

    /**
     * @param int $tokenHours
     */
    public function setTokenHours($tokenHours)
    {
        $this->tokenHours = $tokenHours;
    }

    /**
     * @return int
     */
    public function getTokenHours()
    {
        return $this->tokenHours;
    }

    /**
     * @param string $mailTransporter
     */
    public function setMailTransporter($mailTransporter)
    {
        $this->mailTransporter = $mailTransporter;
    }

    /**
     * @return string
     */
    public function getMailTransporter()
    {
        return $this->mailTransporter;
    }
}