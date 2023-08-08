<?php

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';
require __DIR__ . '/../config/vars.php';

$config = require __DIR__ . '/../config/web.php';

$application = Yii::createObject('yii\web\Application', ['config'=>$config]);

// make PHP use the same timezone as Yii2
date_default_timezone_set(APP_TIMEZONE);

$application->run();