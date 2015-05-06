<?php

namespace Eye4web\ZfcUser\ForgotPassword\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="forgot_password_tokens")
 */
class Token implements TokenInterface
{
    /**
     * @var int|null
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=50, unique=true)
     */
    protected $token;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    protected $user;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $expireDateTime;

    public function __construct()
    {
        $this->token = uniqid(mt_rand(), true);
        $this->expireDateTime = null;
    }

    /**
     * @param int|null $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param \DateTime $expireDateTime
     */
    public function setExpireDateTime($expireDateTime)
    {
        $this->expireDateTime = $expireDateTime;
    }

    /**
     * @return \DateTime
     */
    public function getExpireDateTime()
    {
        return $this->expireDateTime;
    }
}
