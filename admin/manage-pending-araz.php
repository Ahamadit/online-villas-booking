<?php include 'layouts/session.php'; ?>
<?php include 'layouts/main.php'; ?>

<head>

    <title>Enquiries</title>

    <?php include 'layouts/head.php'; ?>
    <!-- datepicker css -->
    <!-- <link href="/dist/assets/libs/bootstrap/" rel="stylesheet"> -->
    <?php include 'layouts/head-style.php'; ?>

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
                $maintitle = "Araz";
                $title = "Manage Pending Araz";
                ?>
                <?php include 'layouts/breadcrumb.php'; ?>

                <!-- end page title -->


                <?php
                // Assuming you have a database connection established
                
                // Your database credentials
                include "layouts/config.php";
                ?>

                <!-- end row -->

                <!-- <div>
                    <a href="export-to-excel.php" class="btn btn-secondary"> Export Data To Excel</a>
                </div> -->
                <br><br>
                <div class="row">
                    <?php
                    // SQL query to get user information
                    $sql = "SELECT * FROM araz WHERE status = 'pending' order by id desc";
                    $result = $link->query($sql);

                    // Check if the query was successful
                    if ($result) {
                        // Loop through each row of the result set
                        while ($row = $result->fetch_assoc()) {
                            $originalDate = $row["created_at"];
                            $dateTime = new DateTime($originalDate);
                            $formattedDate = $dateTime->format('j F Y g:i A');
                            ?>
                            <div class="col-xl-4 col-sm-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-lg">
                                                <div
                                                    class="avatar-title bg-primary-subtle text-primary display-4 m-0 rounded-circle">
                                                    <i style="color:#145a5f" class="bx bxs-user-circle"></i>
                                                </div>
                                            </div>
                                            <div class="flex-1 ms-3">
                                                <h5 class="font-size-15 mb-1"><a href="#"
                                                        class="text-dark"><?php echo $row["name"] ?></a></h5>
                                                <p class="text-muted mb-0">Id:- <?php echo $row["id"] ?></p>
                                            </div>
                                        </div>
                                        <div class="mt-3 pt-1">
                                            <p class="text-muted mb-0">
                                                <i class="font-size-15 align-middle pe-2 text-primary"></i>
                                                User ID : <a href="#"><?php echo $row["user_id"]; ?></a>
                                            </p>
                                            <p class="text-muted mb-0">
                                                <i class="font-size-15 align-middle pe-2 text-primary"></i>
                                                Email : <a
                                                    href="mailto:<?php echo $row["email"]; ?>"><?php echo $row["email"]; ?></a>
                                            </p>
                                            <p class="text-muted mb-0">
                                                <i class="font-size-15 align-middle pe-2 text-primary"></i>
                                                Mobile : <a
                                                    href="tel:<?php echo $row["number"]; ?>"><?php echo $row["number"]; ?></a>
                                            </p>
                                            <p class="text-muted mb-0">
                                                <i class="font-size-15 align-middle pe-2 text-primary"></i>
                                                Enquired At: <?php echo $formattedDate; ?>
                                            </p>
                                            <p class="text-muted mb-0">
                                                <i class="font-size-15 align-middle pe-2 text-primary"></i>
                                                City : <a href="#"><?php echo $row["city"]; ?></a>
                                            </p>
                                            <p class="text-muted mb-0">
                                                <i class="font-size-15 align-middle pe-2 text-primary"></i>
                                                Araz : <?php if (isset($row["araz"])) {
                                                    echo $row["araz"];
                                                } ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="btn-group" role="group">
                                        <form style="margin-right: auto;margin-left: auto;" action="delete-araz.php" method="POST">
                                            <input type="hidden" name="id" id="id" value="<?php echo $row["id"]; ?>">
                                            <button type="submit" class="btn btn-primary" style=" width:130px; background-color: #28a745; border: none; padding: 8px 15px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.2); font-weight: bold; color: white; transition: background-color 0.3s, box-shadow 0.3s;">
                                                <i class="uil uil-envelope-alt me-1"></i> Delete
                                            </button>
                                        </form>
                                        <form style="margin-right: auto;margin-left: auto;" action="view-user-files.php" method="POST">
                                            <input type="hidden" name="id" id="id" value="<?php echo $row["id"]; ?>">
                                            <button type="submit" class="btn btn-primary" style=" width:130px; background-color: #28a745; border: none; padding: 8px 15px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.2); font-weight: bold; color: white; transition: background-color 0.3s, box-shadow 0.3s;">
                                                <i class="uil uil-envelope-alt me-1"></i> View Files
                                            </button>
                                        </form>
                                        <form style="margin-right: auto;margin-left: auto;" action="reply-user.php" method="POST">
                                            <input type="hidden" name="id" id="id" value="<?php echo $row["id"]; ?>">
                                            <button type="submit" class="btn btn-primary" style=" width:130px; background-color: #28a745; border: none; padding: 8px 15px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.2); font-weight: bold; color: white; transition: background-color 0.3s, box-shadow 0.3s;">
                                                <i class="uil uil-envelope-alt me-1"></i> Reply
                                            </button>
                                        </form>
                                    </div>
                                    <br>
                                </div>
                                <!-- end card -->
                            </div>

                        <?php }
                    } else {
                        // Display an error message if the query fails
                        echo "Error: " . $sql . "<br>" . $link->error;
                    } ?>
                    <!-- end col -->
                </div>
            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->

        <?php include 'layouts/footer.php'; ?>
    </div>
    <!-- end main content-->

</div>
<!-- END layout-wrapper -->

<?php include 'layouts/right-sidebar.php'; ?>

<?php include 'layouts/vendor-scripts.php'; ?>


</body>

</html>