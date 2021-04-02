<?php

namespace Eye4web\ZfcUser\ForgotPassword\Mapper\DoctrineORM;

use Doctrine\Common\Persistence\ObjectManager;
use Eye4web\ZfcUser\ForgotPassword\Mapper\UserMapperInterface;
use ZfcUser\Entity\UserInterface;
use ZfcUser\Options\ModuleOptions as ZfcUserModuleOptions;
use Zend\Crypt\Password\Bcrypt;

class UserMapper implements UserMapperInterface
{
    /** @var \Doctrine\Persistence\ObjectManager */
    protected $objectManager;

    /** @var ZfcUserModuleOptions */
    protected $zfcUserModuleOptions;

    public function __construct(\Doctrine\Persistence\ObjectManager $objectManager, ZfcUserModuleOptions $zfcUserModuleOptions)
    {
        $this->objectManager = $objectManager;
        $this->zfcUserModuleOptions = $zfcUserModuleOptions;
    }

    /**
     * {@inheritDoc}
     */
    public function findById($id)
    {
        return $this->objectManager->getRepository($this->zfcUserModuleOptions->getUserEntityClass())->find($id);
    }

    /**
     * {@inheritDoc}
     */
    public function findByEmail($email)
    {
        return $this->objectManager->getRepository($this->zfcUserModuleOptions->getUserEntityClass())->findOneBy([
            'email' => $email,
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function changePassword($password, UserInterface $user)
    {
        $bCrypt = new Bcrypt;
        $bCrypt->setCost($this->zfcUserModuleOptions->getPasswordCost());

        $password = $bCrypt->create($password);

        $user->setPassword($password);

        return $this->save($user);
    }

    /**
     * Save user
     *
     * @param UserInterface $user
     * @param bool $flush
     * @return UserInterface
     */
    public function save(UserInterface $user, $flush = true)
    {
        $this->objectManager->persist($user);

        if ($flush) {
            $this->objectManager->flush();
        }

        return $user;
    }
}
