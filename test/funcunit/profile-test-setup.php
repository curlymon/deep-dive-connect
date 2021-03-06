<?php
//path to mysqli class
require_once("/etc/apache2/capstone-mysql/ddconnect.php");
//require the classes you need
require_once("../../php/class/profile.php");
require_once("../../php/class/user.php");

// connect to mySQL
session_start();
$mysqli = MysqliConfiguration::getMysqli();
$password = "abc123";
//obtain user by email
$salt		= bin2hex(openssl_random_pseudo_bytes(32));
$authKey = bin2hex(openssl_random_pseudo_bytes(16));
$hash 	= hash_pbkdf2("sha512", $password, $salt, 2048, 128);
$user = new User(null, "foo@bar.com", $hash, $salt, $authKey, 1, null);
$user->insert($mysqli);
$userId = $user->getUserId();
$profile = new Profile(null, $userId, "Homer", "Simpson", "J", null, null, null, null, null);
$profile->insert($mysqli);
$profileId = $profile->getProfileId();
$_SESSION["profileId"] = $profileId;
$_SESSION["userId"]    = $userId;
echo "Setup seems to have worked OK";
?>