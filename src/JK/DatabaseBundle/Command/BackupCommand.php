<?php

namespace JK\DatabaseBundle\Command;

use Doctrine\DBAL\Connection;
use LogicException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
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
            ->addOption(
                'connection',
                'c',
                InputOption::VALUE_OPTIONAL,
                'The connection used to get the database configuration',
                null
            )
            ->addOption(
                'backup_directory',
                'dir',
                InputOption::VALUE_OPTIONAL,
                'The directory where the backup and archive are stored',
                null
            )
        ;
    }

    /**
     * Dump a database into a file, archive it and send it to a recipient.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var Connection $connection */
        $connection = $this
            ->container
            ->get('doctrine')
            ->getConnection($input->getOption('connection'))
        ;

        $backupDirectory = $input->getOption('backup_directory');

        if (!$backupDirectory) {
            $backupDirectory = $this
                ->container
                ->getParameter('jk_database.backup_directory');
        }

        if (!$backupDirectory) {
            throw new LogicException(
                'You must provide a backup directory, either in the configuration (jk_database.backup_directory, either in the command options (-dir)'
            );
        }
        $style = new SymfonyStyle($input, $output);

        $style->text('Backup database '.$connection->getDatabase().' ...');
        $backup = $this
            ->container
            ->get('jk.database.backup_manager')
            ->backup([
                'host' => $connection->getHost(),
                'name' => $connection->getDatabase(),
                'port' => $connection->getPort(),
                'user' => $connection->getUsername(),
                'password' => $connection->getPassword(),
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
