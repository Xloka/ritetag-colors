<?php
namespace Ritetag\API;
/**
 * Description of Response
 *
 * @author Houžva Pavel <pavel@ritetag.com>
 * @version 1.0.2
 */
class Response {
    private $httpInfo;
    
    private $header;
    private $body;
    
    private $statusCode;
    
    function __construct($httpInfo, $header, $body, $statusCode) {
        $this->httpInfo = $httpInfo;
        $this->header = $header;
        $this->body = $body;
        $this->statusCode = $statusCode;
    }
    
    public function getHttpInfo() {
        return $this->httpInfo;
    }

    public function getHeader() {
        return $this->header;
    }

    public function getBody() {
        return $this->body;
    }
    
    public function getJson(){
        return json_decode($this->body);
    }

    public function getStatusCode() {
        return $this->statusCode;
    }
}
