<?php
// Start Server Session
session_start();

// Display All Errors (For Easier Development)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include cURL object file
require 'includes/curl.class.php';

// Ensure the access token is available
if (!isset($_SESSION['google_access_tokens']['access_token'])) {
    die(json_encode(['error' => 'Access token not available']));
}

// Check if the file was uploaded without errors
if (isset($_FILES['audioFile']) && $_FILES['audioFile']['error'] == UPLOAD_ERR_OK) {
    // Get file content
    $fileTmpPath = $_FILES['audioFile']['tmp_name'];
    $fileContent = file_get_contents($fileTmpPath);

    // Initiate cURL Server object
    $_cURL = new CurlServer($_SESSION['google_access_tokens']['access_token']);

    // Generate parameters for API request
    $parameters = json_encode([
        "config" => [
            "encoding" => "WEBM_OPUS",
            "languageCode" => "en-US",
            "sampleRateHertz" => 48000,
            "audioChannelCount" => 1,
            "alternativeLanguageCodes" => [],
            "speechContexts" => [],
            "adaptation" => [
                "phraseSets" => [],
                "phraseSetReferences" => [],
                "customClasses" => []
            ],
            "enableWordTimeOffsets" => true,
            "enableWordConfidence" => true,
            "model" => "default"
        ],
        "audio" => [
            "content" => base64_encode($fileContent)
        ]
    ]);

    // Make the API request
    $response = $_cURL->post_request("https://speech.googleapis.com/v1p1beta1/speech:recognize", $parameters);

    // Check if the response is valid
    if (!$response || !isset($response->results[0]->alternatives[0]->transcript)) {
        die(json_encode(['error' => 'Failed to retrieve transcription']));
    }

    // Prepare the response
    $async_response = new stdClass();
    $async_response->response_received_data = 'Audio data was received';
    $async_response->response_received_transcript = $response->results[0]->alternatives[0]->transcript;

    // Send the response back as JSON
    echo json_encode($async_response);
} else {
    echo json_encode(['error' => 'No audio file uploaded or upload error occurred']);
}
?>
