<?php

namespace App\JK\SmokerBundle\Command;

use App\JK\SmokerBundle\Url\Response\Registry\ResponseHandlerRegistry;
use Goutte\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
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

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Smoker Tests');

        $host = 'http://127.0.0.1:8000/index.php';

        $cacheFile = $this->cacheDir.'/smoker/smoker.cache';
        //$lineCount = $this->getLineCount($cacheFile);

        $handle = fopen($cacheFile, "r");
        $client = new Client();

        if ($handle) {
            $io->text('Start reading urls in cache...');
            //$io->progressStart($lineCount);

            while (($row = fgets($handle, 4096)) !== false) {
                $data = unserialize($row);
                $url = $host.$data['location'];
                $crawler = $client->request('get', $url);

                $routeName = $this->router->match($data['location']);

                foreach ($this->registry->all() as $responseHandler) {
                    if ($responseHandler->supports($routeName)) {

                    }
                }

                $io->text('Processing '.$url.'... [<info>OK</info>]');
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
