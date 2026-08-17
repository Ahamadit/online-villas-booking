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
                            timer: 2000,
                            showConfirmButton: false
                        });

                        // Redirect smoothly after a short delay
                        setTimeout(() => {
                            window.location.href = "booking-enquiry.php";
                        }, 2000);
                    })
                    .catch(error => console.error("Error:", error));
                }
            });
        });
    });
});
