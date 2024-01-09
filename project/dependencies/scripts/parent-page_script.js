document.addEventListener('DOMContentLoaded',function () {
    showPage('../pages/home.php');
})

function showPage(url) {
    var home = document.getElementById('parent_div');
    home.src = url;
}