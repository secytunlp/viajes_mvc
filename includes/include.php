<?php

session_start ();

/*
 - set session.use_trans_sid = 0 in /etc/php5/apache2/php.ini file.
 - Ensure you always use a new self generated session id on successful login attempt.
 - Try setting session.use_only_cookies = 1 and check if all works fine.
 - Use https throughout to ensure no one can sniff your session id.
 - Store session id, remote IP information and compare for successive pages
 */
if (! defined ( 'APP_NAME' ))
define ( 'APP_NAME', '/viajes_mvc/' );

if (! defined ( 'APP_PATH' ))
define ( 'APP_PATH', $_SERVER ['DOCUMENT_ROOT'] . APP_NAME );

if (! defined ( 'WEB_PATH' ))
define ( 'WEB_PATH', 'http://' . $_SERVER ['HTTP_HOST'] . APP_NAME );


include_once APP_PATH . 'conf/init.php';

?>