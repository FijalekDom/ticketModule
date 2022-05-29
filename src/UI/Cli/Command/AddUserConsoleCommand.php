<?php

namespace App\UI\Cli\Command;

use App\Application\Command\AddUserCommand;
use App\Domain\Constant\UserRole;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class AddUserConsoleCommand extends Command
{
    protected static $defaultName = 'admin:user:add';
    private MessageBusInterface $messageBus;

    public function __construct(MessageBusInterface $messageBus)
    {
        parent::__construct(null);
        $this->messageBus = $messageBus;
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Adding a new user.')
            ->addArgument('email', InputArgument::REQUIRED, 'The email (login) of the user.')
            ->addArgument('password', InputArgument::REQUIRED, 'The password of the user.')
            ->addArgument('role', InputArgument::REQUIRED, 'User role');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $email = $input->getArgument('email');
        $password = $input->getArgument('password');
        $roles[] = $input->getArgument('role');

        $this->messageBus->dispatch(new AddUserCommand($email, $password, $roles));

        return Command::SUCCESS;
    }

}