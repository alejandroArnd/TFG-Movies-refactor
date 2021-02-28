<?php

namespace App\Infrastructure\Repository;

use App\Domain\Model\UserModel;
use App\Infrastructure\Entity\User;
use App\Infrastructure\Mapper\UserMapper;
use Doctrine\Persistence\ManagerRegistry;
use App\Application\Repository\UserRepository;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class DoctrineUserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface, UserRepository
{
    private UserPasswordEncoderInterface $encoder;
    private UserMapper $userMapper;

    public function __construct(ManagerRegistry $registry, UserPasswordEncoderInterface $encoder, UserMapper $userMapper)
    {
        parent::__construct($registry, User::class);
        $this->encoder = $encoder;
        $this->userMapper = $userMapper;
    }

    public function save(UserModel $user, string $plainPassword): void
    {
        $userToSave = $this->userMapper->toEntity($user);
        $userToSave->setPassword($this->encoder->encodePassword($userToSave, $plainPassword));
        $this->getEntityManager()->persist($userToSave);
        $this->getEntityManager()->flush();
    }

    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newEncodedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }
}
