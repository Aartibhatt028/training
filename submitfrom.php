<?php
// Database connection
$servername = "localhost";
$username = "root"; // Change this to your database username
$password = ""; // Change this to your database password
$dbname = "company_registration"; // Database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$fullName = $_POST['fullName'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$qualification = $_POST['qualification'];

// Handle file upload
$upload_dir = "uploads/";
$file_name = $_FILES['resume']['name'];
$file_tmp = $_FILES['resume']['tmp_name'];
$file_path = $upload_dir . basename($file_name);

// Move the uploaded file to the server
if (move_uploaded_file($file_tmp, $file_path)) {
    echo "File uploaded successfully!";
} else {
    echo "Error uploading file.";
}

// Save form data in the database
$sql = "INSERT INTO registrations (full_name, email, phone, qualification, resume_path) 
        VALUES ('$fullName', '$email', '$phone', '$qualification', '$file_path')";

if ($conn->query($sql) === TRUE) {
    echo "Record saved successfully!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Send email with resume
$to = "lat"; // Change to your email address
$subject = "New Company Registration";
$message = "New registration received from $fullName.\n\nEmail: $email\nPhone: $phone\nQualification: $qualification";
$headers = "From: no-reply@example.com";

// Add resume attachment
$boundary = uniqid("PHP-mixed-");
$headers .= "\r\nMIME-Version: 1.0\r\nContent-Type: multipart/mixed; boundary=\"{$boundary}\"";

$body = "--{$boundary}\r\n";
$body .= "Content-Type: text/plain; charset=UTF-8\r\n\r\n";
$body .= $message . "\r\n\r\n";

$body .= "--{$boundary}\r\n";
$body .= "Content-Type: application/octet-stream; name=\"{$file_name}\"\r\n";
$body .= "Content-Transfer-Encoding: base64\r\n";
$body .= "Content-Disposition: attachment; filename=\"{$file_name}\"\r\n\r\n";
$body .= chunk_split(base64_encode(file_get_contents($file_path))) . "\r\n";
$body .= "--{$boundary}--";

if (mail($to, $subject, $body, $headers)) {
    echo "Registration  successfully!";
} else {
    echo "Failed to send email.";
}

$conn->close();
?>
