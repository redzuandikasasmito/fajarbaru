<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light"  data-color-theme="Blue_Theme" data-layout="vertical">

<head>
  <!-- Required meta tags -->
<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<!-- Favicon icon-->
<link
  rel="shortcut icon"
  type="image/png"
  href="../images/logos/favicon.png"
/>

<!-- Core Css -->
<link rel="stylesheet" href="../css/styles.css" />

  <title>Spike Bootstrap Admin</title>
  <!-- jvectormap  -->
  <link rel="stylesheet" href="../libs/jvectormap/jquery-jvectormap.css">
</head>

<body>
  <!-- Preloader -->
  <div class="preloader">
    <img src="../images/logos/loader.svg" alt="loader" class="lds-ripple img-fluid" />
  </div>
  <div id="main-wrapper">
    <!-- Sidebar Start -->
   @include('base.sidebar')
    <!--  Sidebar End -->
   
          <!--  Header Start -->
          @include('base.header')
{{-- include header --}}
       
          <!--  Header End -->
          <div class="row">
          </div>


@include("base.setting")
  <script src="../js/vendor.min.js"></script>
  <!-- Import Js Files -->
<script src="../libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="../libs/simplebar/dist/simplebar.min.js"></script>
<script src="../js/theme/app.dark.init.js"></script>
<script src="../js/theme/theme.js"></script>
<script src="../js/theme/app.min.js"></script>
<script src="../js/theme/sidebarmenu.js"></script>
<script src="../js/theme/feather.min.js"></script>

<!-- solar icons -->
<script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
  <script src="../libs/jvectormap/jquery-jvectormap.min.js"></script>
  <script src="../libs/apexcharts/dist/apexcharts.min.js"></script>
  <script src="../js/extra-libs/jvectormap/jquery-jvectormap-us-aea-en.js"></script>
  <script src="../js/dashboards/dashboard.js"></script>
</body>

</html>