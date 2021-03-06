<?php
/**
 * Created in collaboration by:
 *
 * @author Gerardo Medrano <GMedranoCode@gmail.com>
 * @author Marc Hayes <Marc.Hayes.Tech@gmail.com>
 * @author Steven Chavez <schavez256@yahoo.com>
 * @author Joseph Bottone <hi@oofolio.com>
 *
 */
session_start();
//path to mysqli class
require_once("/etc/apache2/capstone-mysql/ddconnect.php");

//require the classes you need
require_once("php/class/profile.php");
require_once("php/class/user.php");
require_once("php/class/security.php");

// connect to mySQL
$mysqli = MysqliConfiguration::getMysqli();

$password = "abc123";

//obtain user by email
$salt		= bin2hex(openssl_random_pseudo_bytes(32));
$authKey = bin2hex(openssl_random_pseudo_bytes(16));
$hash 	= hash_pbkdf2("sha512", $password, $salt, 2048, 128);


$user = new User(null, "schavez256@yahoo.com", $hash, $salt, $authKey, 4, null);
$user->insert($mysqli);
$userId = $user->getUserId();

$profile = new Profile(null, $userId, "Steven", "Chavez", "M", null, null, null, null, null);
$profile->insert($mysqli);

$security = Security::getSecurityBySecurityId($mysqli, $user->getSecurityId());

$profileId = $profile->getProfileId();

$_SESSION["profile"]["profileId"] = $profile->getProfileId();
$_SESSION["profile"]["firstName"] = $profile->getFirstName();
$_SESSION["profile"]["lastName"] = $profile->getLastName();
$_SESSION["profile"]["description"]= $profile->getDescription();
$_SESSION["profile"]["location"]= $profile->getLocation();
$_SESSION["security"]["description"] = $security->getDescription();
$_SESSION["security"]["createTopic"] = $security->getCreateTopic();
$_SESSION["security"]["canEditOther"] = $security->getCanEditOther();
$_SESSION["security"]["canPromote"] = $security->getCanPromote();
$_SESSION["security"]["siteAdmin"] = $security->getSiteAdmin();

echo "<form action=\"index.php\" method=\"POST\"><button type=\"submit\">Submit</button></form>";