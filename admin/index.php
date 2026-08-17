<?php include 'layouts/session.php'; ?>

<?php include 'layouts/main.php'; ?>



<head>



    <title>Admin Panel</title>



    <?php include 'layouts/head.php'; ?>



    <?php include 'layouts/head-style.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>



</head>



<?php include 'layouts/body.php'; ?>



<!-- Begin page -->

<div id="layout-wrapper">



    <?php include 'layouts/menu-admin.php'; ?>



    <!-- ============================================================== -->

    <!-- Start right Content here -->

    <!-- ============================================================== -->

    <div class="main-content">



        <div class="page-content">

            <div class="container-fluid">



                <!-- start page title -->

                <?php

                $maintitle = "Dashboard";

                $title = "Basic Stats !";

                ?>

                <?php include 'layouts/breadcrumb.php'; ?>

                <!-- end page title -->



                <div class="row">

                    <?php include "layouts/config.php"; ?>

                    <!-- New Statistics Cards Start Here -->



                    <!-- Total Reservations -->

                    <div class="col-xl-3 col-md-6">

                        <?php

                        $sql = "SELECT COUNT(*) AS total_reservations FROM reservations";

                        $result = $link->query($sql);



                        if ($result) {

                            $row = $result->fetch_assoc();

                            $totalReservations = $row['total_reservations']; ?>

                            <div class="card" style="border: 1px solid #ccc; border-radius: 10px; margin-bottom: 20px;">

                                <div class="card-body" style="padding: 20px;">

                                    <div style="display: flex; align-items: center;">

                                        <div style="flex-grow: 1;">

                                            <span style="font-size: 16px; color: #888;">Total Villa Enquiry</span>

                                            <h4 style="font-size: 28px; margin: 10px 0;"><?php echo $totalReservations; ?></h4>

                                        </div>

                                        <div>

                                            <!-- Icon -->

                                            <span style="font-size: 40px; color: #17a2b8;">&#128101;</span>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        <?php

                        } else {

                            echo "Error: " . $sql . "<br>" . $link->error;
                        }

                        ?>

                    </div>



                    <!--    totol Booking Enquiry -->


                    <div class="col-xl-3 col-md-6">

                        <?php
                        $sql = "SELECT COUNT(*) AS total_reservations FROM booking"; // Ensure correct table name
                        $result = $link->query($sql);

                        if ($result) {
                            $row = $result->fetch_assoc();
                            $totalReservations = $row['total_reservations'];
                        ?>

                            <div class="card" style="border: 1px solid #ccc; border-radius: 10px; margin-bottom: 20px;">

                                <div class="card-body" style="padding: 20px;">

                                    <div style="display: flex; align-items: center;">

                                        <div style="flex-grow: 1;">

                                            <span style="font-size: 16px; color: #888;">Total Booking Enquiry</span>

                                            <h4 style="font-size: 28px; margin: 10px 0;"><?php echo $totalReservations; ?></h4>

                                        </div>

                                        <div>

                                            <!-- Icon -->

                                            <span style="font-size: 40px; color: #17a2b8;">&#128101;</span>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        <?php

                        } else {

                            echo "Error: " . $sql . "<br>" . $link->error;
                        }

                        ?>

                    </div>


                    <!-- total contact us Enquiry -->
                    <div class="col-xl-3 col-md-6">

                        <?php
                        $sql = "SELECT COUNT(*) AS total_reservations FROM contact"; // Ensure correct table name
                        $result = $link->query($sql);

                        if ($result) {
                            $row = $result->fetch_assoc();
                            $totalReservations = $row['total_reservations'];
                        ?>

                            <div class="card" style="border: 1px solid #ccc; border-radius: 10px; margin-bottom: 20px;">

                                <div class="card-body" style="padding: 20px;">

                                    <div style="display: flex; align-items: center;">

                                        <div style="flex-grow: 1;">

                                            <span style="font-size: 16px; color: #888;">Total Contact-Us Enquiry</span>

                                            <h4 style="font-size: 28px; margin: 10px 0;"><?php echo $totalReservations; ?></h4>

                                        </div>

                                        <div>

                                            <!-- Icon -->

                                            <span style="font-size: 40px; color: #17a2b8;">
                                                <i class="fa-solid fa-user"></i>
                                            </span>


                                        </div>

                                    </div>

                                </div>

                            </div>

                        <?php

                        } else {

                            echo "Error: " . $sql . "<br>" . $link->error;
                        }

                        ?>

                    </div>



                    <!-- Total Reservations This Month -->

                    <div class="col-xl-3 col-md-6">

                        <?php

                        // Get current month and year

                        $currentMonth = date('m');

                        $currentYear = date('Y');



                        $sql = "SELECT COUNT(*) AS total_reservations_month FROM reservations 

                                WHERE MONTH(checkin) = $currentMonth AND YEAR(checkin) = $currentYear";

                        $result = $link->query($sql);



                        if ($result) {

                            $row = $result->fetch_assoc();

                            $totalReservationsMonth = $row['total_reservations_month']; ?>

                            <div class="card" style="border: 1px solid #ccc; border-radius: 10px; margin-bottom: 20px;">

                                <div class="card-body" style="padding: 20px;">

                                    <div style="display: flex; align-items: center;">

                                        <div style="flex-grow: 1;">

                                            <span style="font-size: 16px; color: #888;">Reservations This Month</span>

                                            <h4 style="font-size: 28px; margin: 10px 0;"><?php echo $totalReservationsMonth; ?></h4>

                                        </div>

                                        <div>

                                            <!-- Icon -->

                                            <span style="font-size: 40px; color: #ffc107;">&#128197;</span>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        <?php

                        } else {

                            echo "Error: " . $sql . "<br>" . $link->error;
                        }

                        ?>

                    </div>



                    <!-- Total Reservations This Week -->

                    <div class="col-xl-3 col-md-6">

                        <?php

                        // Get current week number and year

                        $currentWeek = date('W');

                        $currentYear = date('Y');



                        $sql = "SELECT COUNT(*) AS total_reservations_week FROM reservations 

                                WHERE WEEK(checkin, 1) = $currentWeek AND YEAR(checkin) = $currentYear";

                        $result = $link->query($sql);



                        if ($result) {

                            $row = $result->fetch_assoc();

                            $totalReservationsWeek = $row['total_reservations_week']; ?>

                            <div class="card" style="border: 1px solid #ccc; border-radius: 10px; margin-bottom: 20px;">

                                <div class="card-body" style="padding: 20px;">

                                    <div style="display: flex; align-items: center;">

                                        <div style="flex-grow: 1;">

                                            <span style="font-size: 16px; color: #888;">Reservations This Week</span>

                                            <h4 style="font-size: 28px; margin: 10px 0;"><?php echo $totalReservationsWeek; ?></h4>

                                        </div>

                                        <div>

                                            <!-- Icon -->

                                            <span style="font-size: 40px; color: #28a745;">&#127919;</span>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        <?php

                        } else {

                            echo "Error: " . $sql . "<br>" . $link->error;
                        }

                        ?>

                    </div>



                    <!-- Best Selling Villa -->

                    <!-- <div class="col-xl-3 col-md-6">

                        <?php

                        //   $sql = "SELECT villa_name, COUNT(*) AS villa_count 

                        //         FROM reservations 

                        //         GROUP BY villa_name 

                        //         ORDER BY villa_count DESC 

                        //         LIMIT 1";

                        //   $result = $link->query($sql);



                        //  if ($result && $result->num_rows > 0) {

                        //     $row = $result->fetch_assoc();

                        //     $bestSellingVilla = $row['villa_name'];

                        //     $villaCount = $row['villa_count']; 
                        ?>

                        <!-- //     <div class="card" style="border: 1px solid #ccc; border-radius: 10px; margin-bottom: 20px;">

                        //         <div class="card-body" style="padding: 20px;">

                        //             <div style="display: flex; align-items: center;">

                        //                 <div style="flex-grow: 1;">

                        //                     <span style="font-size: 16px; color: #888;">Best Selling Villa</span>

                        //                     <h4 style="font-size: 28px; margin: 10px 0;"><?php echo $bestSellingVilla; ?> (<?php echo $villaCount; ?> Reservations)</h4>

                        //                 </div>

                        //                 <div>

                        //                     <!-- Icon --

                        //                     <span style="font-size: 40px; color: #fd7e14;">&#127958;</span>

                        //                 </div>

                        //             </div>

                        //         </div>

                        //     </div> -->

                    <?php

                    // } else {

                    //     echo "No reservations found.";
                    // }

                    // 
                    ?>

                </div>



                <!-- Best Selling Villa  End -->


            </div>



            <!-- end card -->



        </div>



    </div>

    <!-- End Page-content -->



    <?php include 'layouts/footer.php'; ?>

</div>

<!-- end main content-->



</div>

<!-- END layout-wrapper -->



<?php include 'layouts/right-sidebar.php'; ?>



<?php include 'layouts/vendor-scripts.php'; ?>

<!-- apexcharts -->

<script src="assets/libs/apexcharts/apexcharts.min.js"></script>

<script src="assets/js/pages/allchart.js"></script>

<!-- Plugins js-->

<script src="assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js"></script>

<script src="assets/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-world-mill-en.js"></script>

<!-- dashboard init -->

<script src="assets/js/pages/dashboard.init.js"></script>



</body>



</html>