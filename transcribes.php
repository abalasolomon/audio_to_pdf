<?php

// Function to upload a local file to the AssemblyAI API
function upload_file($api_key, $path) {
    $url = 'https://api.assemblyai.com/v2/upload';
    $data = file_get_contents($path);

    $options = [
        'http' => [
            'method' => 'POST',
            'header' => "Content-type: application/octet-stream\r\nAuthorization: $api_key",
            'content' => $data
        ]
    ];

    $context = stream_context_create($options);
    $response = file_get_contents($url, false, $context);

    if (strpos($http_response_header[0], '200 OK') !== false) {
        $json = json_decode($response, true);
        return $json['upload_url'];
    } else {
        echo "Error: " . $http_response_header[0] . " - $response";
        return null;
    }
}

// Function to create a transcript using AssemblyAI API
function create_transcript($api_key, $audio_url) {
    $url = "https://api.assemblyai.com/v2/transcript";
    $headers = [
        "authorization: $api_key",
        "content-type: application/json"
    ];
    $data = [
        "audio_url" => $audio_url
    ];

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $response = json_decode(curl_exec($curl), true);
    curl_close($curl);

    $transcript_id = $response['id'];
    $polling_endpoint = "https://api.assemblyai.com/v2/transcript/$transcript_id";

    while (true) {
        $polling_response = curl_init($polling_endpoint);
        curl_setopt($polling_response, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($polling_response, CURLOPT_RETURNTRANSFER, true);

        $transcription_result = json_decode(curl_exec($polling_response), true);
        curl_close($polling_response);

        if ($transcription_result['status'] === "completed") {
            return $transcription_result;
        } elseif ($transcription_result['status'] === "error") {
            throw new Exception("Transcription failed: " . $transcription_result['error']);
        } else {
            sleep(3);
        }
    }
}

// Upload a file and create a transcript using the AssemblyAI API
try {
    $api_key = "b211463c6733450586c3f0feb10fbca3"; // Replace with your AssemblyAI API key

    if (isset($_FILES['audioFile']) && $_FILES['audioFile']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/';
        $file_tmp_path = $_FILES['audioFile']['tmp_name'];
        $file_name = $_FILES['audioFile']['name'];
        $file_path = $upload_dir . $file_name;

        // Create uploads directory if it doesn't exist
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // Move the uploaded file to the uploads directory
        if (move_uploaded_file($file_tmp_path, $file_path)) {
            $upload_url = upload_file($api_key, $file_path);

            if ($upload_url) {
                $transcript = create_transcript($api_key, $upload_url);
                echo "<h1>Transcription Result:</h1>";
                echo "<p>" . $transcript['text'] . "</p>";
            }
        } else {
            echo 'Error: Could not move the uploaded file.';
        }
    } else {
        echo 'Error: No file uploaded or there was an upload error.';
    }
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}

?>
