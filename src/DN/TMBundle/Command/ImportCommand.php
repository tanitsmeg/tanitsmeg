<?php

namespace DN\TMBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ImportCommand extends ContainerAwareCommand {

    private $loggingOn;
    
    public function __construct() {
        $this->loggingOn = true;
        
        parent::__construct();
    }   
    
    protected function configure() {
        $this
            ->setName('import')
            ->setDescription('Import from xml')
            ->addArgument('entity', InputArgument::OPTIONAL, 'Which entity do you want to import?')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        if ($this->loggingOn) {
            $output->writeln('start:.....' . date('h:i:s'));
        }
        
        $importEntities = $input->getArgument('entity');
        
        if ($importEntities) {
            $args = explode(',', str_replace('/\s+/', '', $importEntities));
            
            $is = $this->getApplication()->getKernel()->getContainer()->get('dn.tm.importservice');
            $us = $this->getApplication()->getKernel()->getContainer()->get('dn.tm.utilityservice');
            
            foreach ($args as $e) {
//            $output->writeln($e);
                $fn = 'import' . $e;
                $is->$fn($us);
            }
        } else {
            $output->writeln('please tell which entity you want to import! asshole!');
        }
        
        if ($this->loggingOn) {
            $output->writeln('finish:....' . date('h:i:s'));
        }
    }

}
