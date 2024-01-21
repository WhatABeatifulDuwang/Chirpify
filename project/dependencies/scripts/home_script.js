let image_array = ["../assets/icons/heart-empty-icon.png", "../assets/icons/heart-full-icon.png"];
i = 0;

function likeTweet(){
    i++;
    document.getElementById("heart").src = image_array[i];
    if (i == image_array.length - 1) {
        i = -1;
    }
}

function editTweet(){
    let message = document.getElementById("updateText");
    let label = document.getElementById("textLabel");
    let post = document.getElementById("submitButton");

    message.setAttribute("type", "text");
    label.style.display = "none";
    post.setAttribute("type", "submit");
}