<?php
// Start output buffering to prevent premature output issues
ob_start();

// Include Database Configuration
include "layouts/config.php";

// Delete Contact Message
if (isset($_GET['delete_id'])) {
    $id = intval($_GET['delete_id']); // Convert to integer to prevent SQL injection

    $sql = "DELETE FROM contact WHERE id = ?";
    $stmt = $link->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    // Redirect to contact.php (works both locally and live)
    header("Location: contact.php");
    exit();
}

// Flush output buffer (ensures no premature output)
ob_end_flush();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Contact Messages</title>
    <?php include 'layouts/head.php'; ?>
    <?php include 'layouts/head-style.php'; ?>
</head>

<body>
    <?php include 'layouts/body.php'; ?>
    <div id="layout-wrapper">
        <?php include 'layouts/menu-admin.php'; ?>

        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <?php
                    $maintitle = "Contact Messages";
                    $title = "Contact Us";
                    include 'layouts/breadcrumb.php';
                    ?>

                    <?php if (isset($_SESSION['message'])) : ?>
                        <script>
                            alert("<?php echo $_SESSION['message']; ?>");
                        </script>
                        <?php unset($_SESSION['message']); ?>
                    <?php endif; ?>

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <!-- Contact Table -->
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered align-middle">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Name</th>
                                                    <th>Mobile</th>
                                                    <th>Message</th>
                                                    <th>Service</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql = "SELECT id, name, mobile, message, service FROM contact ORDER BY id DESC";
                                                $result = $link->query($sql);

                                                $counter = 1;

                                                if ($result && $result->num_rows > 0) {
                                                    while ($row = $result->fetch_assoc()) {
                                                ?>
                                                        <tr>
                                                            <td><?php echo $counter; ?></td>
                                                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                                                            <td>
                                                                <a href="https://wa.me/<?php echo htmlspecialchars($row['mobile']); ?>" target="_blank" class="text-success me-2">
                                                                    <i class="fa-brands fa-whatsapp fa-lg"></i>
                                                                </a>
                                                                <a href="tel:<?php echo htmlspecialchars($row['mobile']); ?>" target="_blank" class="text-primary me-2">
                                                                    <i class="fa-solid fa-phone fa-lg"></i>
                                                                </a>
                                                                <span class="fw-bold text-dark"><?php echo htmlspecialchars($row['mobile']); ?></span>
                                                            </td>
                                                            <td><?php echo htmlspecialchars($row['message']); ?></td>
                                                            <td><?php echo htmlspecialchars($row['service']); ?></td>
                                                            <td>
                                                                <a href="javascript:void(0);" onclick="confirmDelete(<?php echo $row['id']; ?>)">
                                                                    <i class="fa-solid fa-trash text-danger" style="font-size: 1.3rem;"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                <?php
                                                        $counter++;
                                                    }
                                                } else {
                                                    echo "<tr><td colspan='6' class='text-center'>No contact messages found.</td></tr>";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- End Contact Table -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- container-fluid -->
            </div> <!-- End Page-content -->
            <?php include 'layouts/footer.php'; ?>
        </div>
    </div>
    <?php include 'layouts/right-sidebar.php'; ?>
    <?php include 'layouts/vendor-scripts.php'; ?>

    <script>
        function confirmDelete(id) {
            if (confirm("Are you sure you want to delete this contact message?")) {
                window.location.href = "contact.php?delete_id=" + id;
                setTimeout(function () {
                    location.reload(); // JavaScript fallback if PHP redirection fails
                }, 2000);
            }
        }
    </script>
</body>

</html>
