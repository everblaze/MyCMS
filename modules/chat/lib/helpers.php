<?php
# @Author: Oliver Bob R. Lagumen <root>
# @Date:   2017-06-23T14:44:23+08:00
# @Email:  oliverbob@facegod.us
# @Project: NameBrokers
# @Last modified by:   root
# @Last modified time: 2017-06-26T11:36:50+08:00

/**
* Created by Oliver Bob Lagumen
* For RushMedia Solutions
* Wednesday, 08, June, 2017
* Project: namebrokers.com
*/

error_reporting('E_ALL & ~E_NOTICE');
ini_set('display_errors', 0);


require_once '../../../helpers/MysqliDb.php';

//$db = new Mysqlidb ($conf['db']['host'], $conf['db']['user'], $conf['db']['pass'], $conf['db']['name']);

/**
 * Generate and return a random string
 *
 * The default string returned is 8 alphanumeric characters.
 *
 * The type of string returned can be changed with the "seeds" parameter.
 * Four types are - by default - available: alpha, numeric, alphanum and hexidec.
 *
 * If the "seeds" parameter does not match one of the above, then the string
 * supplied is used.
 *
 */

function str_rand($length = 8, $seeds = 'numeric'){
    // Possible seeds
    $seedings['alpha'] = 'abcdefghijklmnopqrstuvwqyz';
    $seedings['numeric'] = '0123456789';
    $seedings['alphanum'] = 'abcdefghijklmnopqrstuvwqyz0123456789';
    $seedings['hexidec'] = '0123456789abcdef';

    // Choose seed
    if (isset($seedings[$seeds])) {
        $seeds = $seedings[$seeds];
    }

    // Seed generator
    list($usec, $sec) = explode(' ', microtime());
    $seed = (float) $sec + ((float) $usec * 100000);
    mt_srand($seed);

    // Generate
    $str = '';
    $seeds_count = strlen($seeds);

    for ($i = 0; $length > $i; $i++) {
        $str .= $seeds{mt_rand(0, $seeds_count - 1)};
    }

    return $str;
}

function cleanText($text){
    return htmlentities($text, ENT_QUOTES, "utf-8");
}

function decodeClean($text){
    return html_entity_decode($text, ENT_QUOTES, "utf-8");
}

function shorten($string){
	$string = preg_replace("/<([a-z][a-z0-9]*)[^>]*?(\/?)>/i",'<$1$2>', $string);
	$str = strip_tags(decodeClean($string));
	$text = substr($str, 0, 40);
	$text = preg_replace( "/[^a-z0-9]/i", " ", $text);
	$text = "\"".trim($text)."...\"";
	return $text;
}


?>
