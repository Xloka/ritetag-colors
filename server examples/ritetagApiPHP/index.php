<?php
header("Access-Control-Allow-Origin: *");
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

require_once 'vendor/autoload.php';

require_once 'config.php';

if(isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER'])) {
  die("no referer");
  $ref = $_SERVER['HTTP_REFERER'];
  $refData = parse_url($ref);
  if ($refData['host'] !== DOMAIN) {
  	die("your domain is not permitted");	
  }
}


$client = new \Ritetag\API\Client(CONSUMER_KEY, CONSUMER_SECRET, OAUTH_TOKEN, OAUTH_TOKEN_SECRET);

$hashtags = json_decode($_GET['hashtags']);
$output = array();
foreach ($hashtags as $hashtag) {
	$data = json_decode($client->hashtagStats($hashtag)->getBody(),true);
    $output[] = $data['stats'];
}

echo json_encode($output);