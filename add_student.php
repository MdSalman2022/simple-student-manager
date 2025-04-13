<?php include 'includes/header.php'; ?>

<h2 class="page-title">Register New Student</h2>

<?php
// Check if the form was submitted and display message
if (isset($_GET['status']) && $_GET['status'] == 'success') {
    echo '<div class="alert alert-success">Student registered successfully!</div>';
}
?>

<form action="process_add_student.php" method="post" id="add-student-form">
    <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
    </div>
    
    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
    </div>
    
    <div class="form-group">
        <label for="student_id">Student ID:</label>
        <input type="text" id="student_id" name="student_id" required>
    </div>
    
    <div class="form-group">
        <label for="department">Department:</label>
        <select id="department" name="department" required>
            <option value="">Select Department</option>
            <option value="CSE">CSE</option>
            <option value="EEE">EEE</option>
        </select>
    </div>
    
    <div class="form-group">
        <label for="major">Major:</label>
        <input type="text" id="major" name="major" required>
    </div>
    
    <div class="form-group">
        <label for="dob">Date of Birth:</label>
        <input type="date" id="dob" name="dob" required>
    </div>
    
    <div class="form-group">
        <label for="address">Address:</label>
        <textarea id="address" name="address" required></textarea>
    </div>
    
    <button type="submit">Register Student</button>
</form>

