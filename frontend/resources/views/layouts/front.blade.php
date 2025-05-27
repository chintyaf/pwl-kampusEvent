<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
    rel="stylesheet">

    <title>Evoria</title>

  <!-- Bootstrap core CSS -->
  <link href="{{ asset('front/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">


  <!-- Additional CSS Files -->
  <link rel="stylesheet" href="{{ asset('front/assets/css/fontawesome.css') }}">
  <link rel="stylesheet" href="{{ asset('front/assets/css/templatemo-scholar.css') }}">
  <link rel="stylesheet" href="{{ asset('front/assets/css/owl.css') }}">
  <link rel="stylesheet" href="{{ asset('front/assets/css/animate.css') }}">
  <link rel="stylesheet" href="{{ asset('front/assets/css/style.css') }}">
  <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />
  <!--

TemplateMo 586 Scholar

https://templatemo.com/tm-586-scholar

-->
</head>

<body>

  <!-- ***** Preloader Start ***** -->
  <div id="js-preloader" class="js-preloader">
    <div class="preloader-inner">
      <span class="dot"></span>
      <div class="dots">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
  </div>
  <!-- ***** Preloader End *****-->

  @include('layouts.partials-front.navbar')



    <style>

    </style>

    @yield("content")



  @include('layouts.partials-front.footer')


  <!-- Scripts -->
  <!-- Bootstrap core JavaScript -->
    <script src="{{ asset('front/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('front/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('front/assets/js/isotope.min.js') }}"></script>
    <script src="{{ asset('front/assets/js/owl-carousel.js') }}"></script>
    <script src="{{ asset('front/assets/js/counter.js') }}"></script>
    <script src="{{ asset('front/assets/js/custom.js') }}"></script>

</body>

</html>
