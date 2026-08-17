<?php
include "layouts/config.php";

// DELETE BOOKING LOGIC (Before HTML output)
if (isset($_GET['delete_id'])) {
    $id = intval($_GET['delete_id']); // Secure input

    $sql = "DELETE FROM booking WHERE id = ?";
    $stmt = $link->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $stmt->close();
        $link->close();
        header("Location: booking-enquiry.php"); // Redirect after deletion
        exit; // Ensure script stops execution
    }
}

// Start HTML after handling delete request
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Booking Enquiries</title>
    <?php include 'layouts/head.php'; ?>
    <?php include 'layouts/head-style.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>
    <?php include 'layouts/body.php'; ?>
    <div id="layout-wrapper">
        <?php include 'layouts/menu-admin.php'; ?>

        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <?php
                    $maintitle = "Booking Enquiries";
                    $title = "Manage Booking Enquiries";
                    include 'layouts/breadcrumb.php';
                    ?>

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered align-middle">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Guest</th>
                                                    <th>Villas</th>
                                                    <th>Check-In</th>
                                                    <th>Check-Out</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Mobile</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                // FETCH BOOKINGS FROM DATABASE
                                                $sql = "SELECT id, guest, villas, check_in, check_out, name, email, mobile FROM booking ORDER BY id DESC";
                                                $result = $link->query($sql);

                                                $counter = 1;

                                                if ($result && $result->num_rows > 0) {
                                                    while ($row = $result->fetch_assoc()) {
                                                ?>
                                                        <tr>
                                                            <td><?php echo $counter; ?></td>
                                                            <td><?php echo htmlspecialchars($row['guest']); ?></td>
                                                            <td><?php echo htmlspecialchars($row['villas']); ?></td>
                                                            <td><?php echo date('d-m-Y', strtotime($row['check_in'])); ?></td>
                                                            <td><?php echo date('d-m-Y', strtotime($row['check_out'])); ?></td>
                                                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                                                            <td>
                                                                <a href="mailto:<?php echo htmlspecialchars($row['email']); ?>" target="_blank" class="text-success me-2">
                                                                    <i class="fa-solid fa-envelope fa-lg"></i>
                                                                </a>
                                                                <?php echo htmlspecialchars($row['email']); ?>
                                                            </td>
                                                            <td>
                                                                <a href="https://wa.me/<?php echo htmlspecialchars($row['mobile']); ?>" target="_blank" class="text-success me-2">
                                                                    <i class="fa-brands fa-whatsapp fa-lg"></i>
                                                                </a>
                                                                <a href="tel:<?php echo htmlspecialchars($row['mobile']); ?>" target="_blank" class="text-primary me-2">
                                                                    <i class="fa-solid fa-phone fa-lg"></i>
                                                                </a>
                                                                <span class="fw-bold text-dark"><?php echo htmlspecialchars($row['mobile']); ?></span>
                                                            </td>
                                                            <td>
                                                                <a href="#" class="text-danger delete-btn" data-id="<?php echo $row['id']; ?>">
                                                                    <i class="fa-solid fa-trash" style="font-size: 1.3rem;"></i>
                                                                </a>

                                                                <a href="final-booking-edit.php?id=<?php echo $row['id']; ?>" class="text-primary">
                                                                    <i class="fa-solid fa-edit" style="font-size: 1.3rem;"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                <?php
                                                        $counter++;
                                                    }
                                                } else {
                                                    echo "<tr><td colspan='9' class='text-center'>No booking enquiries found.</td></tr>";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
            </div> 
            <?php include 'layouts/footer.php'; ?>
        </div>
    </div>
    <?php include 'layouts/right-sidebar.php'; ?>
    <?php include 'layouts/vendor-scripts.php'; ?>

    <script>
      

        //-------------------------------
        document.addEventListener("DOMContentLoaded", function () {
    console.log("sweet alert file called... ! ");
    document.querySelectorAll(".delete-btn").forEach(button => {
        button.addEventListener("click", function (event) {
            event.preventDefault(); // Prevent default link behavior

            let bookingId = this.getAttribute("data-id"); // Get booking ID

            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    // Send AJAX request to delete the booking
                    fetch("booking-enquiry.php?delete_id=" + bookingId, {
                        method: "GET"
                    })
                    .then(response => response.text())
                    .then(data => {
                        // Show success message
                        Swal.fire({
                            title: "Deleted!",
                            text: "The booking has been deleted.",
                            icon: "success",
                            timer: 1000,
                            showConfirmButton: false
                        });

                        // Redirect smoothly after a short delay
                        setTimeout(() => {
                            window.location.href = "booking-enquiry.php";
                        }, 1000);
                    })
                    .catch(error => console.error("Error:", error));
                }
            });
        });
    });
});

    </script>
    <!-- <script src="assets/js/sweetAlert.js"></script> -->

</body>
</html>
