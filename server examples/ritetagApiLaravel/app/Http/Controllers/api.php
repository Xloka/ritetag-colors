<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Ritetag\API\Client;

class api extends Controller
{
    public function index()
    {
    		$consumer_key       = config('ritetag.consumer_key');
            $consumer_secret    = config('ritetag.consumer_secret');
            $oauth_token        = config('ritetag.oauth_token');
            $oauth_token_secret = config('ritetag.oauth_token_secret');
            $domain = config('ritetag.domain');
            if(isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER'])) {
              die("no referer");
              $ref = $_SERVER['HTTP_REFERER'];
              $refData = parse_url($ref);
              if ($refData['host'] !== $domain) {
                die("your domain is not permitted");    
              }
            }
            $client = new Client($consumer_key, $consumer_secret, $oauth_token, $oauth_token_secret);
	        $hashtags = json_decode($_GET['hashtags']);
	        $output = array();
	        foreach ($hashtags as $hashtag) {
	            $data = json_decode($client->hashtagStats($hashtag)->getBody(),true);
	            $output[] = $data['stats'];
	        }

	        echo json_encode($output);
    }
}
