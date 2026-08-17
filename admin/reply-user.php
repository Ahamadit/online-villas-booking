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
                $maintitle = "Reply User";
                $title = "Reply To User";
                ?>
                <?php include 'layouts/breadcrumb.php'; ?>
                <!-- end page title -->
                <?php if (isset($_POST["id"])) { ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <form method="post" action="submit-reply.php" enctype="multipart/form-data">
                                        <input type="hidden" name="id"
                                            value="<?php echo htmlspecialchars($_POST['id']); ?>">

                                        <div class="form-group row mb-4">
                                            <label for="paragraph" class="col-form-label col-lg-2">Paragraph</label>
                                            <div class="col-lg-10">
                                                <textarea id="paragraph" name="paragraph" class="form-control"
                                                    placeholder="Enter your paragraph here..." required></textarea>
                                            </div>
                                        </div>

                                        <div class="form-group row mb-4">
                                            <label for="fileupload" class="col-form-label col-lg-2">Upload Files</label>
                                            <div class="col-lg-10">
                                                <input type="file" id="fileupload" name="files[]" multiple
                                                    class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group row mb-4">
                                            <label class="col-form-label col-lg-2">Upload from Assets</label>
                                            <div class="col-lg-10">
                                                <input type="checkbox" id="uploadFromAssets" name="uploadFromAssets">
                                            </div>
                                        </div>

                                        <div class="form-group row mb-4" style="display:none;" id="categorySelector">
                                            <label for="categorySelect" class="col-form-label col-lg-2">Select
                                                Category</label>
                                            <div class="col-lg-10">
                                                <select id="categorySelect" name="category_id" class="form-control">
                                                    <option value="">Select a Category...</option>
                                                    <?php
                                                    include "layouts/config.php";
                                                    $sql = "SELECT id, category_name FROM assets_category";
                                                    $result = $link->query($sql);
                                                    while ($row = $result->fetch_assoc()) {
                                                        echo "<option value='{$row['id']}'>{$row['category_name']}</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row mb-4" style="display:none;" id="fileList">
                                            <label class="col-form-label col-lg-2">Select Files</label>
                                            <div class="col-lg-10">
                                                <!-- Files will be listed here via JavaScript based on category selection -->
                                            </div>
                                        </div>

                                        <div class="row justify-content-end">
                                            <div class="col-lg-10">
                                                <button type="submit" class="btn btn-success">Submit Form</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <script>
                    document.getElementById('uploadFromAssets').addEventListener('change', function () {
                        var display = this.checked ? 'block' : 'none';
                        document.getElementById('categorySelector').style.display = display;
                        document.getElementById('fileList').style.display = display;
                    });

                    document.getElementById('categorySelect').addEventListener('change', function () {
                        var categoryId = this.value;
                        if (categoryId) {
                            // Fetch files based on selected category and update the fileList div
                            fetch('fetch-files.php?category_id=' + categoryId)
                                .then(response => response.json())
                                .then(data => {
                                    var fileListDiv = document.getElementById('fileList');
                                    fileListDiv.innerHTML = ''; // Clear previous entries
                                    data.forEach(function (file) {
                                        fileListDiv.innerHTML +=
                                            '<input type="checkbox" name="selectedFiles[]" value="' +
                                            file + '"> ' + file + '<br>';
                                    });
                                });
                        }
                    });
                </script>

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