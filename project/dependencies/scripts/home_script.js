function likeTweet() {
    let image = document.getElementById("heart");

    let isPressed = true;

    image.addEventListener("click", function () {
        if (isPressed){
            image.src = "../assets/icons/heart-full-icon.png";
            console.log("true");
        }
        else{
            image.src = "../assets/icons/heart-empty-icon.png";
            console.log("false");
        }
        isPressed = !isPressed;
    });
}