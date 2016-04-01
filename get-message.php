<?php
session_start();
require('ArtikCloudProxy.php');
$proxy = new ArtikCloudProxy();
$proxy->setAccessToken($_SESSION["access_token"]);
$messageCount = 1;
$response = $proxy->getMessagesLast(ArtikCloudProxy::DEVICE_ID, $messageCount);
header('Content-Type: application/json');
echo json_encode($response);
