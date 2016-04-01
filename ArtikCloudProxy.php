<?php
/**
 * ARTIK Cloud helper class that communicates to ARTIK Cloud
 * */
class ArtikCloudProxy {
    # General Configuration
    const CLIENT_ID = "xxxxx";
    const DEVICE_ID = "xxxxx";
    const API_URL = "https://api.artik.cloud/v1.1";
 
    # API paths
    const API_USERS_SELF = "/users/self";
    const API_MESSAGES_LAST = "/messages/last?sdids=<DEVICES>&count=<COUNT>"; 
    const API_MESSAGES_POST = "/messages";
     
    # Members
    public $token = null;
    public $user = null;
     
    public function __construct(){ }
     
    /**
     * Sets the access token and looks for the user profile information
     */
    public function setAccessToken($someToken){
        $this->token = $someToken;
        $this->user = $this->getUsersSelf();
    }
     
    /**
     * API call GET
     */
    public function getCall($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPGET, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization:bearer '.$this->token));
        $json = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if($status == 200){
            $response = json_decode($json);
        }
        else{
            var_dump($json);
        	$response = $json;
        }

       return $response;
    }
     
    /**
     * API call POST
     */
    public function postCall($url, $payload){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, (String) $payload);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: bearer '.$this->token));
        $json = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if($status == 200){
            $response = json_decode($json);
        }
        else{
            var_dump($json);
            $response = $json;
        }
        return $response;
    }
     
    /**
     * GET /users/self API
     */
    public function getUsersSelf(){
        return $this->getCall(ArtikCloudProxy::API_URL . ArtikCloudProxy::API_USERS_SELF);
    }
     
    /**
     * POST /message API
     */
    public function sendMessage($payload){
        return $this->postCall(ArtikCloudProxy::API_URL . ArtikCloudProxy::API_MESSAGES_POST, $payload);
    }
     
    /**
     * GET /historical/normalized/messages/last API
     */
    public function getMessagesLast($deviceCommaSeparatedList, $countByDevice){
        $apiPath = ArtikCloudProxy::API_MESSAGES_LAST;
        $apiPath = str_replace("<DEVICES>", $deviceCommaSeparatedList, $apiPath);
        $apiPath = str_replace("<COUNT>", $countByDevice, $apiPath);
        return $this->getCall(ArtikCloudProxy::API_URL.$apiPath);
    }
}