<?php
return  //Фабрики
  ['factories'=>[
     'dbcabinet'=>function($c) {
           $dbconf=$c->offsetget('config')['dbcabinet']; //Настройки БД
           return new \Kruul\Pdodb($dbconf);



      },
  ]];

