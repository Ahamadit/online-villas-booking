<?php include "header.php"; ?>

<div class="apartment-inner-section-area sp2 bg1" style="margin-top: 80px;">
  <div class="container">
    <div class="row">
      <div class="col-lg-5 m-auto">
        <div class="apartment-header space-margin60 text-center heading3">
          <h5 data-aos="fade-left" data-aos-duration="800" class="section-title">Exclusive Decoration</h5>
          <div class="space20"></div>
        </div>
      </div>
    </div>

    <div class="row">
      <!-- Birthday Decoration -->
      <div class="col-lg-6 col-md-6" data-aos="zoom-in" data-aos-duration="800">
        <div class="apartment-boxarea">
          <div class="swiper mySwiper">
            <div class="swiper-wrapper">
              <div class="swiper-slide"><img src="assets/decoration/birthday/birthday4.jpg" alt="Birthday Decoration"></div>
              <div class="swiper-slide"><img src="assets/decoration/birthday/birthday6.jpg" alt="Birthday Decoration"></div>
              <div class="swiper-slide"><img src="assets/decoration/birthday/birthday8.jpg" alt="Birthday Decoration"></div>
              <div class="swiper-slide"><img src="assets/decoration/birthday/birthday7.jpg" alt="Birthday Decoration"></div>
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
          </div>
          <div class="content-area text-center">
            <h2 class="decor-title">Birthday Decoration</h2>
            <p class="decor-description">Celebrate Your Special Day at Rahat Villas with elegant décor, vibrant ambiance, and unforgettable moments.</p>
          </div>
        </div>
      </div>

      <!-- Anniversary Decoration -->
      <div class="col-lg-6 col-md-6" data-aos="zoom-in" data-aos-duration="800">
        <div class="apartment-boxarea">
          <div class="swiper mySwiper">
            <div class="swiper-wrapper">
              <div class="swiper-slide"><img src="assets/decoration/aniversary/ani2.webp" alt="Anniversary Decoration"></div>
              <div class="swiper-slide"><img src="assets/decoration/aniversry.jpg" alt="Anniversary Decoration"></div>
              <div class="swiper-slide"><img src="assets/decoration/aniversary/ani3.jpg" alt="Anniversary Decoration"></div>
              <div class="swiper-slide"><img src="assets/decoration/aniversary/ani4.webp" alt="Anniversary Decoration"></div>
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
          </div>
          <div class="content-area text-center">
            <h2 class="decor-title">Anniversary Decoration</h2>
            <p class="decor-description">Celebrate your love with romantic settings, exquisite décor, and timeless memories at Rahat Villas.</p>
          </div>
        </div>
      </div>

      <!-- Haldi Decoration -->
      <div class="col-lg-6 col-md-6" data-aos="zoom-in" data-aos-duration="800">
        <div class="apartment-boxarea">
          <div class="swiper mySwiper">
            <div class="swiper-wrapper">
              <div class="swiper-slide"><img src="assets/decoration/haldi/haldi2.jpg" alt="Haldi Decoration"></div>
              <div class="swiper-slide"><img src="assets/decoration/haldi/haldi1.jpg" alt="Haldi Decoration"></div>
              <div class="swiper-slide"><img src="assets/decoration/haldi/haldi3.jpg" alt="Haldi Decoration"></div>
              <div class="swiper-slide"><img src="assets/decoration/haldi/haldi4.jpg" alt="Haldi Decoration"></div>
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
          </div>
          <div class="content-area text-center">
            <h2 class="decor-title">Haldi Decoration</h2>
            <p class="decor-description">Add color to your celebration with stunning Haldi décor at Rahat Villas.</p>
          </div>
        </div>
      </div>

      <!-- Marriage Decoration -->
      <div class="col-lg-6 col-md-6" data-aos="zoom-in" data-aos-duration="800">
        <div class="apartment-boxarea">
          <div class="swiper mySwiper">
            <div class="swiper-wrapper">
              <div class="swiper-slide"><img src="assets/decoration/marriage/marriage3.jpg" alt="Marriage Decoration"></div>
              <div class="swiper-slide"><img src="assets/decoration/marriage/marriage1.jpg" alt="Marriage Decoration"></div>
              <div class="swiper-slide"><img src="assets/decoration/marriage/marriage4.jpg" alt="Marriage Decoration"></div>
              <div class="swiper-slide"><img src="assets/decoration/marriage/marriage.jpg" alt="Marriage Decoration"></div>
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
          </div>
          <div class="content-area text-center">
            <h2 class="decor-title">Marriage Decoration</h2>
            <p class="decor-description">Turn your wedding dreams into reality with elegant decorations at Rahat Villas.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Swiper Styles -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

<style>
  .swiper-slide img {
    width: 100%;
    height: auto;
    max-height: 450px;
    object-fit: cover;
    border-radius: 15px 15px 0 0;
  }

  .apartment-boxarea {
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    transition: all 0.3s ease;
    background: #fff;
  }

  .apartment-boxarea:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
  }

  .content-area {
    padding: 20px;
    background: linear-gradient(135deg, #f9f9f9, #ffffff);
  }

  .decor-title {
    font-size: 28px;
    font-weight: 700;
    color: #333;
    text-transform: uppercase;
    letter-spacing: 1px;
  }

  .decor-description {
    font-size: 16px;
    color: #666;
    line-height: 1.6;
  }

  .swiper-button-next, .swiper-button-prev {
    color: white !important;
  }
</style>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll(".mySwiper").forEach(function(swiperContainer) {
      new Swiper(swiperContainer, {
        loop: true,
        pagination: {
          el: swiperContainer.querySelector(".swiper-pagination"),
          clickable: true
        },
        navigation: {
          nextEl: swiperContainer.querySelector(".swiper-button-next"),
          prevEl: swiperContainer.querySelector(".swiper-button-prev")
        }
      });
    });
  });
</script>

<?php include "footer.php"; ?>
