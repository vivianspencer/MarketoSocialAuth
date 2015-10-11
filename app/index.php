<?php
require_once '../vendor/autoload.php';

use HumanNameParser\Parser;

$root_dir = dirname(__DIR__);

/**
 * Use Dotenv to set required environment variables and load .env file in root
 */
$dotenv = new Dotenv\Dotenv($root_dir);
if (file_exists($root_dir . '/.env')) {
	$dotenv->load();
	$dotenv->required(['SITE_URL']);
}

// Fetch the configuration settings
$config = require_once 'config.php';

// Initialise the Slim framework
$app = new \Slim\Slim(array(
	'mode' => getenv("ENVIRONMENT")
));

// Only invoked if mode is "production"
$app->configureMode('production', function () use ($app, &$config) {
	$app->config(array(
		'log.enable' => true,
		'debug' => false
	));

	$config['debug_mode'] = false;
});

// Only invoked if mode is "development"
$app->configureMode('development', function () use ($app, &$config, $root_dir) {
	$app->config(array(
		'log.enable' => false,
		'debug' => true
	));

	$config['debug_mode'] = true;
	$config['debug_file'] = $root_dir .'/debug.log';
});

// Return an instance of HybridAuth
$app->container->singleton('hybridInstance', function () use ($config) {
	$instance = new Hybrid_Auth($config);

	return $instance;
});

// Return an instance of NameParser
$app->container->singleton('parserInstance', function () {
	$instance = new Parser();

	return $instance;
});

$app->get( '/', function () use ( $app ) {
	if (isset($_REQUEST['hauth_start']) || isset($_REQUEST['hauth_done'])) {
		Hybrid_Endpoint::process();
	}

});

// Redirect to network for authentication
$app->get('/authenticate/:network', function ($network) use ($app) {
	try {
		$adapter      = $app->hybridInstance->authenticate( ucwords( $network ) );
		$user_profile = $adapter->getUserProfile();

		if (empty( $user_profile )) {
			return false;
		}
		else {
			$output = $user_profile;

			// Split the name into first/last name if the network only supports full name
			if ($network == 'twitter') {
				$name = $app->parserInstance->parse( $user_profile->firstName );

				$output->firstName = $name->getFirstName();
				$output->lastName = $name->getLastName();
			}

			echo json_encode( $output );
		}

	} catch ( Exception $e ) {
		echo json_encode( array( 'error' => $e->getMessage() ) );
	}
});

$app->run();