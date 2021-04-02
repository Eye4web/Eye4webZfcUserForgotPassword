<?php

namespace Eye4web\ZfcUser\ForgotPassword\Mapper\DoctrineORM;

use Doctrine\Common\Persistence\ObjectManager;
use Eye4web\ZfcUser\ForgotPassword\Entity\TokenInterface;
use Eye4web\ZfcUser\ForgotPassword\Mapper\TokenMapperInterface;
use Eye4web\ZfcUser\ForgotPassword\Options\ModuleOptions;
use ZfcUser\Entity\UserInterface;
use ZfcUser\Options\ModuleOptions as ZfcUserModuleOptions;

class TokenMapper implements TokenMapperInterface
{
    /** @var \Doctrine\Persistence\ObjectManager */
    protected $objectManager;

    /** @var ModuleOptions */
    protected $moduleOptions;

    public function __construct(\Doctrine\Persistence\ObjectManager $objectManager, ModuleOptions $moduleOptions)
    {
        $this->objectManager = $objectManager;
        $this->moduleOptions = $moduleOptions;
    }

    /**
     * {@inheritDoc}
     */
    public function findByUser(UserInterface $user)
    {
        return $this->objectManager->getRepository($this->moduleOptions->getTokenEntity())->findOneBy([
            'user' => $user->getId()
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function findByToken($token)
    {
        $queryBuilder = $this->objectManager->createQueryBuilder();

        $queryBuilder->select('t')
                      ->from($this->moduleOptions->getTokenEntity(), 't')
                      ->where('t.token = :token')
                      ->andWhere('t.expireDateTime > :current');

        /** @var \Doctrine\ORM\AbstractQuery $query */
        $query = $queryBuilder->getQuery();

        $query->setParameters([
            'token' => $token,
            'current' => new \DateTime
        ]);

        return $query->getOneOrNullResult();
    }

    /**
     * {@inheritdoc}
     */
    public function generate(UserInterface $user)
    {
        if ($token = $this->findByUser($user)) {
            $this->remove($token);
        }

        $entity = $this->moduleOptions->getTokenEntity();
        /** @var TokenInterface $token */
        $token = new $entity;

        // Expire
        $hours = $this->moduleOptions->getTokenHours();
        $hoursText = 'hours';

        if ($hours == 1) {
            $hoursText = 'hour';
        }

        $expire = new \DateTime;
        $expire->modify('+' . $hours . ' ' . $hoursText);

        $token->setUser($user->getId());
        $token->setExpireDateTime($expire);

        return $this->saveToken($token);
    }

    /**
     * {@inheritdoc}
     */
    public function remove(TokenInterface $token, $flush = true)
    {
        $this->objectManager->remove($token);

        if ($flush) {
            $this->objectManager->flush();
        }

        return true;
    }

    /**
     * Save token
     *
     * @param TokenInterface $token
     * @param bool $flush
     * @return TokenInterface
     */
    public function saveToken(TokenInterface $token, $flush = true)
    {
        $this->objectManager->persist($token);

        if ($flush) {
            $this->objectManager->flush();
        }

        return $token;
    }
}
