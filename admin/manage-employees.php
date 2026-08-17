<?php include 'layouts/session.php'; ?>
<?php include 'layouts/main.php'; ?>

<head>
    <title>Manage Employees</title>
    <?php include 'layouts/head.php'; ?>
    <?php include 'layouts/head-style.php'; ?>
</head>

<?php include 'layouts/body.php'; ?>

<!-- Begin page -->
<div id="layout-wrapper">
    <?php include 'layouts/menu-admin.php'; ?>

    <!-- Start right Content here -->
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <!-- Page title -->
                <?php
                $maintitle = "Employees";
                $title = "Manage Employees";
                include 'layouts/breadcrumb.php';
                ?>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">

                                <!-- Employees Table -->
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered align-middle">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>ID</th>
                                                <th>Employee Name</th>
                                                <th>Designation</th>
                                                <th>Department</th>
                                                <th>Date of Joining</th>
                                                <th>Email</th>
                                                <th>Contact Number</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            include "layouts/config.php";

                                            // Fetch all employees along with their designation and department names
                                            $sql = "SELECT e.id, e.employee_name, d.name AS designation_name, dept.name AS department_name, e.date_of_joining, e.email, e.number
                                                    FROM employees e
                                                    LEFT JOIN designation d ON e.designation_id = d.id
                                                    LEFT JOIN department dept ON e.department_id = dept.id";
                                            $result = $link->query($sql);

                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['employee_name']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['designation_name']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['department_name']); ?></td>
                                                        <td><?php echo date('d-m-Y', strtotime($row['date_of_joining'])); ?></td>
                                                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['number']); ?></td>
                                                        <td>
                                                            <!-- Edit Button -->
                                                            <a href="edit-employee.php?id=<?php echo urlencode($row['id']); ?>" class="btn btn-primary btn-sm">Edit</a>
                                                            <!-- Delete Button -->
                                                            <a href="#" onclick="confirmDeletion(<?php echo $row['id']; ?>)" class="btn btn-danger btn-sm">Delete</a>
                                                            <a href="calendar.php?id=<?php echo urlencode($row['id']); ?>" class="btn btn-success btn-sm">Calendar</a>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                            } else {
                                                echo "<tr><td colspan='8' class='text-center'>No employees found.</td></tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Add Employee Button -->
                                <div class="mt-3">
                                    <a href="add-employee.php" class="btn btn-success">Add Employee</a>
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

<!-- Delete Confirmation Script -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDeletion(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'Deleting this employee cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel',
        customClass: {
            confirmButton: 'btn btn-danger',
            cancelButton: 'btn btn-secondary'
        },
        buttonsStyling: false
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'delete-employee.php?id=' + id;
        }
    });
}
</script>

<?php include 'layouts/right-sidebar.php'; ?>
<?php include 'layouts/vendor-scripts.php'; ?>
</body>

</html>
