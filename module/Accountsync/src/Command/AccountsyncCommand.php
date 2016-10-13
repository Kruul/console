<?php
namespace Accountsync\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Kruul\Logger\Logger;
use Accountsync\Model\AccountsyncMapper;

class AccountsyncCommand extends Command{

    public function __construct($container, $name = null){
      parent::__construct($name);
      $this->setContainer($container);
    }

    public function setContainer($container){
      $this->container=$container;
      return $this;
    }

  protected function configure(){
        $this->setName('accountsync')
             ->setDescription('Обновление лицевых счетов в личном кабинете')
              ->addOption( 'datebeg',  null, InputOption::VALUE_OPTIONAL,  'Дата начала YYYYMMDD')
              ->addArgument('dateend', InputArgument::OPTIONAL,'Дата окончания YYYYMMDD')
              ->addOption( 'logfile',   null, InputOption::VALUE_OPTIONAL,  'Путь к файлу протокола')
              ->setHelp(<<<EOT
  Обновление лицевых счетов в личном кабинете.
  Процесс: Выбирает новых клиентов заведенных в ОСС и обновляет  в личном кабинете на сайте telesystems.ua
  Необходимо для того, чтобы даже новые клиенты могли зайти в личный кабинет, оплатить в терминалах пополнения...

  Usage:
    <info>php $selfname accountsync [-datebeg] [-dateend]</info>
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

        $mapper=new AccountsyncMapper();
        $mapper->getNewClient();

  }
}

