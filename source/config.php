<?php

set_time_limit(0);
ini_set('display_errors', 1);
define('ENVIRONMENT', 'localDatabase');
define('APPLICATION_ROOT', str_replace('\\', '/', getcwd()));
define('ASSETSTORE',       '/Development/cascade/localCourses/packman/assetstore/');
define('DOWNLOADLOCATION', 'C:'.ASSETSTORE);
define('COURSE_PATH',      '/Development/cascade/localCourses/');
define('TWENTY_HOST',      '20.corpedia.com');
define('TWENTY_USER_NAME', 'pacman');
define('TWENTY_PASSWORD',  'N4N4N4N4P4cM4n');
define('AUDIO',             0);
define('DEV_ENVIRONMENT',   false);

define('APP_DB_DRIVER',   'mysql');
define('APP_DB_HOSTNAME', '127.0.0.1');
define('APP_DB_USERNAME', 'root');
define('APP_DB_PASSWORD', '');
define('APP_DB_DATABASE', 'luxurywatches');

define('APP_DB_AUTOINIT', 'TRUE');
define('APP_DB_PORT',      3306);
define('APP_DB_DB_DEBUG',  TRUE);

?>
