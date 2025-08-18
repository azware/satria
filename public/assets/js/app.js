// SATRIA_GLOBALS akan didefinisikan di file PHP sebelum memanggil script ini

// Wrapper untuk fungsi utama
const App = (function () {
  function loadContent(url) {
    $("#main-content").html('<div class="d-flex justify-content-center mt-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>');
    $.ajax({
      url: url,
      type: "GET",
      success: (res) => $("#main-content").html(res),
      error: () => $("#main-content").html('<div class="alert alert-danger">Gagal memuat halaman.</div>'),
    });
  }
  return { loadContent };
})();

// Fungsi untuk mengelola tooltip
function manageTooltips() {
  // Hancurkan semua tooltip yang ada untuk re-inisialisasi
  $('#sidebar .nav-link').each(function() {
      const tooltipInstance = bootstrap.Tooltip.getInstance(this);
      if (tooltipInstance) {
          tooltipInstance.dispose();
      }
  });

  // Jika sidebar mini (punya class .active), inisialisasi tooltip
  if ($('#sidebar').hasClass('active') && $(window).width() > 768) {
      $('#sidebar .nav-link').each(function() {
          new bootstrap.Tooltip(this);
      });
  }
}

$(document).ready(function () {
  // Pastikan SATRIA_GLOBALS ada sebelum digunakan
  if (typeof SATRIA_GLOBALS === 'undefined') {
    console.error("SATRIA_GLOBALS is not defined! Make sure it's set in your PHP view.");
    return;
  }

  // Load dashboard by default
  App.loadContent(SATRIA_GLOBALS.siteUrl + "dashboard");

  // Sidebar toggle logic
  $('#sidebarCollapse').on('click', function() {
      $('#sidebar').toggleClass('active');
      manageTooltips(); // Panggil fungsi tooltip setiap kali toggle
  });
  
  // Logika untuk overlay di mobile
  $('.sidebar-overlay').on('click', function() {
      $('#sidebar').removeClass('active');
  });

  // Handle sidebar link clicks
  $(document).on('click', '#sidebar .nav-link', function(e) {
      e.preventDefault();
      const url = $(this).data('url');
      if (url) {
          App.loadContent(url);
          $('#sidebar ul li').removeClass('active');
          $(this).closest('li').addClass('active');

          // Sembunyikan sidebar setelah klik di mode mobile
          if ($(window).width() <= 768 && $('#sidebar').hasClass('active')) {
              $('#sidebar').removeClass('active');
          }
      }
  });

  // Inisialisasi tooltip saat pertama kali load
  manageTooltips();


  // [BARU] Membuat seluruh kartu statistik bisa diklik
  $(document).on('click', '.small-box', function(e) {
      // Temukan link di dalam kartu yang diklik
      const link = $(this).find('.ajax-link');
      
      // Jika link ditemukan, picu klik pada link tersebut
      if (link.length > 0) {
          // [0] untuk mendapatkan elemen DOM asli dan .click() untuk memicu event klik asli
          link[0].click(); 
      }
  });


  // Handler utama untuk SEMUA ajax-link (tidak perlu diubah)
  $(document).on('click', '.ajax-link', function(e) {
      e.preventDefault();
      
      // [PENTING] Hentikan event agar tidak "bubble up" ke .small-box dan menyebabkan klik ganda
      e.stopPropagation(); 

      const url = $(this).data('url');

      if (url) {
          App.loadContent(url);
          $('#sidebar ul li').removeClass('active');
          $(`#sidebar a[data-url='${url}']`).closest('li').addClass('active');
          if ($(window).width() <= 768 && $('#sidebar').hasClass('active')) {
              $('#sidebar').removeClass('active');
          }
      }
  });

});