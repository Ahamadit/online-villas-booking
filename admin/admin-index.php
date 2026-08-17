<?php include 'layouts/session.php'; ?>
<?php include 'layouts/main.php'; ?>

<head>

    <title>Admin Panel</title>

    <?php include 'layouts/head.php'; ?>

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
                $maintitle = "Dashboard";
                $title = "Welcome !";
                ?>
                <?php include 'layouts/breadcrumb.php'; ?>
                <!-- end page title -->

                <div class="row">
                    <?php include "layouts/config.php"; ?>
                    <div class="col-xl-3 col-md-6">
                        <!-- card -->
                        <?php
                        // Check connection
                        if ($link->connect_error) {
                            die("Connection failed: " . $link->connect_error);
                        }

                        // SQL query to get the total number of users
                        $sql = "SELECT COUNT(*) AS total_department FROM department";
                        $result = $link->query($sql);

                        // Check if the query was successful
                        if ($result) {
                            // Fetch the result as an associative array
                            $row = $result->fetch_assoc();

                            // Extract the total number of users
                            $totalProducts = $row['total_department']; ?>
                            <div class="card card-h-100">
                                <!-- card body -->
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <span class="text-muted mb-3 lh-1 d-block text-truncate">Total Departments</span>
                                            <h4 class="mb-3">
                                                <span class="counter-value" data-target="<?php echo "$totalProducts"; ?>">0</span>
                                            </h4>
                                        </div>
                                    </div>
                                </div><!-- end card body -->
                            </div><!-- end card -->
                        <?php
                        } else {
                            // Display an error message if the query fails
                            echo "Error: " . $sql . "<br>" . $link->error;
                        }

                        // Close the database connection

                        ?>
                    </div><!-- end col -->
                    <div class="col-xl-3 col-md-6">
                        <!-- card -->
                        <?php
                        // Check connection
                        if ($link->connect_error) {
                            die("Connection failed: " . $link->connect_error);
                        }

                        // SQL query to get the total number of users
                        $sql = "SELECT COUNT(*) AS total_araz FROM araz WHERE status = 'pending'";
                        $result = $link->query($sql);

                        // Check if the query was successful
                        if ($result) {
                            // Fetch the result as an associative array
                            $row = $result->fetch_assoc();

                            // Extract the total number of users
                            $totalProducts = $row['total_araz']; ?>
                            <div class="card card-h-100">
                                <!-- card body -->
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <span class="text-muted mb-3 lh-1 d-block text-truncate">Pending Araz</span>
                                            <h4 class="mb-3">
                                                <span class="counter-value" data-target="<?php echo "$totalProducts"; ?>">0</span>
                                            </h4>
                                        </div>
                                    </div>
                                </div><!-- end card body -->
                            </div><!-- end card -->
                        <?php
                        } else {
                            // Display an error message if the query fails
                            echo "Error: " . $sql . "<br>" . $link->error;
                        }

                        // Close the database connection

                        ?>
                    </div><!-- end col -->
                    <div class="col-xl-3 col-md-6">
                        <!-- card -->
                        <?php
                        // Check connection
                        if ($link->connect_error) {
                            die("Connection failed: " . $link->connect_error);
                        }

                        // SQL query to get the total number of users
                        $sql = "SELECT COUNT(*) AS deleted_araz FROM araz WHERE status = 'deleted'";
                        $result = $link->query($sql);

                        // Check if the query was successful
                        if ($result) {
                            // Fetch the result as an associative array
                            $row = $result->fetch_assoc();

                            // Extract the total number of users
                            $totalProducts = $row['deleted_araz']; ?>
                            <div class="card card-h-100">
                                <!-- card body -->
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <span class="text-muted mb-3 lh-1 d-block text-truncate">Deleted Araz</span>
                                            <h4 class="mb-3">
                                                <span class="counter-value" data-target="<?php echo "$totalProducts"; ?>">0</span>
                                            </h4>
                                        </div>
                                    </div>
                                </div><!-- end card body -->
                            </div><!-- end card -->
                        <?php
                        } else {
                            // Display an error message if the query fails
                            echo "Error: " . $sql . "<br>" . $link->error;
                        }

                        // Close the database connection

                        ?>
                    </div><!-- end col -->
                    <div class="col-xl-3 col-md-6">
                        <!-- card -->
                        <?php
                        // Check connection
                        if ($link->connect_error) {
                            die("Connection failed: " . $link->connect_error);
                        }

                        // SQL query to get the total number of users
                        $sql = "SELECT COUNT(*) AS araz FROM completed_araz";
                        $result = $link->query($sql);

                        // Check if the query was successful
                        if ($result) {
                            // Fetch the result as an associative array
                            $row = $result->fetch_assoc();

                            // Extract the total number of users
                            $totalProducts = $row['araz']; ?>
                            <div class="card card-h-100">
                                <!-- card body -->
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <span class="text-muted mb-3 lh-1 d-block text-truncate">Completed Araz</span>
                                            <h4 class="mb-3">
                                                <span class="counter-value" data-target="<?php echo "$totalProducts"; ?>">0</span>
                                            </h4>
                                        </div>
                                    </div>
                                </div><!-- end card body -->
                            </div><!-- end card -->
                        <?php
                        } else {
                            // Display an error message if the query fails
                            echo "Error: " . $sql . "<br>" . $link->error;
                        }

                        // Close the database connection

                        ?>
                    </div><!-- end col -->
                    <div class="col-xl-3 col-md-6">
                        <!-- card -->
                        <?php
                        // Check connection
                        if ($link->connect_error) {
                            die("Connection failed: " . $link->connect_error);
                        }

                        // SQL query to get the total number of users
                        $sql = "SELECT COUNT(*) AS total_categories FROM assets_category";
                        $result = $link->query($sql);

                        // Check if the query was successful
                        if ($result) {
                            // Fetch the result as an associative array
                            $row = $result->fetch_assoc();

                            // Extract the total number of users
                            $totalProducts = $row['total_categories']; ?>
                            <div class="card card-h-100">
                                <!-- card body -->
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <span class="text-muted mb-3 lh-1 d-block text-truncate">Total Categories</span>
                                            <h4 class="mb-3">
                                                <span class="counter-value" data-target="<?php echo "$totalProducts"; ?>">0</span>
                                            </h4>
                                        </div>
                                    </div>
                                </div><!-- end card body -->
                            </div><!-- end card -->
                        <?php
                        } else {
                            // Display an error message if the query fails
                            echo "Error: " . $sql . "<br>" . $link->error;
                        }

                        // Close the database connection

                        ?>
                    </div><!-- end col -->
                    <div class="col-xl-3 col-md-6">
                        <!-- card -->
                        <?php
                        // Check connection
                        if ($link->connect_error) {
                            die("Connection failed: " . $link->connect_error);
                        }

                        // SQL query to get the total number of users
                        $sql = "SELECT COUNT(*) AS total_files FROM assets_file";
                        $result = $link->query($sql);

                        // Check if the query was successful
                        if ($result) {
                            // Fetch the result as an associative array
                            $row = $result->fetch_assoc();

                            // Extract the total number of users
                            $totalProducts = $row['total_files']; ?>
                            <div class="card card-h-100">
                                <!-- card body -->
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <span class="text-muted mb-3 lh-1 d-block text-truncate">Total File
                                                Uploaded</span>
                                            <h4 class="mb-3">
                                                <span class="counter-value" data-target="<?php echo "$totalProducts"; ?>">0</span>
                                            </h4>
                                        </div>
                                    </div>
                                </div><!-- end card body -->
                            </div><!-- end card -->
                        <?php
                        } else {
                            // Display an error message if the query fails
                            echo "Error: " . $sql . "<br>" . $link->error;
                        }

                        // Close the database connection

                        ?>
                    </div><!-- end col -->
                </div>
                <!-- end card -->
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