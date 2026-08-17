<?php include 'layouts/session.php'; ?>
<?php include 'layouts/main.php'; ?>

<head>

    <title>Add Asset Files</title>

    <?php include 'layouts/head.php'; ?>
    <!-- datepicker css -->
    <!-- <link href="/dist/assets/libs/bootstrap/" rel="stylesheet"> -->
    <?php include 'layouts/head-style.php'; ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

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
                $title = "Add Files";
                ?>
                <?php include 'layouts/breadcrumb.php'; ?>
                <!-- end page title -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Enter Details</h4>
                                <?php
                                include "layouts/config.php";
                                $sql = "SELECT id, category_name FROM assets_category";
                                $result = $link->query($sql);
                                ?>

                                <form method="post" action="submit-assets-files.php" enctype="multipart/form-data">
                                    <div data-repeater-list="outer-group" class="outer">
                                        <div data-repeater-item class="outer">
                                            <!-- Category Selection -->
                                            <div class="form-group row mb-4">
                                                <label for="category" class="col-form-label col-lg-2">Select
                                                    Category</label>
                                                <div class="col-lg-10">
                                                    <select id="category" name="category_id" class="form-control"
                                                        required>
                                                        <option value="" disabled selected>Select Category...</option>
                                                        <?php
                                                        // Fetch categories from the database
                                                        include "layouts/config.php"; // Ensure this file establishes the $link connection
                                                        
                                                        $sql = "SELECT id, category_name FROM assets_category";
                                                        $result = $link->query($sql);

                                                        if ($result->num_rows > 0) {
                                                            while ($row = $result->fetch_assoc()) {
                                                                echo "<option value='" . htmlspecialchars($row["id"]) . "'>" . htmlspecialchars($row["category_name"]) . "</option>";
                                                            }
                                                        } else {
                                                            echo "<option value='' disabled>No categories available</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- File Upload -->
                                            <div class="form-group row mb-4">
                                                <label class="col-form-label col-lg-2">Add Files</label>
                                                <div class="col-lg-10">
                                                    <input type="file" id="asset_files" name="asset_files[]" multiple
                                                        class="form-control" required>
                                                </div>
                                            </div>

                                            <!-- File List with Custom Name Inputs -->
                                            <div id="file-list" class="form-group row mb-4">
                                                <!-- Dynamically populated file list with custom name inputs -->
                                            </div>

                                            <!-- Submit Button -->
                                            <div class="row justify-content-end">
                                                <div class="col-lg-10">
                                                    <button type="submit" class="btn btn-success">Submit Files</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <!-- Include Bootstrap JS and dependencies (optional) -->
                                <script
                                    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js">
                                    </script>

                                <!-- JavaScript to handle file selection and display custom name inputs -->
                                <script>
                                    document.getElementById('asset_files').addEventListener('change', function (event) {
                                        var fileList = event.target.files;
                                        var fileListContainer = document.getElementById('file-list');
                                        fileListContainer.innerHTML = ''; // Clear previous content

                                        if (fileList.length > 0) {
                                            var table = document.createElement('table');
                                            table.className = 'table table-bordered';
                                            var thead = document.createElement('thead');
                                            var headerRow = document.createElement('tr');

                                            var thOriginal = document.createElement('th');
                                            thOriginal.textContent = 'Original Name';

                                            var thCustom = document.createElement('th');
                                            thCustom.textContent = 'Custom Name (optional)';

                                            headerRow.appendChild(thOriginal);
                                            headerRow.appendChild(thCustom);
                                            thead.appendChild(headerRow);
                                            table.appendChild(thead);

                                            var tbody = document.createElement('tbody');

                                            for (var i = 0; i < fileList.length; i++) {
                                                var file = fileList[i];
                                                var tr = document.createElement('tr');

                                                var tdOriginal = document.createElement('td');
                                                // Display the file name without extension
                                                var originalName = file.name.substring(0, file.name.lastIndexOf(
                                                    '.')) || file.name;
                                                tdOriginal.textContent = originalName;

                                                var tdCustom = document.createElement('td');
                                                var input = document.createElement('input');
                                                input.type = 'text';
                                                input.name = 'custom_names[]';
                                                input.className = 'form-control';
                                                input.placeholder = 'Enter new name (optional)';
                                                tdCustom.appendChild(input);

                                                // Hidden input to store the original file name
                                                var hiddenInput = document.createElement('input');
                                                hiddenInput.type = 'hidden';
                                                hiddenInput.name = 'original_names[]';
                                                hiddenInput.value = file.name;
                                                tdCustom.appendChild(hiddenInput);

                                                tr.appendChild(tdOriginal);
                                                tr.appendChild(tdCustom);
                                                tbody.appendChild(tr);
                                            }

                                            table.appendChild(tbody);
                                            fileListContainer.appendChild(table);
                                        }
                                    });
                                </script>

                                <?php
                                $link->close();
                                ?>
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