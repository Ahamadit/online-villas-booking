<?php include "header.php"; ?>

<div class="apartment-inner-section-area sp2 bg1" style="margin-top: 80px;">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 m-auto">
                <div class="apartment-header space-margin60 text-center heading3">
                    <h5 data-aos="fade-left" data-aos-duration="800">Exclusive Sightseeing</h5>
                    <div class="space20"></div>
                </div>
            </div>
        </div>

        <div class="row">
            <?php
            // Array of sightseeing locations
            $sightseeing = [

                ["name" => "Della Adventure Park", "folder" => "della", "images" => ["dela1.jpg", "dela2.jpg", "dela3.jpg", "dela4.jpg", "dela5.jpg"]],
                ["name" => "Lohagad Fort", "folder" => "Lohagad", "images" => ["Lohagad1.jpg", "Lohagad2.jpg", "Lohagad3.jpg", "Lohagad4.jpg", "Lohagad5.jpg"]],
                ["name" => "Ekvira Devi Temple", "folder" => "Ekvira-Devi", "images" => ["Ekvira1.jpg", "Ekvira2.jpg", "Ekvira3.jpg", "Ekvira4.jpg", "Ekvira5.jpg",]],
                ["name" => "Lion's Point", "folder" => "loin-point", "images" => ["lion1.jpg", "lion2.jpg", "lion3.jpg", "lion4.jpg", "lion5.jpg"]],
                ["name" => "Pavana Lake", "folder" => "pawana-lake", "images" => ["pawana1.jpg", "pawana2.jpg", "pawana3.jpg", "pawana4.jpg", "pawana5.jpg"]],
                ["name" => "Karla Caves", "folder" => "karla-caves", "images" => ["karla1.jpg", "karla2.jpg", "karla3.jpg", "karla4.jpg", "karla5.jpg"]],
                ["name" => "Shree Narayani Dham Temple", "folder" => "Shree-Narayani", "images" => ["narayani.jpg", "narayani1.jpg", "narayani2.jpg", "narayani3.jpg", "narayani4.jpg"]],
                ["name" => "Kune Waterfalls", "folder" => "kune-waterfall", "images" => ["kune1.jpg","kune2.jpg", "kune3.jpg","kune4.jpg","kune5.jpg",]],
                ["name" => "Tikona Fort", "folder" => "tikana-fort", "images" => ["tikana.jpg", "tikana1.jpg", "tikana2.jpg","tikana5.jpg","tikana4.jpg",]],
                ["name" => "Korigad Fort", "folder" => "karigad-fort", "images" => ["karigad1.jpg", "karigad2.jpg", "karigad3.jpg" , "karigad4.jpg", "karigad5.jpg"]],
                ["name" => "Bhaja Caves", "folder" => "bhaja-caves", "images" => ["bhaja1.jpg", "bhaja2.jpg","bhaja3.jpg","bhaja4.jpg","bhaja5.jpg", ]],
                ["name" => "Bhushi Dam", "folder" => "bhusi-dham", "images" => ["bhusi.jpg", "bhusi1.jpg", "bhusi5.jpg","bhusi3.jpg","bhusi4.jpg", ]],
                ["name" => "Sunil's Celebrity Wax Museum", "folder" => "Sunil's-Celebrity-Wax-Museum", "images" => ["sunil.jpg", "sunil1.jpg","sunil2.jpg","sunil3.jpg","sunil5.jpg",]],
                ["name" => "Nagphani (Duke's Nose)", "folder" => "nagphani-duke", "images" => ["nagphani.jpg", "nagphani1.jpg","nagphani3.jpg","nagphani4.jpg","nagphani5.jpg",]],
                ["name" => "Tiger's Leap", "folder" => "tiger-leap", "images" => ["tiger.jpg", "tiger1.jpg", "tiger2.jpg","tiger3.jpg","tiger4.jpg",]],
                ["name" => "Tungarli Lake", "folder" => "tungarli-lake", "images" => ["tungarli.jpg", "tungarli1.jpg","tungarli2.jpg","tungarli3.jpg","tungarli4.jpg",]],
                ["name" => "Tiger’s Point", "folder" => "tiger-point", "images" => ["tiger.jpg", "tiger1.jpg","tiger2.jpg","tiger3.jpg","tiger4.jpg",]],
                ["name" => "Rajmachi Garden", "folder" => "rajmachi-garden", "images" => ["rajmachi1.jpg", "rajmachi2.jpg","rajmachi3.jpg","rajmachi4.jpg","rajmachi5.jpg",]],
                ["name" => "Shooting Point", "folder" => "shooting-point", "images" => ["shooting1.jpg", "shooting2.jpg", "shooting3.jpg","shooting4.jpg","shooting5.jpg",]],
                ["name" => "Reversing Station", "folder" => "reversing-station", "images" => ["reversing1.jpg", "reversing2.jpg","reversing3.jpg","reversing4.jpeg","reversing5.jpg",]],
                ["name" => "Magic Mountain", "folder" => "magic-mountain", "images" => ["magic.jpg", "magic2.jpeg","magic3.jpeg","magic3.jpeg","magic5.jpg",]],
                ["name" => "Manashakti Mind Gym", "folder" => "manashakti-gym", "images" => ["mana1.jpeg", "mana2.jpeg","mana3.jpeg","mana4.jpg","mana5.jpg",]],
                ["name" => "Shri Durga Parameshwari Temple", "folder" => "shree-durga", "images" => ["shiri.jpg", "shiri1.jpeg","shiri2.jpg","shiri3.jpg","shiri4.jpeg",]],
                ["name" => "Dinosaurs Park", "folder" => "dinosaurs-park", "images" => ["dinasure.jpg", "dinasure1.jpg","dinasure2.jpg","dinasure3.jpg","dinasure4.jpg",]],
                ["name" => "Valvan Dam", "folder" => "valvan-dam", "images" => ["valvan.jpg", "valvan1.jpeg","valvan2.jpeg","valvan3.jpeg","valvan4.jpeg",]],
                ["name" => "Lucky's Celebrity Wax Museum", "folder" => "lucky-celebarity", "images" => ["lucky.jpg", "lucky1.jpeg","lucky2.jpeg","lucky3.jpeg","lucky4.jpg",]],
                ["name" => "Miniature World Museum", "folder" => "miniature-museum", "images" => ["mini.jpg", "mini1.jpg","mini2.jpg","mini4.jpg","mini5.jpg",]],
                ["name" => "Sudhagadh Fort", "folder" => "sudhagadh-fort", "images" => ["sughanda1.jpeg", "sughanda2.jpeg","sughanda3.jpeg","sughanda4.jpeg","sughanda5.jpeg",]],
                ["name" => "Bhushi Lake", "folder" => "bhushi-lake", "images" => ["bhusi1.jpg", "bhusi2.jpeg","bhusi3.jpeg","bhusi4.jpeg","bhusi5.jpg",]],
                ["name" => "Lonavla Wax Museum", "folder" => "lonovala-wax", "images" => ["lonovala.jpg", "lonovala1.jpg","lonovala3.jpg",]]

                // Add more locations as needed...
            ];

            // Loop through the sightseeing locations
            foreach ($sightseeing as $index => $place) { ?>
                <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-duration="800">
                    <div class="apartment-boxarea">
                        <!-- Swiper Slider Container -->
                        <div class="swiper mySwiper-<?php echo $index; ?>">
                            <div class="swiper-wrapper">
                                <?php
                                foreach ($place["images"] as $image) {
                                    echo '<div class="swiper-slide"><img style="height: 15rem; width: 100%;" src="assets/sightseeing/' . $place["folder"] . '/' . $image . '" alt=""></div>';
                                }
                                ?>
                            </div>
                            <!-- Pagination & Navigation Buttons -->
                            <div class="swiper-pagination"></div>
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                        </div>

                        <div class="content-area">
                            <a href="decoration.php"><?php echo $place["name"]; ?></a>
                            <div class="space16"></div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<style>
    /* Change pagination color to white */
    .swiper-pagination-bullet {
        background: white !important;
        opacity: 0.7;
    }

    .swiper-pagination-bullet-active {
        background: white !important;
        opacity: 1;
    }

    /* Change the size of the navigation buttons */
    .swiper-button-next,
    .swiper-button-prev {
        width: 30px;
        /* Adjust the width */
        height: 30px;
        /* Adjust the height */
        font-size: 1.5rem;
        /* Adjust the font size */
    }

    /* Optional: If you want to scale the arrow icons down */
    .swiper-button-next::after,
    .swiper-button-prev::after {
        font-size: 18px;
        /* Smaller arrow icons */
    }


    /* Change navigation buttons color to white */
    .swiper-button-next,
    .swiper-button-prev {
        color: white !important;
        font-size: 1rem;
    }

    /* Optional: Add a subtle shadow for better visibility */
    .swiper-button-next,
    .swiper-button-prev {
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<!-- Initialize Swiper (Manual Only, No Autoplay) -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        <?php foreach ($sightseeing as $index => $place) { ?>
            new Swiper(".mySwiper-<?php echo $index; ?>", {
                loop: true,
                pagination: {
                    el: ".mySwiper-<?php echo $index; ?> .swiper-pagination",
                    clickable: true
                },
                navigation: {
                    nextEl: ".mySwiper-<?php echo $index; ?> .swiper-button-next",
                    prevEl: ".mySwiper-<?php echo $index; ?> .swiper-button-prev"
                }
            });
        <?php } ?>
    });
</script>

<?php include "footer.php"; ?>