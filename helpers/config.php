<?php
/**
 * @Author: Oliver Bob Lagumen
 * @Date:   2017-05-15 20:52:34
 * @Last Modified by:   Oliver Bob Lagumen
 * @Last Modified time: 2017-05-15 21:22:41
 */

$whitelist = array(
    '127.0.0.1',
    '::1'
);

/*
[db]
host = 'aaruschoy8kxxj.cevucvqzkcim.us-east-1.rds.amazonaws.com'
user = 'namebrokersco'
pass = 'n4m3br0k3rs'
name = 'name_brokers_v2'
*/

if(!in_array($_SERVER['REMOTE_ADDR'], $whitelist)){
	define("DB_HOST", "aaruschoy8kxxj.cevucvqzkcim.us-east-1.rds.amazonaws.com'");
	define("DB_USER", "namebrokersco");
	define("DB_PASS", "n4m3br0k3rs");
	define("DB_NAME", "name_brokers_v2");
} else {
	define("DB_HOST", "localhost");
	define("DB_USER", "root");
	define("DB_PASS", "");
	define("DB_NAME", "name_brokers_v2");

	error_reporting(E_ALL & E_NOTICE);
}

?>