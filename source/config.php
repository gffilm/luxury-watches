<?php

set_time_limit(0);
ini_set('display_errors', 1);
define('ENVIRONMENT', 'localDatabase');
define('APPLICATION_ROOT', str_replace('\\', '/', getcwd()));
define('ASSETSTORE',       '/Development/personal/sites/luxuryWatches/trunk/source/static/');
define('DOWNLOADLOCATION', 'C:' . ASSETSTORE);

define('APP_DB_DRIVER',   'mysql');
define('APP_DB_HOSTNAME', '127.0.0.1');
define('APP_DB_USERNAME', 'root');
define('APP_DB_PASSWORD', '');
define('APP_DB_DATABASE', 'luxurywatches');

define('APP_DB_AUTOINIT', 'TRUE');
define('APP_DB_PORT',      3306);
define('APP_DB_DB_DEBUG',  TRUE);

?>
