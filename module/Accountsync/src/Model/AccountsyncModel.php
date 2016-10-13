<?php
namespace Accountsync\Model;
use Accountsync\Model\AccountMapper;

class AccountsyncModel{
  private $Config;
  private $Mapper;
  private $Logger;    

  function __construct(){

  }

  function setMapper($mapper){
    $this->Mapper=$mapper;
  }

  function setConfig($config){
    $this->Config=$config;
  }

  function setLogger($logger){
   $this->Logger=$logger;
  }

}