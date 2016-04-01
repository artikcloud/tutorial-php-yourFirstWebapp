<?php
/**
 * ARTIK Cloud helper class that communicates to ARTIK Cloud via ARTIK Cloud PHP SDK
 * */
require_once(dirname(__FILE__) .'/sdk/Swagger.php');
swagger_autoloader('MessagesApi');

class ArtikCloudProxy {
    # General Configuration
    const CLIENT_ID = "xxxxx";
    const DEVICE_ID = "xxxxx";
    const API_URL = "https://api.artik.cloud/v1.1";
 
    # Members
    public $token = null;
    public $apiClient = null; 

    public function __construct(){ }
     
    /**
     * Sets the access token and looks for the user profile information
     */
    public function setAccessToken($someToken){
      $this->token = $someToken;
      $authHeader = 'bearer ' .$this->token;
      $this->apiClient = new APIClient(ArtikCloudProxy::CLIENT_ID, ArtikCloudProxy::API_URL, $authHeader);
    }
     
    /**
     * GET /historical/normalized/messages/last API
     */
    public function getMessagesLast($srcDeviceId, $countByDevice){
      try {
      	$callAPI = new MessagesApi($this->apiClient);
      	$method = 'getNormalizedMessagesLast';
      	$params = array(
      			"sdids"         => $srcDeviceId,
      			"fieldPresence" => NULL,
      			"count"         => $countByDevice
      	);
      	$result = call_user_func_array(array($callAPI, $method), array_values($params));
      } catch (Exception $e) {
      	$result = '{"getMessageLast_exception":"'.$e->getMessage().'"}';
      }
      return $result;
    }
    
    /**
     * POST /message API
     */
    public function sendMessage($payload){
      try {
    	  $callAPI = new MessagesApi($this->apiClient);
        $method = 'postMessage';
        $params = array(
       		"postParams" => $payload,
          );
        
    	  $result = call_user_func_array(array($callAPI, $method), array_values($params));
    	} catch (Exception $e) {
          $result = "{sendMessage_exception:".$e->getMessage()."}";
    	}
        return $result;
    }
    
}