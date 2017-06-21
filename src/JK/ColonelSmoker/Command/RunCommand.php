<?php

namespace JK\ColonelSmoker\Command;

use JK\ColonelSmoker\Application;
use JK\ColonelSmoker\Handler\SuccessHandler;
use JK\ColonelSmoker\Provider\SymfonyRoutingProvider;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class RunCommand extends Command
{
    public function configure()
    {
        $this
            ->setName('smoker:run')
        ;
    }
    
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $style = new SymfonyStyle($input, $output);
        $style->title('Run the Colonel Smoker');
    
        $application = new Application();
        $application->addProvider(new SymfonyRoutingProvider());
        $application->addHandler(new SuccessHandler());
    
        $application->run();
    }
}
