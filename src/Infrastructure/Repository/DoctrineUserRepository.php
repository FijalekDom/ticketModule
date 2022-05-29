<?php

namespace App\Infrastructure\Repository;

use App\Domain\ValueObject\User;
use App\Infrastructure\Entity\DoctrineUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class DoctrineUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DoctrineUser::class);
    }

    public function create(User $user, string $password)
    {
        $sql = "INSERT INTO `user` (email, roles, password) VALUES (:email, :roles, :password)";
        $stmt = $this->_em->getConnection()->prepare($sql);
        $stmt->bindValue('email', $user->getEmail());
        $stmt->bindValue('roles', json_encode($user->getRoles()));
        $stmt->bindValue('password', $password);
        $stmt->executeQuery();
    }
}