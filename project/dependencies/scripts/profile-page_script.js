function showEditForm() {
    var editForm = document.querySelector('.edit-form');
  
    if (editForm.style.display === "none" || !editForm.style.display) {
      editForm.style.display = "block";
    }
  }

let image_array = ["../assets/icons/heart-empty-icon.png", "../assets/icons/heart-full-icon.png"];
i = 0;

// This method switches between images used for the like button
function likeTweet(id){
    i++;

    document.getElementById("heart" + id).src = image_array[i];
    if (i == image_array.length - 1) {
        i = -1;
        event.preventDefault();
    }
}