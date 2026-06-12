<?php

// upload_logo.php
// Usage: php upload_logo.php

$apiUrl = 'http://localhost:8000/api/v1/settings/organization/logo';
$token = '33|iGDgSvGy78nci7I3VhyPECPBiuP3jdag3KF0QoCV84d49858';
$logoPath = __DIR__ . '/public/logo.png'; // Adjust if needed

if (!file_exists($logoPath)) {
    die("❌ Logo file not found at: $logoPath\n");
}

// Initialize cURL
$ch = curl_init();

// Prepare file for upload
$cFile = new CURLFile($logoPath, 'image/svg+xml', 'logo.png');

// POST data (multipart/form-data)
$postFields = [
    'logo' => $cFile,
];

curl_setopt_array($ch, [
    CURLOPT_URL => $apiUrl,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,           // Use POST (or PUT if endpoint expects PUT)
    CURLOPT_POSTFIELDS => $postFields,
    CURLOPT_HTTPHEADER => [
        'Authorization: Bearer ' . $token,
        'Accept: application/json',
    ],
    CURLOPT_VERBOSE => true,        // See detailed output
]);

// If the endpoint expects PUT instead of POST, uncomment:
// curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);

curl_close($ch);

echo "HTTP Status: $httpCode\n";
if ($error) {
    echo "cURL Error: $error\n";
} else {
    echo "Response:\n";
    echo $response . "\n";
}