<?php
// Get JWT token from WordPress
$ch = curl_init("https://your-site.com/wp-json/jwt-auth/v1/token");


curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
    'username' => 'WP_USER',
    'password' => 'WP_PASSWORD'
]));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


$res = json_decode(curl_exec($ch), true);
$token = $res['token'] ?? '';


// Send request to Postiz using Postiz API key
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
