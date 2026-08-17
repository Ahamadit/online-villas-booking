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
                <?php
                $maintitle = "Asset";
                $title = "Add Asset Category";
                ?>
                <?php include 'layouts/breadcrumb.php'; ?>
                <!-- end page title -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Enter Name</h4>
                                <form method="post" action="submit-asset-category.php" enctype="multipart/form-data">
                                    <div data-repeater-list="outer-group" class="outer">
                                        <div data-repeater-item class="outer">
                                            <div class="form-group row mb-4">
                                                <label for="blogname" class="col-form-label col-lg-2">Category Name</label>
                                                <div class="col-lg-10">
                                                    <input id="blogname" name="name" type="text" class="form-control" placeholder="Enter Category Name..." required>
                                                </div>
                                            </div>
                                            <div class="row justify-content-end">
                                                <div class="col-lg-10">
                                                    <button type="submit" class="btn btn-success">Submit Category</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
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

<!--tinymce js-->
<script src="assets/libs/tinymce/tinymce.min.js"></script>

<!-- form repeater js -->
<script src="assets/libs/jquery.repeater/jquery.repeater.min.js"></script>

<script src="assets/js/pages/task-create.init.js"></script>

</body>

</html>