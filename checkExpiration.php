<?php

/**
 Purchase Info URL: https://www.googleapis.com/androidpublisher/v1.1/applications/{packageName}/inapp/{productId}/purchases/{token}
 */

/*
    STEPS:
    1) Create Project
    2) Goto project : https://console.developers.google.com/iam-admin/serviceaccounts/project?project=bapdemo
    3) Create service account
    4) Download json
    5) "Enable API" => "Google Play Android Developer API" from: [https://developers.google.com/apis-explorer/?hl=en_US#p/androidpublisher/v2/]
    6) Give Administrator permission in setting google play to serviceaccount3@api-project-843344975567.iam.gserviceaccount.com [you gservice account where you have generated json file]
*/

/*
 * USEFUL Links :
 * http://stackoverflow.com/questions/25481207/why-getting-error-the-project-id-used-to-call-the-google-play-developer-api-has
 * http://stackoverflow.com/questions/24432825/permission-issue-google-play
 * http://stackoverflow.com/questions/25054919/get-android-subscription-status-failed-with-403
 * 
 * UPGRADE 1.0 library to 2.0
 * https://github.com/google/google-api-php-client/blob/master/UPGRADING.md#google_auth_assertioncredentials-has-been-removed
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once __DIR__.'/vendor/autoload.php';

/**
 * Initialization
 */
$package_name = "com.iMobDev.testinapp"; //Your package name (com.example...)
$subscriptionId = "com.imobdev.testinapp.basicmonthly";   //SKU of your subscription item
$token = "ninhhdcphghamdhbdmhnflmc.AO-J1Ow2gR5sEY24mhh1yk7VTIrI96rkYw4I9mLGVfjlVDkP_hZxsUGUKGDjCOAqzwq7ohT5EZBIGu8RXS1C5xZ6yFpvG5RFs1Hxmw0x48RcdaWPt28rfJZKskAJPrA5Y7W14xVh7YD3zi0mBedZCaFDGKttq_MLgw";
//token must be purchase token :)

$client = new Google_Client();
$client->setApplicationName("bapdemo"); //This is the name of the linked application
$client->setScopes(array('https://www.googleapis.com/auth/androidpublisher'));

$client->setAuthConfig('gpdemo.json');
putenv('GOOGLE_APPLICATION_CREDENTIALS=gpdemo.json');
$client->useApplicationDefaultCredentials();

$service = new Google_Service_AndroidPublisher($client);
$results = $service->purchases_subscriptions->get($package_name, $subscriptionId, $token, array());

date_default_timezone_set('Asia/Calcutta');

echo "START DATE: " . date("Y-m-d h:i a",($results->startTimeMillis) / 1000);
echo "<br>";
echo "END DATE:    " . date("Y-m-d h:i a",($results->expiryTimeMillis) / 1000);
echo "<br>";
echo "TOTAL PRICE COLLECTED:".($results->priceAmountMicros / 1000000);

echo "<br>Result Array:";
echo "<prE>";print_r($results);
exit;
