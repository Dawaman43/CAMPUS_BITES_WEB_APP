document.querySelector('.mobile-menu-btn').addEventListener('click', function() {
    document.querySelector('nav').classList.toggle('mobile-menu-active');
    document.body.classList.toggle('no-scroll');
  });
  
  document.querySelectorAll('.nav-elements a').forEach(link => {
    link.addEventListener('click', function() {
      if (document.querySelector('nav').classList.contains('mobile-menu-active')) {
        document.querySelector('nav').classList.remove('mobile-menu-active');
        document.body.classList.remove('no-scroll');
      }
    });
  });