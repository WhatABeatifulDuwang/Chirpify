 function likeTweet(count) {
    let counter = parseInt(count);
    let image = document.getElementById("heart");

     if (counter === 0) {
         image.src = "../assets/icons/heart-full-icon.png";
         counter += 1;

         return counter;
     }
     else {
         image.src = "../assets/icons/heart-full-icon.png";
         counter += 1;

         return counter;
     }
}
