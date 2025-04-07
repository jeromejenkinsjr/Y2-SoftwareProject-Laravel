let matchGame = function (p) {
    let images = [
        { word: "apple", src: "/images/apple.png" },
        { word: "banana", src: "/images/banana.png" },
        { word: "orange", src: "/images/orange.png" }
    ];

    let shuffled = [];
    let choices = [];
    let currentIndex = 0;
    let feedback = "";
    let feedbackColor = "#000";

    p.preload = function () {
        for (let item of images) {
            item.img = p.loadImage(item.src);
        }
    };

    p.setup = function () {
        const container = document.getElementById("game-container");
        let canvas = p.createCanvas(container.offsetWidth - 32, 500);
        canvas.parent("game-container");
        p.textAlign(p.CENTER, p.CENTER);
        p.textFont("Georgia");
        shuffleChoices();
    };

    function shuffleChoices() {
        // Shuffle words
        shuffled = images.slice();
        p.shuffle(shuffled, true);
        choices = shuffled.map(i => i.word);
    }

    p.draw = function () {
        p.background("#fdf6e3");
        p.textSize(32);
        p.fill("#2c3e50");
        p.text("Match the Word to the Image 🎯", p.width / 2, 30);

        if (currentIndex >= images.length) {
            p.textSize(28);
            p.fill("#27ae60");
            p.text("🎉 Well done! You completed the game!", p.width / 2, p.height / 2);
            return;
        }

        // Draw image
        let current = images[currentIndex];
        p.image(current.img, p.width / 2 - 75, 60, 150, 150);

        // Draw buttons
        for (let i = 0; i < choices.length; i++) {
            let x = 100 + i * 200;
            let y = 300;
            p.fill("#ffffff");
            p.stroke("#34495e");
            p.rect(x-90, y, 150, 50, 10);

            p.fill("#2c3e50");
            p.textSize(20);
            p.text(choices[i], x-20, y + 25);
        }

        // Feedback
        p.fill(feedbackColor);
        p.textSize(24);
        p.text(feedback, p.width / 2, 400);
    };

    p.mousePressed = function () {
        for (let i = 0; i < choices.length; i++) {
            let x = 100 + i * 200 - 90; // align with the left edge of the rect
            let y = 300;
            let w = 150;
            let h = 50;
    
            if (p.mouseX >= x && p.mouseX <= x + w && p.mouseY >= y && p.mouseY <= y + h) {
                let selected = choices[i];
                if (selected === images[currentIndex].word) {
                    feedback = "✅ Correct!";
                    feedbackColor = "#27ae60";
                    currentIndex++;
                    updateRewards(); // XP + Credits
                } else {
                    feedback = "❌ Try again!";
                    feedbackColor = "#e74c3c";
                }
            }
        }
    };
    

    function updateRewards() {
        fetch('/add-credit', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({})
        })
        .then(response => response.json())
        .then(data => {
            console.log("Credit Added:", data.credits);
        });

        fetch('/add-xp', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({})
        })
        .then(response => response.json())
        .then(data => {
            console.log("XP Added:", data.xp);
        });
    }
};

new p5(matchGame);
