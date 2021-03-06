<?php

if (!defined(_ACCESS_FILE))
{
	header('HTTP/1.0 403 Forbidden');
	exit("direct access not permitted");
}

require_once ROOT . '/app/config/db.php';

$dsn      = _DRIVER . ':dbname=' . _BASE . ';host=' . _HOST;
$username = _USER;
$password = _PASSWORD;

// Autoloading (composer is preferred, but for this example let's just do this)
require_once ROOT . '/libs/OAuth2/Autoloader.php';

OAuth2\Autoloader::register();

// $dsn is the Data Source Name for your database, for exmaple "mysql:dbname=my_oauth2_db;host=localhost"
$storage = new OAuth2\Storage\Pdo(array('dsn' => $dsn, 'username' => $username, 'password' => $password));

// Pass a storage object or array of storage objects to the OAuth2 server class
$server = new OAuth2\Server($storage);

// Add the "Client Credentials" grant type (it is the simplest of the grant types)
$server->addGrantType(new OAuth2\GrantType\ClientCredentials($storage));

// Add the "Authorization Code" grant type (this is where the oauth magic happens)
$server->addGrantType(new OAuth2\GrantType\AuthorizationCode($storage));
