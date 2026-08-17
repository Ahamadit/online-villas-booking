<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include Database Configuration
require_once 'admin/layouts/config.php';

function sanitize_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $number_of_guests = isset($_POST['guests']) ? intval($_POST['guests']) : 0;
    $villa_name = isset($_POST['select_villa']) ? sanitize_input($_POST['select_villa']) : '';
    $room_type = isset($_POST['villas']) ? sanitize_input($_POST['villas']) : '';
    $check_in_date = isset($_POST['checkin']) ? sanitize_input($_POST['checkin']) : '';
    $check_out_date = isset($_POST['checkout']) ? sanitize_input($_POST['checkout']) : '';
    $guest_name = isset($_POST['name']) ? sanitize_input($_POST['name']) : '';
    $email = isset($_POST['email']) ? sanitize_input($_POST['email']) : '';
    $contact = isset($_POST['contact']) ? sanitize_input($_POST['contact']) : '';
    $services = isset($_POST['services']) ? implode(", ", $_POST['services']) : 'None';

    // Logging to check if the script is executed
    file_put_contents("log.txt", "Script started\n", FILE_APPEND);

    // reCAPTCHA Validation (Try disabling if it causes issues)
    $recaptcha_secret = "6LedO_QqAAAAAICxFjbjwobFOh-I4UqEdItltBmt"; // Replace with your Secret Key
    $recaptcha_response = $_POST['g-recaptcha-response'] ?? '';

    if (empty($recaptcha_response)) {
        file_put_contents("log.txt", "reCAPTCHA empty\n", FILE_APPEND);
        echo "<script>alert('Please complete the reCAPTCHA'); window.history.back();</script>";
        exit();
    }

    $verify_url = "https://www.google.com/recaptcha/api/siteverify?secret=$recaptcha_secret&response=$recaptcha_response";
    $recaptcha_verify = json_decode(file_get_contents($verify_url), true);

    if (!$recaptcha_verify['success']) {
        file_put_contents("log.txt", "reCAPTCHA failed\n", FILE_APPEND);
        echo "<script>alert('reCAPTCHA verification failed!'); window.history.back();</script>";
        exit();
    }

    // ✅ Validation
    $errors = [];
    if ($number_of_guests < 1) $errors[] = "Number of guests must be at least 1.";
    if (empty($villa_name) || empty($room_type) || empty($check_in_date) || empty($check_out_date) || empty($guest_name) || empty($email) || empty($contact)) 
        $errors[] = "All fields are required except services.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid email format.";
    if (!preg_match("/^[0-9]{10}$/", $contact)) $errors[] = "Invalid contact number.";
    if (strtotime($check_out_date) <= strtotime($check_in_date)) 
        $errors[] = "Check-out date must be after check-in date.";

    if (!empty($errors)) {
        $error_message = implode("\\n", $errors);
        file_put_contents("log.txt", "Validation errors: $error_message\n", FILE_APPEND);
        echo "<script>alert('$error_message'); window.history.back();</script>";
        exit();
    }

    // ✅ Insert into Database
    $stmt = $link->prepare("INSERT INTO reservations (number_of_guests, villas, room_type, checkin, checkout, name, email, contact, services) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

    if ($stmt) {
        $stmt->bind_param("issssssss", $number_of_guests, $villa_name, $room_type, $check_in_date, $check_out_date, $guest_name, $email, $contact, $services);

        if ($stmt->execute()) {
            file_put_contents("log.txt", "Database insert success\n", FILE_APPEND);
            
            $message = "Hello, My Name Is $guest_name. I Want To Book $villa_name ($room_type) From $check_in_date To $check_out_date For $number_of_guests Guests. Services: $services.";
            $message_encoded = urlencode($message);
            $whatsapp_url = "https://api.whatsapp.com/send?phone=9721905478&text=$message_encoded";

            // ✅ Redirect to WhatsApp (Using JavaScript for better compatibility)
            echo "<script>window.location.href='$whatsapp_url';</script>";
            exit();
        } else {
            file_put_contents("log.txt", "Database error: " . $stmt->error . "\n", FILE_APPEND);
            echo "<script>alert('Database error: " . $stmt->error . "'); window.history.back();</script>";
        }
        $stmt->close();
    } else {
        file_put_contents("log.txt", "Database connection error: " . $link->error . "\n", FILE_APPEND);
        echo "<script>alert('Database connection error: " . $link->error . "'); window.history.back();</script>";
    }
    $link->close();
} else {
    header("Location: index.php");
    exit();
}
?>
