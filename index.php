<?php include 'includes/header.php'; ?>


<?php
// Check if the form was submitted and display message
if (isset($_GET['status']) && $_GET['status'] == 'success') {
    echo '<div class="alert alert-success">Student registered successfully!</div>';
}
?>

<form action="process_add_student.php" method="post" id="add-student-form" class="form-container">
    
<h2 class="page-title">Register New Student</h2>
    <div class="form-group">
        <label for="name">Name <span class="required_class">*</span></label>
        <input type="text" id="name" name="name" placeholder="Enter student name" required>
    </div>
    
    <div class="form-group">
        <label for="email">Email<span class="required_class">*</span></label>
        <input type="email" id="email" name="email" placeholder="Enter email address" required>
    </div>
    
    <div class="form-group">
        <label for="student_id">Student ID<span class="required_class">*</span></label>
        <input type="text" id="student_id" name="student_id" placeholder="Enter student ID" required>
    </div>
    
    <div class="form-group">
        <label for="department">Department<span class="required_class">*</span></label>
        <select id="department" name="department" required onchange="updateMajorOptions()">
            <option value="">Select Department</option>
            <option value="CSE">CSE</option>
            <option value="EEE">EEE</option>
        </select>
    </div>
    
    <div class="form-group">
        <label for="major">Major<span class="required_class">*</span></label>
        <select id="major" name="major" required>
            <option value="">Select Major</option>
        </select>
    </div>
    
    <div class="form-group">
        <label for="dob">Date of Birth<span class="required_class">*</span></label>
        <input type="date" id="dob" name="dob" required>
    </div>
    
    <div class="form-group">
        <label for="address">Address<span class="required_class">*</span></label>
        <textarea id="address" name="address" required></textarea>
    </div>
    
    <button type="submit">Submit</button>
</form>

<script>
    function updateMajorOptions() {
        const department = document.getElementById('department').value;
        const majorSelect = document.getElementById('major');
        
        // Clear existing options
        majorSelect.innerHTML = '';
        
        // Add default option
        const defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.text = 'Select Major';
        majorSelect.appendChild(defaultOption);
        
        // Add options based on department
        if (department === 'CSE') {
            const cseOptions = [
                'AI', 
                'Robotics', 
                'Development', 
                'Data Science', 
                'Cybersecurity',
                'Computer Networks'
            ];
            
            cseOptions.forEach(option => {
                const newOption = document.createElement('option');
                newOption.value = option;
                newOption.text = option;
                majorSelect.appendChild(newOption);
            });
        } else if (department === 'EEE') {
            const eeeOptions = [
                'Power Systems',
                'Telecommunications',
                'Electrical',
                'Electronics',
                'Control Systems',
                'Embedded Systems'
            ];
            
            eeeOptions.forEach(option => {
                const newOption = document.createElement('option');
                newOption.value = option;
                newOption.text = option;
                majorSelect.appendChild(newOption);
            });
        }
    }
     
    document.addEventListener('DOMContentLoaded', function() {
        updateMajorOptions();
    });
</script>

