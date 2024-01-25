function showUserEditForm(id) {
    var div = document.getElementById("editUserForm");
    div.style.display = "block";

    var formEdit = document.getElementById("idFrom");
    formEdit.value = id;
}

function hideUserEditForm() {
    var div = document.getElementById("editUserForm");
    div.style.display = "none";

    var formEdit = document.getElementById("idFrom");
    formEdit.value = "";
}