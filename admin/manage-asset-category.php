<?php include 'layouts/session.php'; ?>
<?php include 'layouts/main.php'; ?>
<head>

    <title>Add Asset Category</title>

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
                
                <!-- end page title -->

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-sm-4">
                                        
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="text-sm-end">
                                            <a href="add-asset-category.php" class="btn btn-success btn-rounded waves-effect waves-light mb-2 me-2"><i class="mdi mdi-plus me-1"></i> Add New category</a>
                                        </div>
                                    </div><!-- end col-->
                                </div>

                                <div class="table-responsive">
                                    <?php
// Assuming you have a database connection established
include "layouts/config.php";

// Your SQL query to retrieve approved companies
$sql = "SELECT * FROM assets_category";
$result = mysqli_query($link, $sql);

// Check if there are any approved companies
if (mysqli_num_rows($result) > 0) {
?>
                                    <table class="table align-middle table-nowrap table-check">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="align-middle">ID</th>
                                                <th class="align-middle">Name</th>
                                                <th class="align-middle">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                         <?php   while ($row = mysqli_fetch_assoc($result)) { ?>
                                            <tr>
                                                <td><?php echo $row["id"] ?></td>
                                                <td>
                                                    <?php echo $row["category_name"] ?>
                                                </td>
                                                <!-- <td>
                                                    <button type="button" class="btn btn-primary btn-sm btn-rounded">
                                                        View Details
                                                    </button>
                                                </td> -->
                                                <td>
                                                    <form class="d-flex gap-3" action="delete-assets-category.php" method="post">
                                                        <input type="hidden" name="id" value="<?php echo $row["id"] ?>">
                                                        <button type="submit" class="text-danger" style="background: none; border:none;"><i class="mdi mdi-delete font-size-18"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                          <?php  } ?>
 

                                        </tbody>
                                    </table>
                                 <?php   } else {
    echo 'No  Categories found.';
}

// Close the database connection
mysqli_close($link);
?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->




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