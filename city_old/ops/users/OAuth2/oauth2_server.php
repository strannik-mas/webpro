<?php
ini_set('display_errors',1);error_reporting(E_ALL);
require_once('Autoloader.php');
OAuth2\Autoloader::register();
require('../user.class.php');

$dbParams = parse_ini_file('../../../common/conf.ini');
$dsn      = $dbParams['db.conn'];
$username = $dbParams['db.user'];
$password = $dbParams['db.pass'];

// $dsn is the Data Source Name for your database, for exmaple "mysql:dbname=my_oauth2_db;host=localhost"
$storage = new OAuth2\Storage\Pdo(array('dsn' => $dsn, 'username' => $username, 'password' => $password));
/*
echo "<pre>";
//var_dump($storage);
Reflection::export(new ReflectionClass($storage)); 
echo "</pre>";
exit();
*/


// Pass a storage object or array of storage objects to the OAuth2 server class
$server = new OAuth2\Server($storage);

// Add the "Client Credentials" grant type (it is the simplest of the grant types)
$server->addGrantType(new OAuth2\GrantType\ClientCredentials($storage));

// Add the "Authorization Code" grant type (this is where the oauth magic happens)
$server->addGrantType(new OAuth2\GrantType\AuthorizationCode($storage));

// create some users in memory
$user = new User();
$users = $user->getAllUsers();

// create a storage object
$storage = new OAuth2\Storage\Memory(array('user_credentials' => $users));

// create the grant type
$grantType = new OAuth2\GrantType\UserCredentials($storage);

// add the grant type to your OAuth server
$server->addGrantType($grantType);

// create the grant type
$grantTypeRefreshToken = new OAuth2\GrantType\RefreshToken($storage);

// add the grant type to your OAuth server
$server->addGrantType($grantTypeRefreshToken);

//$server->addGrantType(new OAuth2\GrantType\AuthorizationCode($storage));

?>