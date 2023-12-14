 function likeTweet(count) {
    let counter = parseInt(count);
    let image = document.getElementById("heart");

    document.getElementById('heart').addEventListener("click", function(){
        if (image.src === "../assets/icons/heart-empty-icon.png" && counter === 0) {
            image.src = "../assets/icons/heart-full-icon.png";
            counter += 1;

            return counter;
        }
        else if(counter >= 1) {
            image.src = "../assets/icons/heart-full-icon.png";
            counter += 1;

            return counter;
        }
    })
}
