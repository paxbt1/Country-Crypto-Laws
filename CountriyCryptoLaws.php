<?php

/*
 * Plugin Name:       Countries' Crypto Laws
 * Description:       Crypto news involving Countries
 * Version:           1.0.0
 * Author:            Saeed Ghourbanian
 * Text Domain:       ccl
 * Domain Path:       /languages
 */

// This line turns on strict type checking in PHP.
// This means that function arguments and return values must match their declared types, or a type error will occur.
declare(strict_types=1);

// If this file is called directly (e.g. not as part of a WordPress request), abort.
if (!defined('ABSPATH')) {
    die;
}

require_once 'vendor/autoload.php';

use GuzzleHttp\Client;
use ccl\countrycryptolaws\RestApiHandler;
use Dotenv\Dotenv;

// These lines instantiate the classes that define the custom post type and the shortcode.
$client = new Client();

$dotenv = Dotenv::createImmutable(__DIR__);
$envVars = $dotenv->load();

$listOfCountries = new RestApiHandler($envVars['CCL_REST_API_URL'], $client);

new ccl\countrycryptolaws\CountriesCryptoLawsPostType($listOfCountries->getList());
new ccl\countrycryptolaws\CountriesCryptoLawsShortCode();
