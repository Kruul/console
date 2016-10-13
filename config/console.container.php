<?php
/*
Name:   console.container.php
Author: Shvager Alexander
Email:  Alex.Shvager@gmail.com
*/

$version="0.1";
$name="console tools";
$config=array();

foreach (\glob('config/autoload/{{,*.}global,{,*.}local}.php', GLOB_BRACE) as $file) {
  $config = array_merge_recursive($config, include $file);
}

$container = new \Pimple\Container($config);
$container['config'] = $config;
$container['console.application']=function($container) {

if (isset($container['config']['factories'])){
  foreach ($container['config']['factories'] as $name=>$callable){
    if ($callable instanceof Closure) {
      if (isset($container[$name])) continue;
      $container[$name]=$container->factory($callable);
    } else $container[$name]=new $callable();
  }
}

if (isset($container['config']['services'])){
  foreach ($container['config']['services'] as $name=>$callable){
    if ($callable instanceof Closure) {
      if (isset($container[$name])) continue;
      $container[$name]=$callable;
    }
  }
}

$app=new \Symfony\Component\Console\Application("console tools", "0.1");
  if (is_array($container['config']['console']['command'])) {
    foreach ($container['config']['console']['command'] as $name=>$command){
      $app->add(new $command($container));
    };
  }
  return $app;
};

return $container;
