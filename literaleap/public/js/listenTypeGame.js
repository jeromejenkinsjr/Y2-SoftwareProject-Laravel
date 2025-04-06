let listenAndTypeGame = function (p) {
    let words = [
        { word: "apple", audio: null },
        { word: "orange", audio: null },
    ];

    let currentWordIndex = 0;
    let userInput = "";
    let feedback = "";
    let feedbackColor = "#000";
    let replayButton;

    p.preload = function () {
        words[0].audio = p.loadSound("/audio/apple.mp3");
        words[1].audio = p.loadSound("/audio/orange.mp3");
    };

    p.setup = function () {
        // Dynamically get the container width
        const containerEl = document.getElementById("game-container");
        // Subtract 32 if you have 1rem padding on each side (16px * 2)
        const containerWidth = containerEl.offsetWidth - 32;
        
        // Create canvas using the container’s width minus padding
        let canvas = p.createCanvas(containerWidth, 450);
        canvas.parent("game-container");
        p.textAlign(p.CENTER, p.CENTER);
        p.textFont("Georgia");

        replayButton = p.createButton("🔁 Replay Sound");
        replayButton.parent("game-container");
        replayButton.style("font-size", "18px");
        replayButton.style("padding", "10px 20px");
        replayButton.style("background-color", "#4CAF50");
        replayButton.style("color", "white");
        replayButton.style("border", "none");
        replayButton.style("border-radius", "8px");
        replayButton.style("display", "block");
        replayButton.style("margin", "10px auto");
        replayButton.mousePressed(() => {
            let current = words[currentWordIndex];
            if (current && current.audio) current.audio.play();
        });

        // Start with the first audio
        if (words[currentWordIndex].audio) {
            words[currentWordIndex].audio.play();
        }
    };

    p.draw = function () {
        p.background("#fdf6e3");
        p.fill("#2c3e50");
        p.textSize(36);
        p.text("🎧 Listen & Type Game 🎮", p.width / 2, 50);

        p.textSize(20);
        p.text("Type what you hear and press ENTER!", p.width / 2, 100);

        p.fill("#34495e");
        p.rect(p.width / 2 - 150, 160, 300, 50, 10);
        p.fill("#ecf0f1");
        p.textSize(24);
        p.text(userInput || "Type here...", p.width / 2, 185);

        p.fill(feedbackColor);
        p.textSize(28);
        p.text(feedback, p.width / 2, 280);
    };

    p.keyTyped = function () {
        if (userInput.length < 20) userInput += p.key;
    };

    p.keyPressed = function () {
        if (p.keyCode === p.BACKSPACE) {
            userInput = userInput.slice(0, -1);
            return false;
        }
        if (p.keyCode === p.ENTER) {
            const correctWord = words[currentWordIndex].word.toLowerCase();
            if (userInput.toLowerCase().trim() === correctWord) {
                feedback = "✅ Correct!";
                feedbackColor = "#27ae60";
                currentWordIndex++;
                if (currentWordIndex < words.length) {
                    let next = words[currentWordIndex];
                    if (next.audio) next.audio.play();
                } else {
                    feedback = "🏁 Game Over! Well done! 🎉";
                }
            } else {
                feedback = "❌ Incorrect. Try again!";
                feedbackColor = "#e74c3c";
            }
            userInput = "";
            return false;
        }
    };
};

new p5(listenAndTypeGame);
