new p5((p) => {
    let button;
    
    p.setup = function () {
        p.createCanvas(600, 400).parent('game-container');
        p.background(200);

        button = p.createButton('Click Me!').parent('game-container');
        button.position(400, 200);
        button.size(100, 50);
        button.mousePressed(addCredit);
    };

    function addCredit() {
        fetch('/add-credit', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({})
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log(data.message);
            console.log("New Credits: " + data.credits);
        })
        .catch(error => console.error('Error:', error));
    }
});
