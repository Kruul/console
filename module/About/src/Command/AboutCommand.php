<?php
namespace About\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


class AboutCommand extends Command{

    public function __construct($container, $name = null){
      parent::__construct($name);
      $this->setContainer($container);
    }

    public function setContainer($container){
      $this->container=$container;
      return $this;
    }

  protected function configure(){
        $this->setName('about')
             ->setDescription('О программе')
              ->addOption( 'datebeg',  null, InputOption::VALUE_OPTIONAL,  'Дата начала YYYYMMDD')
              ->addArgument('dateend', InputArgument::OPTIONAL,'Дата окончания YYYYMMDD')
              ->addOption( 'logfile',   null, InputOption::VALUE_OPTIONAL,  'Путь к файлу протокола')
              ->setHelp(<<<EOT
			\rО программе
			\rUsage:
			\r<info>php $selfname about</info>
EOT
                       );
  }

  protected function execute(InputInterface $in, OutputInterface $out){ 
        $log=new Logger();
        if ($in->getOption('logfile')) $log->addWriter(new FileWriter($in->getOption('logfile')));
	if ($out->isVeryVerbose() || $out->isDebug())  $log->addWriter(new SymfonyConsoleWriter($out));

        $datebeg = $in->getOption('datebeg');
        if (!$datebeg) $datebeg=date('Ymd');
        $out->writeln($datebeg);        

  }
}

