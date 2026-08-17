<?php include "header.php" ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exclusive Catering</title>


    <style>
       .apartment-boxarea {
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
    transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    position: relative;
    background: white;
    text-align: center;
    padding: 15px;
    height: 100%; /* Ensures uniform height */
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.apartment-boxarea img {
    border-radius: 10px;
    max-height: 150px;
    object-fit: cover;
    width: 100%;
}

.apartment-boxarea h4 {
    flex-grow: 1; /* Ensures the text is centered properly */
}

.popup-btn {
    background: #ff6600;
    color: white;
    border: none;
    padding: 8px 16px;
    font-size: 14px;
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s;
    display: inline-block;
    margin-top: 10px;
}

.popup-btn:hover {
    background: #e65c00;
    transform: scale(1.05);
}

.row.g-4 > div {
    display: flex;
}

    </style>
</head>

<body>
    <div class="container py-5">
        <div class="row" style="margin-top: 100px;">
            <div class="col-lg-6 m-auto text-center">
                <h2 class="fw-bold">Exclusive Catering</h2>
                <div class="space20"></div>
            </div>
        </div>

        <div class="row g-4">
            <?php 
                $menus = [
                    ["Full Day", "full.jpg", "catering5.jpeg"],
                    ["Regular Menu", "regular.avif", "catering6.jpeg"],
                    ["Executive", "executive.jpeg", "catering7.jpeg"],
                    ["Individual", "individual.avif", "catering8.jpeg"],
                    ["Veg", "veg.jpg", "catering1.jpg"],
                    ["Chicken", "chiken.jpg", "catering3.jpg"],
                    ["Mutton", "mutton1.jpg", "catering2.jpg"],
                    ["Barbeque", "barbaque.avif", "catering4.jpg"]
                ];
                foreach ($menus as $menu) {
                    echo '<div class="col-lg-3 col-md-6" data-bs-toggle="modal" data-bs-target="#foodMenuModal" onclick="openModal(\'assets/catering/'.$menu[2].'\')">
                        <div class="apartment-boxarea">
                            <img class="img-fluid" src="assets/catering/'.$menu[1].'" alt="'.$menu[0].'">
                            <h4 class="mt-3">'.$menu[0].'</h4>
                            <button class="popup-btn">View Menu</button>
                        </div>
                    </div>';
                }
            ?>
        </div>
    </div>

    <div class="modal fade" id="foodMenuModal" tabindex="-1" aria-labelledby="foodMenuModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <img id="modalImage" src="" alt="Food Menu">
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function openModal(imageSrc) {
            document.getElementById('modalImage').src = imageSrc;
        }
    </script>

    <?php include "footer.php" ?>
</body>

</html>