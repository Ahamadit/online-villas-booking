<?php
header("Content-Type: application/json"); // Set JSON header

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Google reCAPTCHA Secret Key
$recaptcha_secret = "6LedO_QqAAAAAICxFjbjwobFOh-I4UqEdItltBmt"; // Replace with your actual secret key





// Database credentials

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "villas";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(["error" => "Database Connection Failed: " . $conn->connect_error]);
    exit;
}

// Get JSON input
$data = json_decode(file_get_contents("php://input"), true);

// Debugging: Print received data
if (!$data) {
    echo json_encode(["error" => "No data received!"]);
    exit;
}

// Validate input
if (empty($data['name']) || empty($data['mobile']) || empty($data['message']) || empty($data['service']) || empty($data['recaptcha'])) {
    echo json_encode(["error" => "All fields are required, including reCAPTCHA!"]);
    exit;
}

// Verify Google reCAPTCHA
$recaptcha_response = $data['recaptcha'];
$verify_url = "https://www.google.com/recaptcha/api/siteverify";
$post_data = http_build_query([
    'secret' => $recaptcha_secret,
    'response' => $recaptcha_response
]);

$options = [
    'http' => [
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => $post_data,
    ]
];

$context  = stream_context_create($options);
$recaptcha_verify = json_decode(file_get_contents($verify_url, false, $context), true);

// Debugging: Print reCAPTCHA response
if (!$recaptcha_verify['success']) {
    echo json_encode(["error" => "reCAPTCHA verification failed!"]);
    exit;
}

// Prepare SQL query to insert data
$stmt = $conn->prepare("INSERT INTO contact (name, mobile, message, service) VALUES (?, ?, ?, ?)");
if (!$stmt) {
    echo json_encode(["error" => "SQL Prepare Error: " . $conn->error]);
    exit;
}

$stmt->bind_param("ssss", $data['name'], $data['mobile'], $data['message'], $data['service']);

// Execute SQL query
if ($stmt->execute()) {
    echo json_encode(["message" => "Data saved successfully!"]);
} else {
    echo json_encode(["error" => "Failed to save data: " . $stmt->error]);
}

// Close connection
$stmt->close();
$conn->close();
?>
