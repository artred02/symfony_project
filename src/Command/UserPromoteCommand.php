<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:user:promote',
    description: 'promote an user to admin',
)]

class UserPromoteCommand extends Command
{
    private $om;

    public function __construct(EntityManagerInterface $om)
    {
        $this->om = $om;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Promote a user by adding him a new roles.')
            ->addArgument('username', InputArgument::REQUIRED, 'username of user')
            ->addArgument('roles', InputArgument::REQUIRED, 'role of user')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $username = $input->getArgument('username');
        $roles = $input->getArgument('roles');


        $userRepository = $this->om->getRepository(User::class);
        $user = $userRepository->findOneByUsername($username);


        if ($user) {
            $user->addRoles($roles);
            $this->om->flush();

            $io->success('The roles has been successfully added to the user.');
        }else{
            $io->error('There is no user with that username.');
        }

        return 0;
    }
}
