let image_array = ["../assets/icons/heart-empty-icon.png", "../assets/icons/heart-full-icon.png"];
i = 0;

function likeTweet(id){
    i++;

    document.getElementById("heart" + id).src = image_array[i];
    if (i == image_array.length - 1) {
        i = -1;
        event.preventDefault();
    }
}

function getLike(id){
    return document.getElementById("heart" + id).src;
}
function editTweet(id){
    let message = document.getElementById("updateText" + id);
    let label = document.getElementById("textLabel" + id);
    let post = document.getElementById("submitButton" + id);

    message.setAttribute("type", "text");
    label.style.display = "none";
    post.setAttribute("type", "submit");
}