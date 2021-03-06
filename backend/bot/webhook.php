<?php

define("ROOT", dirname(__DIR__));

include(ROOT . '/vendor/autoload.php'); //Подключаем библиотеку

use Telegram\Bot\Api;
use Symfony\Component\Yaml\Yaml;

$config = Yaml::parse(file_get_contents(ROOT . '/config.yml'));
$api = new Api($config['token']);

$koshkaBot = new bot\KoshkaBot();

try {
	//error_log("WTF!!!?"); die();
	$koshkaBot->handleRequest($api);
} catch (Exception $e) {
	error_log($e->getMessage());
	error_log($e->getTraceAsString());
	echo $e->getMessage();
}
