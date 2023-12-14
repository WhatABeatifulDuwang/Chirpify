function likeTweet(){
    let image = document.getElementById("heart");

    if (image.src === "assets/icons/heart-empty-icon.png"){
        image.src = "assets/icons/heart-full-icon.png"
    }
    else {
        image.src = "assets/icons/heart-full-icon.png"
    }
}