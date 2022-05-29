<?php

namespace App\Application\CommandHandler;

use App\Application\Command\AddUserCommand;
use App\Domain\ValueObject\User;
use App\Infrastructure\Entity\DoctrineUser;
use App\Infrastructure\Repository\DoctrineUserRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AddUserCommandHandler implements MessageHandlerInterface
{
    private DoctrineUserRepository $userRepository;
    private UserPasswordHasherInterface $encoder;

    public function __construct(DoctrineUserRepository $userRepository, UserPasswordHasherInterface $encoder)
    {
        $this->userRepository = $userRepository;
        $this->encoder = $encoder;
    }

    public function __invoke(AddUserCommand $addUserCommand)
    {
        $email = $addUserCommand->getEmail();
        $roles =  $addUserCommand->getRoles();
        $password = $addUserCommand->getPassword();

        $hashedPassword =  $this->encoder->hashPassword(new DoctrineUser(), $password);

        $this->userRepository->create(
            new User(
                $email,
                $roles
            ),
            $hashedPassword
        );
    }

}