<?php include 'layouts/session.php'; ?>
<?php include 'layouts/main.php'; ?>

<head>

    <title>Enquiries</title>

    <?php include 'layouts/head.php'; ?>
    <!-- datepicker css -->
    <!-- <link href="/dist/assets/libs/bootstrap/" rel="stylesheet"> -->
    <?php include 'layouts/head-style.php'; ?>
    <style>
        /* Default styles */
        .tab-pane {
            padding-left: 0;
            padding-right: 0;
        }

        /* Styles that apply only when the viewport is wider than 1000px */
        @media (min-width: 1000px) {
            .tab-pane {
                padding-left: 20rem;
                padding-right: 20rem;
            }
        }
    </style>
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
                $maintitle = "Files";
                $title = "User Files";
                ?>
                <?php include 'layouts/breadcrumb.php'; ?>
                <br><br>
                <?php
                // Include the database connection file
                include 'layouts/config.php';

                // Get the ID from the POST request
                $id = $_POST['id'];

                // Prepare the SQL query to retrieve the row with the corresponding ID
                $sql = "SELECT * FROM completed_araz WHERE id = ?";
                $stmt = $link->prepare($sql);
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $result = $stmt->get_result();

                // Check if the row exists
                if ($result->num_rows > 0) {
                    // Fetch the row data
                    $row = $result->fetch_assoc();

                    // Extract the file paths and convert them into an array
                    if (isset($row['filePaths']) && !empty($row['filePaths'])) {
                        $filePaths = explode(',', $row['filePaths']);
                        }
                        else
                        {
                            $filePaths = null;
                        }
                } else {
                }

                // Close the statement and connection
                $stmt->close();
                $link->close();
                ?>

                <div>
                    <div class="tab-pane" id="post" role="tabpanel">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row d-flex justify-content-center">
                                            <div class="col">
                                                <p style="text-align: center;" class="text-dark mb-1 fw-semibold">
                                                    <?php echo nl2br(htmlspecialchars($row['araz'])); ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end card-body-->
                                </div>
                                <!--end card-->
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                    </div>
                    <div class="tab-pane" id="gallery" role="tabpanel">
                        <?php if ($filePaths != null) { ?>
                            <?php foreach ($filePaths as $filePath) : ?>
                                <?php $filePath = "../" . $filePath ?>
                                <?php $fileInfo = pathinfo($filePath); ?>
                                <?php if (in_array($fileInfo['extension'], ['jpg', 'jpeg', 'png', 'gif', 'webp'])) : ?>
                                    <!-- Image Section -->
                                    <div style="border: none; border-radius: 10px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); margin-bottom: 20px;">
                                        <div style=" padding: 10px; text-align: center; border-bottom: 1px solid #dee2e6; border-radius: 10px 10px 0 0;">
                                            <h5 style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">Images</h5>
                                        </div>
                                        <div style="padding: 20px; text-align: center;">
                                            <img src="<?php echo htmlspecialchars($filePath); ?>" alt="Image" style="border-radius: 10px; width: 100%; max-width: 600px;">
                                            <a href="<?php echo htmlspecialchars($filePath); ?>" download><button style="margin-top: 10px; width: 100%; border-radius: 5px; background-color: #28a745; color: white; border: none; padding: 10px;">Download</button></a>
                                        </div>
                                    </div>
                                <?php elseif (in_array($fileInfo['extension'], ['mp3', 'wav'])) : ?>
                                    <!-- Audio Section -->
                                    <div style="border: none; border-radius: 10px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); margin-bottom: 20px;">
                                        <div style=" padding: 10px; text-align: center; border-bottom: 1px solid #dee2e6; border-radius: 10px 10px 0 0;">
                                            <h5 style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">Audio</h5>
                                        </div>
                                        <div style="padding: 20px; text-align: center;">
                                            <audio controls style="width: 100%; border-radius: 10px;">
                                                <source src="<?php echo htmlspecialchars($filePath); ?>" type="audio/mpeg">
                                                Your browser does not support the audio element.
                                            </audio>
                                            <a href="<?php echo htmlspecialchars($filePath); ?>" download><button style="margin-top: 10px; width: 100%; border-radius: 5px; background-color: #28a745; color: white; border: none; padding: 10px;">Download</button></a>
                                        </div>
                                    </div>
                                <?php elseif (in_array($fileInfo['extension'], ['mp4', 'webm', 'ogg'])) : ?>
                                    <!-- Video Section -->
                                    <div style="border: none; border-radius: 10px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); margin-bottom: 20px;">
                                        <div style=" padding: 10px; text-align: center; border-bottom: 1px solid #dee2e6; border-radius: 10px 10px 0 0;">
                                            <h5 style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">Videos</h5>
                                        </div>
                                        <div style="padding: 20px; text-align: center;">
                                            <video controls style="width: 100%; border-radius: 10px;">
                                                <source src="<?php echo htmlspecialchars($filePath); ?>" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                            <a href="<?php echo htmlspecialchars($filePath); ?>" download><button style="margin-top: 10px; width: 100%; border-radius: 5px; background-color: #28a745; color: white; border: none; padding: 10px;">Download</button></a>
                                        </div>
                                    </div>
                                <?php else : ?>
                                    <!-- Files Section -->
                                    <div style="border: none; border-radius: 10px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); margin-bottom: 20px;">
                                        <div style=" padding: 10px; text-align: center; border-bottom: 1px solid #dee2e6; border-radius: 10px 10px 0 0;">
                                            <h5 style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">Files</h5>
                                        </div>
                                        <div style="padding: 20px; text-align: center;">
                                            <div style="padding: 10px; border-radius: 10px; border: 1px solid #ddd;">
                                                <p style="margin: 0;"><?php echo htmlspecialchars($fileInfo['basename']); ?></p>
                                            </div>
                                            <a href="<?php echo htmlspecialchars($filePath); ?>" download><button style="margin-top: 10px; width: 100%; border-radius: 5px; background-color: #28a745; color: white; border: none; padding: 10px;">Download</button></a>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php } else { echo "No Files Attached"; } ?>                     
                    </div>

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