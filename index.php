<?php
require 'vendor/autoload.php';          // composer dependencies
require 'config.php';                   // config variables
require 'dbconnect.php';                // db_connect function
require 'routes/heartrate.router.php';  // heart rate router

$app = new \Slim\Slim();

// Send back JSON by default
$app->response->headers->set('Content-Type', 'application/json');

/**
 * @api {get} /heartrate/ Request user heart rate data
 * @apiName GetHeartRate
 * @apiGroup HeartRate
 *
 * @apiSuccess {Object[]} heartrate             List of user heart rates.
 * @apiSuccess {Number}   heartrate.id          Entry id.
 * @apiSuccess {String}   heartrate.timestamp   Timestamp of entry.
 * @apiSuccess {Number}   heartrate.heartrate   Heart rate value.
 *
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 200 OK
 *     [
 *       {
 *         "id": "1",
 *         "timestamp": "2018-05-29 21:29:05",
 *         "heartrate": "102"
 *       },
 *       {
 *         "id": "2",
 *         "timestamp": "2018-05-29 21:40:23",
 *         "heartrate": "98"
 *       }
 *     ]
 *
 */
$app->get('/heartrate/', 'getHeartrate');

// API_KEY authorization
$app->hook('slim.before.dispatch', function () use ($app){
  $headers = request_headers();
  $response = array();
  $app = \Slim\Slim::getInstance();
  $api_key = $headers['X-API-KEY'];

  if($api_key == API_KEY) {
    $authorized = true;
  } else if ($api_key == NULL) {
    $response["error"] = true;
    $response["message"] = '{"error":{"text": "api key not sent" }}';
    $app->response->headers['X-Authenticated'] = 'False';
    $authorized = false;
    $app->halt(401, $response['message']);
  } else {
    $response["error"] = true;
    $response["message"] = '{"error":{"text": "api key invalid" }}';
    $app->response->headers['X-Authenticated'] = 'False';
    $authorized = false;
  }
  echo "Authorized? $authorized";
  if(!$authorized){ //key is false
    // dont return 403 if you request the home page
    $req = $_SERVER['REQUEST_URI'];
    if ($req != "/") {
      $app->halt('403', $response['message']);
    }
  }

});

function request_headers() {
  $arh = array();
  $rx_http = '/\AHTTP_/';
  foreach($_SERVER as $key => $val) {
    if( preg_match($rx_http, $key) ) {
      $arh_key = preg_replace($rx_http, '', $key);
      $rx_matches = array();
      // do string manipulations to restore the original letter case
      $rx_matches = explode('_', $arh_key);
      if( count($rx_matches) > 0 and strlen($arh_key) > 2 ) {
        foreach($rx_matches as $ak_key => $ak_val) $rx_matches[$ak_key] = ucfirst($ak_val);
        $arh_key = implode('-', $rx_matches);
      }
      $arh[$arh_key] = $val;
    }
  }
  return( $arh );
}

$app->run();
