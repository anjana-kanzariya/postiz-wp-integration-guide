<?php
$apiKey = "YOUR_POSTIZ_API_KEY";
$payload = file_get_contents(__DIR__ . '/postiz-request.json');


$ch = curl_init("https://api.postiz.com/public/v1/posts");
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: $apiKey",
    "Content-Type: application/json"
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
echo $response;
