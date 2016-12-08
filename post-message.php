<?php
session_start();

require('ArtikCloudProxy.php');
$proxy = new ArtikCloudProxy();
$proxy->setAccessToken($_SESSION["access_token"]);
$data ='{"stepCount":7994,"heartRate":100,"description":"Run","activity":2}'; // cloud.artik.example.activitytracker device type
$payload = '{"sdid":"'.ArtikCloudProxy::DEVICE_ID.'", "data":'.$data.'}';
$response = $proxy->sendMessage($payload);

header('Content-Type: application/json');
echo json_encode($response);
