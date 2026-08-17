<?php
include "layouts/config.php";

// Get the booking ID from URL
if (!isset($_GET['id'])) {
    die("Invalid request.");
}
$id = intval($_GET['id']);

// Fetch booking details
$sql = "SELECT * FROM final_booking WHERE id = ?";
$stmt = $link->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$booking = $result->fetch_assoc();

if (!$booking) {
    die("Booking not found.");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>House Rules - Retreat Villa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* General Styles */
        body {
            background-color: #f8f9fa;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Container */
        .container {
            max-width: 900px;
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            margin: 30px auto;
        }

        /* Headings */
        h2 {
            color: #343a40;
            font-weight: 700;
            text-align: center;
            margin-bottom: 15px;
        }

        h4 {
            color: #007bff;
            font-weight: 600;
            border-bottom: 2px solid #007bff;
            padding-bottom: 5px;
        }

        /* Subtitle */
        .text-muted {
            font-size: 1rem;
            margin-bottom: 20px;
            text-align: center;
        }

        /* Rule Sections */
        .rules-section {
            margin-bottom: 20px;
            padding: 15px;
            border-radius: 8px;
            background: #eef2f7;
            transition: 0.3s ease-in-out;
        }

        .rules-section:hover {
            background: #e3e9f1;
        }

        /* List Styling */
        .rules-section ul {
            list-style: none;
            padding: 0;
        }

        .rules-section ul li {
            padding: 8px 0;
            font-size: 1rem;
            position: relative;
            padding-left: 25px;
        }

        .rules-section ul li::before {
            content: '✔';
            color: #28a745;
            font-weight: bold;
            position: absolute;
            left: 0;
        }

        /* Signature Section */
        .signature {

            color: #343a40;
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
        }

        .signature h5 {
            color: #007bff;
            font-weight: 600;
            border-bottom: 2px solid #007bff;
            padding-bottom: 5px;
        }

        .signature p {
            font-size: 1rem;
            margin: 5px 0;
        }

        /* Signature Line */
        .signature p:last-child {
            margin-top: 10px;
            font-weight: bold;
        }

        .image-container {
            text-align: center;
        }

        img {
            max-width: 20%;
            height: auto;
            display: inline-block;
        }


        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding: 15px;
                margin: 20px;
            }

            h2 {
                font-size: 1.5rem;
            }

            h4 {
                font-size: 1.2rem;
            }

            .rules-section {
                padding: 12px;
            }

            .signature {
                text-align: center;
            }
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <div class="image-container">
            <!-- <img id="base64Image" alt="Converted Image" /> -->
            <!-- <img src="http://localhost/work/rahatvillas-live/assets/img/logos/logo.png" alt=""> -->
            <img src="https://rahatvillas.com/assets/img/logos/logo.png" alt="Logo">

            <h4 class="mt-4">Agreemnet Copy</h4>

        </div>

        <h2 class="text-center mt-2">MTDC Approved! Bungalows in Lonavala with Private Swimming Pool Only for Families</h2>
        <h5 class="text-center text-muted">To ensure a comfortable and safe stay, we would like you to read the following house rules:</h5>
        <hr>

        <div class="rules-section">
            <h4>Guest Details</h4>
            <p>Name: <strong><?php echo htmlspecialchars($booking['name']); ?></strong></p>
            <p>Mobile: <strong><?php echo htmlspecialchars($booking['mobile']); ?></strong></p>
            <p>Email: <strong><?php echo htmlspecialchars($booking['email']); ?></strong></p>
            <p>Price: <strong><i class="fa-solid fa-indian-rupee-sign"></i> <?php echo htmlspecialchars($booking['price']); ?></strong></p>
            <p>Bungalow: <strong><?php echo htmlspecialchars($booking['villas']); ?></strong></p>
            <p>Address: <strong>D/403 Shree Chaitanya CHS, Kharegaon Naka, Kalwa Thane-400605</strong></p>
            <p>Check-in: <strong><?php echo date('d-m-Y', strtotime($booking['check_in'])); ?></strong> | Check-out: <strong><?php echo date('d-m-Y', strtotime($booking['check_out'])); ?></strong></p>
            <p>Guests: <strong><?php echo htmlspecialchars($booking['guest']); ?></strong></p>
            <p>Signature: _______________________</p>
        </div>
        <div class="rules-section">
            <h4>Check-in and Check-out</h4>
            <ul>
                <li>Check in timing is at 01.00 pm and checkout is at 11.00 am.</li>
                <li>Customers are requested to submit ID Proof at the time of Check-in.</li>
                <li>Customers are requested to take care of their personal belongings.</li>
                <li>We will not be responsible for any theft or loss.</li>
                <li>Customers are requested to pay a Deposit of Rupees 5000 which will be used in case of damages.</li>
            </ul>
        </div>
        <br>

        <div class="rules-section">
            <h4>Pool Timings and Rules</h4>
            <ul>
                <li>Pool can be used from 8.00 am to 6.00 pm.</li>
                <li>Kids to use pool only under Adult Supervision.</li>
                <li>Food and Beverages not allowed inside the Pool.</li>
                <li>Pets not allowed to use the Pool.</li>
            </ul>
        </div>
        <br>
        <br>


        <div class="rules-section">
            <h4>Music Rules</h4>
            <ul>
                <li>Outdoors Music can be played from 11.00 am to 02.00 pm.</li>
                <li>Evening from 05.00 pm to 10.00 pm.</li>
                <li>02.00 to 05.00 in afternoon and after 10.00 pm in evening music is not allowed outdoors.</li>
            </ul>
        </div>
        <br>
        <br>



        <div class="rules-section ">
            <h4>Barbeque Timings</h4>
            <ul>
                <li>Barbeque to be done in Outdoor areas on Terrace, Pool Area, Garden Area between 06.00 pm to 11.00 pm.</li>
                <li>Outside Lights to be Off by 11.00 pm</li>
            </ul>
            <h5 class="text-center text-muted">By signing this House Rules it will be assumed that you have accepted above mentioned Terms and Conditions.</h5>
        </div>




        <div class="rules-section">
            <h4>House Rules</h4>
            <ul>
                <li>Property follows MTDC guidelines and is governed under the Home Stays Scheme of the Maharashtra Government.</li>
                <li>Respect the property; any damages to furniture or equipment will be charged to the guest.</li>
                <li>Smoking is allowed only in balconies or open spaces.</li>
                <li>Guests with babies/children below 5 years must avoid bedwetting; any damage to the mattress will require purchasing a new one.</li>
                <li>No outdoor footwear inside the bungalow, as red mud stains the floor and is difficult to clean.</li>
                <li>Switch off geysers, air conditioners, and lights when not in use.</li>
                <li>Music is allowed only until 10:00 PM at a low volume; DJ, speakers, or sound systems require prior permission from the local police station.</li>
                <li>No shouting, screaming, or use of foul language is allowed on the property.</li>
                <li>Garbage must be disposed of in dustbins; do not break bottles on society roads or in the pool.</li>
                <li>Do not keep valuables in the bungalow; the owner is not responsible for any theft or loss.</li>
                <li>Immoral or illegal activities are strictly prohibited; any violations will be reported to the police.</li>
                <li>Guests must submit a self-attested photo ID and address proof for all members staying in the villa. Entry details must be recorded in the caretaker’s register.</li>
                <li>The owner is not liable for any accidents that occur during the stay.</li>
                <li>Swimming costumes are mandatory in the pool to prevent water contamination.</li>
                <li>Games like Carrom, Chess, Ludo, Housie, and Badminton are available with the caretaker but require a refundable deposit.</li>
                <li>Advance payments are strictly non-refundable.</li>
                <li>Common passage areas are under CCTV surveillance as per Lonavala Police Station guidelines. Tampering with CCTV or WiFi will result in legal action.</li>
                <li>Access to the villa will be granted only after providing a signed agreement copy and hotel voucher.</li>
                <li>For any assistance, caretakers are available 24/7.</li>
                <li>Drugs, intoxication, or any prohibited substances under state or national law are strictly forbidden.</li>
                <li>Consumption of pork and alcohol is not preferred by the property owners.</li>
            </ul>

        </div>
        <h5 class="text-center text-muted">Approved by Maharashtra Tourism Development Corporation (MTDC) Active Member of Lonovala Homestay Association</h5>
        <div class="print-btn text-center">
            <button class="btn btn-primary" onclick="window.print()">Print</button>
            <button class="btn btn-success" id="download-pdf">Download PDF</button>
        </div>
    </div>


    <!-- Include jsPDF and html2canvas -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script>
        document.getElementById('download-pdf').addEventListener('click', function() {
            const {
                jsPDF
            } = window.jspdf;
            const doc = new jsPDF('p', 'mm', 'a4'); // A4 size in portrait

            const container = document.querySelector('.container');
            const buttonContainer = document.querySelector('.print-btn');

            // Hide buttons before capturing
            buttonContainer.style.visibility = 'hidden';

            html2canvas(container, {
                scale: 2,
                useCORS: true, // Allow cross-origin images
                allowTaint: true // Allow local images
            }).then(canvas => {
                const imgData = canvas.toDataURL('image/png');
                const imgWidth = 210; // A4 width in mm
                const pageHeight = 297; // A4 height in mm
                const imgHeight = (canvas.height * imgWidth) / canvas.width;

                let heightLeft = imgHeight;
                let position = 0;

                // Add the first page
                doc.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
                heightLeft -= pageHeight;

                while (heightLeft > 0) {
                    position -= pageHeight;
                    doc.addPage();
                    doc.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
                    heightLeft -= pageHeight;
                }

                // Restore buttons after capturing
                buttonContainer.style.visibility = 'visible';

                // Save PDF
                doc.save('Brochure.pdf');
            }).catch(error => {
                console.error("PDF generation error:", error);
            });
        });
    </script>



</body>

</html>