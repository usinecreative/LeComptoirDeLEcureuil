<?php

namespace BlueBear\CmsBundle\Command;

use BlueBear\CmsBundle\Entity\User;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class AddUserCommand extends Command implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    protected function configure()
    {
        $this
            ->setName('guard:user:add')
            ->setDescription('Add a user in database')
            ->addArgument('username', InputArgument::REQUIRED, 'User name')
            ->addArgument('password', InputArgument::REQUIRED, 'User password. It will be encoded')
            ->addArgument('email', InputArgument::REQUIRED, 'User email')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $user = new User();
        $user->setUsername($input->getArgument('username'));
        $user->setUsernameCanonical($input->getArgument('username'));

        $user->setEmail($input->getArgument('email'));
        $user->setEmailCanonical($input->getArgument('email'));
        $user->setRoles([
            'ROLE_USER',
            'ROLE_ADMIN',
        ]);
        $user->setSalt(base_convert(sha1(uniqid(mt_rand(), true)), 16, 36));
        $encoded = $this
            ->container
            ->get('security.password_encoder')
            ->encodePassword($user, $input->getArgument('password'));
        $user->setPassword($encoded);

        $this
            ->container
            ->get('jk.cms.user_repository')
            ->save($user);
    }
}
