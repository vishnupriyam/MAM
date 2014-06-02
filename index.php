<?php

// change the following paths if necessary
$yii=dirname(__FILE__).'/../yii/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
Yii::createWebApplication($config)->run();

/*
//for log4php
require_once($yii);
$app = Yii::createWebApplication($config);
spl_autoload_unregister(array('YiiBase','autoload'));
require_once('/protected/vendors/log4php/main/php/Logger.php');//require register logger autoload
spl_autoload_register(array('YiiBase','autoload'));
$app->run();
//$logger = Logger::getLogger('');
//$logger->info('It works');
*/