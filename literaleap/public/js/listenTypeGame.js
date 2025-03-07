let listenAndTypeGame = function (p) {
    // Array of words with placeholders for the corresponding audio files.
    let words = [
        { word: "apple", audio: null },
        { word: "orange", audio: null },
    ];

    let currentWordIndex = 0;
    let userInput = "";
    let feedback = "";
    let replayButton; // Button to replay the current audio

    // Preload audio files from the public audio folder.
    p.preload = function () {
        words[0].audio = p.loadSound("/audio/apple.mp3");
        words[1].audio = p.loadSound("/audio/orange.mp3");
    };

    p.setup = function () {
        // Create the canvas and attach it to the container.
        let canvas = p.createCanvas(570, 400);
        canvas.parent('game-container');
        p.textSize(32);
        p.textAlign(p.CENTER, p.CENTER);

        // Create the "Replay Audio" button and attach it to the container.
        replayButton = p.createButton("Replay Audio");
        replayButton.parent('game-container');
        // Positioning the button. Adjust values as needed.
        replayButton.position(350, 420);
        replayButton.mousePressed(function () {
            if (words[currentWordIndex] && words[currentWordIndex].audio) {
                words[currentWordIndex].audio.play();
            }
        });

        // Play the first word's audio.
        if (words[currentWordIndex].audio) {
            words[currentWordIndex].audio.play();
        }
    };

    p.draw = function () {
        p.background(220);
        p.fill(0);

        // Display title and instructions.
        p.text("Listen & Type - Audio Spelling Game", p.width / 2, 50);
        p.text("Type what you heard and press ENTER", p.width / 2, 100);

        // Show the user's current input.
        p.text("Your Input: " + userInput, p.width / 2, 200);
        // Display feedback for the answer.
        p.text(feedback, p.width / 2, 300);
    };

    // Capture character input.
    p.keyTyped = function () {
        // Append the typed character to the userInput.
        userInput += p.key;
    };

    // Handle special keys: BACKSPACE for deleting and ENTER for submitting.
    p.keyPressed = function () {
        if (p.keyCode === p.BACKSPACE) {
            userInput = userInput.substring(0, userInput.length - 1);
            return false;
        }

        if (p.keyCode === p.ENTER) {
            // Check if the user input matches the current word (ignoring case).
            if (
                userInput.toLowerCase() ===
                words[currentWordIndex].word.toLowerCase()
            ) {
                feedback = "Correct!";
            } else {
                feedback = "Incorrect. Try again!";
            }

            // If correct, move on to the next word.
            if (feedback === "Correct!") {
                currentWordIndex++;
                if (currentWordIndex < words.length) {
                    // Play the next word's audio.
                    if (words[currentWordIndex].audio) {
                        words[currentWordIndex].audio.play();
                    }
                } else {
                    feedback = "Game Over! All words completed.";
                }
            }

            // Reset user input after submission.
            userInput = "";
            return false;
        }
    };
};

// Create a new p5 instance using the instance mode and attach it to the container.
new p5(listenAndTypeGame);
