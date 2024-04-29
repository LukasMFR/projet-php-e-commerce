<?php
// Code utilsé pour afficher les erreurs et les debugs
ini_set('display_errors', 1);
error_reporting(E_ALL);
$db_name = 'mysql:host=localhost;dbname=autocar';
$db_user = 'root';
$db_password = '';

$conn = new PDO($db_name, $db_user, $db_password);


function unique_id()
{
	$chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charLength = strlen($chars);
	$randomString = '';
	for ($i = 0; $i < 20; $i++) {
		$randomString .= $chars[mt_rand(0, $charLength - 1)];
	}
	return $randomString;
}
?>