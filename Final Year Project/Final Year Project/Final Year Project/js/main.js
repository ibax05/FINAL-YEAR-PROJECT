/*===== EXPANDER MENU  =====*/ 
const showMenu = (toggleId, navbarId, bodyId)=>{
  const toggle = document.getElementById(toggleId),
  navbar = document.getElementById(navbarId),
  bodypadding = document.getElementById(bodyId)

  if(toggle && navbar){
    toggle.addEventListener('click', ()=>{
      navbar.classList.toggle('expander')

      bodypadding.classList.toggle('body-pd')
    })
  }
}
showMenu('nav-toggle','navbar','body-pd')

/*===== LINK ACTIVE  =====*/ 
const linkColor = document.querySelectorAll('.nav__link')
function colorLink(){
  linkColor.forEach(l=> l.classList.remove('active'))
  this.classList.add('active')
}
linkColor.forEach(l=> l.addEventListener('click', colorLink))


/*===== COLLAPSE MENU  =====*/ 
const linkCollapse = document.getElementsByClassName('collapse__link')
var i

for(i=0;i<linkCollapse.length;i++){
  linkCollapse[i].addEventListener('click', function(){
    const collapseMenu = this.nextElementSibling
    collapseMenu.classList.toggle('showCollapse')

    const rotate = collapseMenu.previousElementSibling
    rotate.classList.toggle('rotate')
  })
}




/*===== DASHBOARD  =====*/ 
document.querySelectorAll('.dashboard-item').forEach(item => {
  item.addEventListener('touchstart', function() {
    // Tambahkan kelas hover saat disentuh
    this.classList.add('hover');
  });

  item.addEventListener('touchend', function() {
    // Hapus kelas hover saat tidak disentuh lagi
    this.classList.remove('hover');
  });

  item.addEventListener('click', function() {
    // Navigasi ke halaman lain saat ditekan
    window.location.href = this.getAttribute('href');
  });
});


document.querySelectorAll('.dashboard-item').forEach(item => {
  item.addEventListener('click', function() {
    // Ambil URL halaman tujuan dari atribut data-href
    const targetUrl = this.getAttribute('data-href');
    // Navigasi ke halaman tujuan
    window.location.href = targetUrl;
  });
});



