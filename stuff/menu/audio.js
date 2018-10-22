var audio = new Audio('stuff/menu/audio.mp3');
audio.onended = function() {
    document.body.style.background = "radial-gradient(circle, rgb(40, 40, 40) 40%, rgb(15, 15, 15) 110%)";
}

function Ξ () {
    audio.play();
    document.body.style.background = "radial-gradient(circle, rgb(150, 150, 150) 40%, rgb(15, 15, 15) 110%)"
}