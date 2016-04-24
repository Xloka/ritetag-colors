<?php

namespace Ritetag\API;
use Ritetag\API\OAuth\OAuthSignatureMethod_HMAC_SHA1;
use Ritetag\API\OAuth\OAuthConsumer;
use Ritetag\API\OAuth\OAuthUtil;
use Ritetag\API\OAuth\OAuthRequest;
/**
 * Description of Response
 *
 * @author Houžva Pavel <pavel@ritetag.com>
 */
class Client {

    private $host = "https://ritetag.com/";
    private $developmentHost = 'http://private-anon-49acc7b4c-ritetag.apiary-mock.com/';
    private $timeout = 30;
    private $connecttimeout = 30;
    private $sslVerifypeer = FALSE;
    private $useragent = 'RitetagClient v1.0.2';
    private $returnRequest = false;

    function accessTokenURL() {
        return 'https://ritetag.com/oauth/access_token';
    }

    function authorizeURL() {
        return 'https://ritetag.com/oauth/authorize';
    }

    function requestTokenURL() {
        return 'https://ritetag.com/oauth/request_token';
    }

    /**
     *
     * @param string $consumer_key
     * @param string $consumer_secret
     * @param string $oauth_token
     * @param string $oauth_token_secret
     */
    function __construct($consumer_key, $consumer_secret, $oauth_token = NULL, $oauth_token_secret = NULL, $testHost = false) {
        $this->sha1_method = new OAuthSignatureMethod_HMAC_SHA1();
        $this->consumer = new OAuthConsumer($consumer_key, $consumer_secret);
        if (!empty($oauth_token) && !empty($oauth_token_secret)) {
            $this->token = new OAuthConsumer($oauth_token, $oauth_token_secret);
        } else {
            $this->token = NULL;
        }
        if($testHost) {
            $this->host = $this->developmentHost;
        }
    }
    
    public function returnRequest($request=true){
        $this->returnRequest = $request;
    }
    
    /**
     * Get a request_token from Twitter
     *
     * @returns a key/value array containing oauth_token and oauth_token_secret
     */
    function getRequestToken($oauthCallback) {
        $parameters = array();
        $parameters['oauth_callback'] = $oauthCallback;
        $request = $this->oAuthRequest($this->requestTokenURL(), 'GET', $parameters);
        $token = OAuthUtil::parse_parameters($request);
        $this->token = new OAuthConsumer($token['oauth_token'], $token['oauth_token_secret']);
        return $token;
    }

    /**
     * Get the authorize URL
     *
     * @returns a string
     */
    function getAuthorizeURL($token) {
        if (is_array($token)) {
            $token = $token['oauth_token'];
        }
        return $this->authorizeURL() . "?oauth_token={$token}";
    }

    /**
     * Exchange request token and secret for an access token and
     * secret, to sign API calls.
     */
    function getAccessToken($oauth_verifier) {
        $parameters = array();
        $parameters['oauth_verifier'] = $oauth_verifier;
        $request = $this->oAuthRequest($this->accessTokenURL(), 'GET', $parameters);
        $token = OAuthUtil::parse_parameters($request);
        $this->token = new OAuthConsumer($token['oauth_token'], $token['oauth_token_secret']);
        return $token;
    }

    /**
     * get info about query
     * @param string $query
     * @return \Ritetag\API\Response
     */
    public function hashtagStats($query) {
        return $this->get("/api/v2.2/data/stats/" . urlencode($query));
    }

    /**
     * 
     * @param boolean $green
     * @param boolean $onlylatin
     * @return \Ritetag\API\Response|
     */
    public function trendingHashtags($green = false, $latin = false) {
        return $this->get("/api/v2.2/data/trending", ['green'=>$green,'latin'=>$latin]);
    }
    
    /**
     * 
     * @param string $hashtag
     * @return \Ritetag\API\Response
     */
    public function influencersForHashtag($hashtag) {
        return $this->get("/api/v2.2/data/influencers/" . urlencode($hashtag));
    }

    /**
     * 
     * @param string $hashtag
     * @return \Ritetag\API\Response
     */
    public function historicalData($hashtag) {
        return $this->get("/api/v2.2/data/history/" . urlencode($hashtag));
    }
    /**
     * 
     * @param string $tweet
     * @param boolean $image
     * @param array $networks TWITTER, FACEBOOK, GOOGLE_PLUS
     * @return \Ritetag\API\Response|\Ritetag\API\OAuth\OAuthRequest
     */
    public function tweetGrader($tweet,$image=false,array $networks=['twitter']) {
        return $this->get("/api/v2.2/ai/coach/", ['tweet' => ($tweet),'photo'=>(int)$image,'networks'=>$networks]);
    }
    
    /**
     * 
     * @param string $tweet
     * @param boolean $image
     * @return \Ritetag\API\Response
     */
    public function autoenhance($tweet, $image=false){
        return $this->get("/api/v2.2/ai/autoenhance/",['tweet'=>$tweet,'image'=>(int)$image]);
    }
    /**
     * GET request
     * @param string $url
     * @param array $parameters
     * @return \Ritetag\API\Response|\Ritetag\API\OAuth\OAuthRequest
     */
    private function get($url, $parameters = array()) {
        return $this->oAuthRequest($url, 'GET', $parameters);
    }

    /**
     * POST request
     * @param string $url
     * @param array $parameters
     * @return \Ritetag\API\Response
     */
    function post($url, $parameters = array()) {
        return $this->oAuthRequest($url, 'POST', $parameters);
    }

    /**
     *
     * @param strimg $url
     * @param array $parameters
     * @return \Ritetag\API\Response
     */
    private function put($url, $parameters = array()) {
        return $this->oAuthRequest($url, 'PUT', $parameters);
    }

    /**
     * DELETE request
     * @param string $url
     * @param array $parameters
     * @return \Ritetag\API\Response
     */
    private function delete($url, $parameters = array()) {
        return $this->oAuthRequest($url, 'DELETE', $parameters);
    }

    /**
     * sign request
     *
     * @param string $url
     * @param string $method
     * @param array $parameters
     * @return \Ritetag\API\Response
     */
    private function oAuthRequest($url, $method, $parameters) {
        if (strrpos($url, 'https://') !== 0 && strrpos($url, 'http://') !== 0) {
            $url = "{$this->host}{$url}";
        }
        $request = OAuthRequest::from_consumer_and_token($this->consumer, $this->token, $method, $url, $parameters);
        $request->sign_request($this->sha1_method, $this->consumer, $this->token);
        if($this->returnRequest){
            return $request;
        }
        switch ($method) {
            case 'GET':
                return $this->http($request->to_url(), 'GET');
            default:
                return $this->http($request->get_normalized_http_url(), $method, $request->to_postdata());
        }
    }

    /**
     *
     * @param string $url
     * @param string $method
     * @param array $postfields
     * @return \Ritetag\API\Response
     */
    private function http($url, $method, $postfields = NULL) {
        /* Curl settings */
        $ci = $this->curlSettings(curl_init());
        switch ($method) {
            case 'POST':
                curl_setopt($ci, CURLOPT_POST, TRUE);
                if (!empty($postfields)) {
                    curl_setopt($ci, CURLOPT_POSTFIELDS, $postfields);
                }
                break;
            case 'PUT':
                curl_setopt($ci, CURLOPT_CUSTOMREQUEST, 'PUT');
                if (!empty($postfields)) {
                    $url = "{$url}?{$postfields}";
                }
                break;
            case 'DELETE':
                curl_setopt($ci, CURLOPT_CUSTOMREQUEST, 'DELETE');
                if (!empty($postfields)) {
                    $url = "{$url}?{$postfields}";
                }
        }

        curl_setopt($ci, CURLOPT_URL, $url);
        $ret = curl_exec($ci);
        $statusCode = curl_getinfo($ci, CURLINFO_HTTP_CODE);
        $httpInfo = curl_getinfo($ci);
        list($headers, $content) = explode("\r\n\r\n", $ret, 2);
        $response = new Response($httpInfo, $this->getHeaders($headers), $content, $statusCode);
        curl_close($ci);
        return $response;
    }
    private function curlSettings($curl){
        curl_setopt($curl, CURLOPT_USERAGENT, $this->useragent);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $this->connecttimeout);
        curl_setopt($curl, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Expect:'));
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, $this->sslVerifypeer);
        curl_setopt($curl, CURLOPT_HEADER, true);
        return $curl;
    }
    /**
     * parse response header to array
     * @param string $header
     * @return array
     */
    private function getHeaders($header) {
        $headers = [];
        foreach (explode("\r\n", $header) as $i => $line)
            if ($i === 0)
                $headers['http_code'] = $line;
            else {
                list ($key, $value) = explode(': ', $line);
                $headers[$key] = $value;
            }
        return $headers;
    }

}
