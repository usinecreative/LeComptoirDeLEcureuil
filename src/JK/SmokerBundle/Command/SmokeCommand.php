<?php

namespace App\JK\SmokerBundle\Command;

use App\JK\SmokerBundle\Exception\Exception;
use App\JK\SmokerBundle\Response\Registry\ResponseHandlerRegistry;
use Goutte\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Routing\RouterInterface;

class SmokeCommand extends Command
{
    protected static $defaultName = 'smoker:smoke';

    /**
     * @var string
     */
    protected $cacheDir;

    /**
     * @var ResponseHandlerRegistry
     */
    protected $registry;

    /**
     * @var RouterInterface
     */
    protected $router;

    /**
     * SmokeCommand constructor.
     *
     * @param string                  $cacheDir
     * @param ResponseHandlerRegistry $registry
     * @param RouterInterface         $router
     */
    public function __construct(string $cacheDir, ResponseHandlerRegistry $registry, RouterInterface $router)
    {
        parent::__construct();

        $this->cacheDir = $cacheDir;
        $this->registry = $registry;
        $this->router = $router;
    }

    protected function configure()
    {
        $this
            ->addOption(
                'stop-on-failure',
                null,
                InputOption::VALUE_OPTIONAL,
                'Stop all tests if an error is detected',
                false
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Smoker Tests');

        $host = 'http://127.0.0.1:8000/index.php';
        $cacheFile = $this->cacheDir.'/smoker/smoker.cache';

        if (!file_exists($cacheFile)) {
            $io->warning('The cache file is not generated. Nothing will be done.');
            $io->note('The cache can be generated with the command bin/console smoker:generate-cache');

            return;
        }

        $handle = fopen($cacheFile, "r");


        if ($handle) {
            $io->text('Start reading urls in cache...');

            while (($row = fgets($handle, 4096)) !== false) {
                $client = new Client();
                $data = unserialize($row);
                $url = $host.$data['location'];
                $io->write('Processing '.$url.'...');
                $crawler = $client->request('get', $url);

                $routeInfo = $this->router->match($data['location']);

                foreach ($this->registry->all() as $responseHandlerName => $responseHandler) {

                    if ($responseHandler->supports($routeInfo['_route'])) {
                        try {
                            $responseHandler->handle($routeInfo['_route'], $crawler, $client);
                        } catch (Exception $exception) {
                            $io->note('Error in '.$responseHandlerName);

                            if (true === (bool)$input->getOption('stop-on-failure')) {
                                throw $exception;
                            }
                            $io->error($exception->getMessage());
                        }

                    }
                }
                $io->write('...[<info>OK</info>]');
                $io->newLine();


                //$io->progressAdvance();
            }
            //$io->progressFinish();

            if (!feof($handle)) {
                echo "Erreur: fgets() a échoué\n";
            }
            fclose($handle);
        }
    }

    protected function getLineCount(string $cacheFile)
    {
        $count = 0;
        $handle = fopen($cacheFile, "r");

        if ($handle) {
            while (($row = fgets($handle, 4096)) !== false) {
                $count++;
            }

            if (!feof($handle)) {
                echo "Erreur: fgets() a échoué\n";
            }
            fclose($handle);
        }

        return $count;
    }
}
