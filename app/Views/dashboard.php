<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>SIWIRI</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="<?= base_url('assets/img/logooo.png') ?>" rel="icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="<?= base_url('assets/vendor/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
  <link href="<?= base_url('assets/vendor/bootstrap-icons/bootstrap-icons.css') ?>" rel="stylesheet">
  <link href="<?= base_url('assets/vendor/boxicons/css/boxicons.min.css') ?>" rel="stylesheet">
  <link href="<?= base_url('assets/vendor/glightbox/css/glightbox.min.css') ?>" rel="stylesheet">
  <link href="<?= base_url('assets/vendor/remixicon/remixicon.css') ?>" rel="stylesheet">
  <link href="<?= base_url('assets/vendor/swiper/swiper-bundle.min.css') ?>" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet">

</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top ">
    <div class="container d-flex align-items-center justify-content-between">

      <h1 class="logo"><a href="<?= base_url('assets/img/logooo.png') ?>">SIWIRI</a></h1>
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href="index.html" class="logo"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

      <nav id="navbar" class="navbar">
        <ul>
          <!-- <li><a class="nav-link scrollto active" href="#hero">Home</a></li> -->
          <li><a class="nav-link scrollto" href="<?= base_url('home/index') ?>">Login</a></li>
          <!-- <li><form action="/login" method="get">
            <button style="background-color: transparent; border: none; color: white; cursor: pointer;"> Log In</button>
          </form></li> -->
          <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->

  <!-- ======= Hero Section ======= -->
  <section id="hero">
    <div class="hero-container">
      <h3>Welcome to <strong>SIWIRI</strong></h3>
      <h1>Sistem Informasi Wisata Riau</h1>
      <h2>By RINI HUSADIYAH</h2>
      <a href="<?= base_url('home/index') ?>" method="get" class="btn-get-started scrollto">GO TO MAP</a>
    </div>
  </section><!-- End Hero -->

  <main id="main">

    <!-- ======= Footer ======= -->
    <footer id="footer">

      <div class="footer-top">
        <div class="container">
          <div class="row">

            <div class="container d-md-flex py-4">

              <div class="me-md-auto text-center text-md-start">
                <div class="copyright">
                  &copy; Copyright <strong><span>RINI HUSADIYAH</span></strong>.
                </div>
                <div class="credits">
                  <a>Sistem Informasi Geografis</a>
                </div>
              </div>
              <div class="social-links text-center text-md-right pt-3 pt-md-0">
                <a href="https://instagram.com/hsdyh.rn" class="instagram" target="_blank"><i class="bx bxl-instagram"></i></a>
                <a href="https://www.linkedin.com/in/rinihusadiyah/" class="linkedin" target="_blank"><i class="bx bxl-linkedin"></i></a>
                <a href="https://github.com/RiniHSD" class="github" target="_blank"><i class="bx bxl-github"></i></a>
              </div>
            </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/glightbox/js/glightbox.min.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/isotope-layout/isotope.pkgd.min.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/swiper/swiper-bundle.min.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/php-email-form/validate.js') ?>"></script>

    <!-- Template Main JS File -->
    <script src="<?= base_url('assets/js/main.js') ?>"></script>

</body>

</html>