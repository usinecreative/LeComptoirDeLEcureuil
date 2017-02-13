<?php

namespace JK\DatabaseBundle\Command;

use LogicException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class BackupCommand extends Command implements ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;
    
    protected function configure()
    {
        $this
            ->setName('jk:database:backup')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $host = $this
            ->container
            ->getParameter('database_host')
        ;
        $name = $this
            ->container
            ->getParameter('database_name')
        ;
        $port = $this
            ->container
            ->getParameter('database_port')
        ;
        $user = $this
            ->container
            ->getParameter('database_user')
        ;
        $password = $this
            ->container
            ->getParameter('database_password')
        ;
        $backupDirectory = '/home/johnkrovitch/Projects/LeComptoir/';
        $style = new SymfonyStyle($input, $output);
    
        $style->text('Backup database '.$name.' ...');
        $backup = $this
            ->container
            ->get('jk.database.backup_manager')
            ->backup([
                'host' => $host,
                'name' => $name,
                'port' => $port,
                'user' => $user,
                'password' => $password,
            ], $backupDirectory)
        ;
        $style->success('Backup done at '.$backup);
        $zipBackup = true;
        $sendArchive = true;
    
        if ($zipBackup) {
            $style->text('Archive backup...');
            
            $archive = $this
                ->container
                ->get('jk.database.archive_manager')
                ->archive($backup)
            ;
            $style->success('Archive done at '.$archive);
    
            if ($sendArchive) {
                $style->text('Sending archive...');
    
                $numberOfAttachmentSend = $this
                    ->container
                    ->get('jk.database.archive_manager')
                    ->send(
                        $archive,
                        'lecomptoirdelecureuil@gmail.com',
                        'afrezet@larriereguichet.fr',
                        '[BACKUP] Le Comptoir De L\'Ecureuil Backup',
                        'Hi<br/> Here is the backup for Le Comptoir De L\'Ecureuil'
                    )
                ;
    
                if (1 !== $numberOfAttachmentSend) {
                    throw new LogicException('An error has occurred during the mailing of the backup archive');
                }
                $style->success('Sending done...');
            }
        }
    }

    /**
     * Sets the container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}
