<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Audio for Transcription</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h1>Upload Audio for Transcription</h1>
    <form id="uploadForm">
        <label for="audioFile">Choose an audio file:</label>
        <input type="file" name="audioFile" id="audioFile" accept="audio/*" required>
        <button type="submit">Upload and Transcribe</button>
    </form>
    <div id="result"></div>

    <script>
        $(document).ready(function() {
            $('#uploadForm').on('submit', function(event) {
                event.preventDefault();
                var formData = new FormData(this);

                $.ajax({
                    url: 'transcribe.php',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        console.log('success' + response)
                        $('#result').html('<h2>Transcription Result:</h2><p>' + response + '</p>');
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log('errorThrown' + errorThrown)
                        
                        $('#result').html('<h2>Error:</h2><p>' + errorThrown + '</p>');
                    }
                });
            });
        });
    </script>
</body>
</html>
