        const button = document.getElementById('click_to_convert');
        const output = document.getElementById('convert_text');
        const downloadBtn = document.getElementById('download_pdf');
        let recording = false;

        window.SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
        const recognition = new SpeechRecognition();
        recognition.interimResults = true;
        recognition.continuous = true; // Ensure continuous listening

        recognition.addEventListener('result', e => {
            const transcript = Array.from(e.results)
                .map(result => result[0])
                .map(result => result.transcript)
                .join('');
            output.value = transcript;
        });

        recognition.addEventListener('end', () => {
            if (recording) {
                recognition.start();
            }
        });

        button.addEventListener('click', function() {
            if (recording) {
                recognition.stop();
                button.textContent = 'Start Recording';
                if (output.value.trim() !== "") {
                    downloadBtn.style.display = 'block'; // Show download button if there is text
                } else {
                    downloadBtn.style.display = 'none'; // Hide download button if no text
                }
            } else {
                recognition.start();
                button.textContent = 'Stop Recording';
                downloadBtn.style.display = 'none'; // Hide download button when recording starts
            }
            recording = !recording;
        });

        downloadBtn.addEventListener('click', function() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            const transcriptionText = output.value; // Get the value of the textarea

            if (transcriptionText.trim() !== "") {
                // Split the text into lines for multi-page support
                const lines = doc.splitTextToSize(transcriptionText, 180); // Adjust line width as needed

                let y = 10;
                for (let i = 0; i < lines.length; i++) {
                    if (y > 280) { // Check if we need a new page
                        doc.addPage();
                        y = 10; // Reset y coordinate for the new page
                    }
                    doc.text(10, y, lines[i]);
                    y += 10; // Adjust line height as needed
                }

                doc.save('transcription.pdf');
            } else {
                alert('No text to convert to PDF.');
            }
        });