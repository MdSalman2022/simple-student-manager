<?php
require_once 'includes/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = mysqli_real_escape_string(connectDB(), $_POST['name']);
    $email = mysqli_real_escape_string(connectDB(), $_POST['email']);
    $student_id = mysqli_real_escape_string(connectDB(), $_POST['student_id']);
    $department = mysqli_real_escape_string(connectDB(), $_POST['department']);
    $major = mysqli_real_escape_string(connectDB(), $_POST['major']);
    $dob = mysqli_real_escape_string(connectDB(), $_POST['dob']);
    $address = mysqli_real_escape_string(connectDB(), $_POST['address']);
    
    // Connect to database
    $conn = connectDB();
    
    // Check if student_id already exists
    $check_query = "SELECT * FROM students WHERE student_id = '$student_id'";
    $result = mysqli_query($conn, $check_query);
    
    if(mysqli_num_rows($result) > 0) {
        // Student ID already exists
        mysqli_close($conn);
        header("location: index.php?error=duplicate");
        exit();
    }
    
    // Insert into students table
    $sql = "INSERT INTO students (name, email, student_id, department, major, dob, address) 
            VALUES ('$name', '$email', '$student_id', '$department', '$major', '$dob', '$address')";
    
    if(mysqli_query($conn, $sql)){
        mysqli_close($conn);
        header("location: index.php?status=success");
        exit();
    } else {
        echo "ERROR: Could not execute $sql. " . mysqli_error($conn);
    }
    
    // Close connection
    mysqli_close($conn);
} else {
    // Redirect if accessed directly
    header("location: index.php");
    exit();
}
?>