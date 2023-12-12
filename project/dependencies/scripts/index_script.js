function showPage(url) {
    var iframe = document.getElementById('side-bar-frame');
    var initSideBar = document.getElementById('side-bar-frame-1');
    iframe.src = url;
    initSideBar.style.display = 'none';
    iframe.style.display = 'block';
  }
  