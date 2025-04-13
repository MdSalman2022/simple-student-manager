document.addEventListener('DOMContentLoaded', function() {
    // Date picker styling for date inputs
    let dateInputs = document.querySelectorAll('input[type="date"]');
    dateInputs.forEach(function(input) {
        input.classList.add('date-input');
    });
    
    // Form validation for add student form
    const addStudentForm = document.getElementById('add-student-form');
    if(addStudentForm) {
        addStudentForm.addEventListener('submit', function(event) {
            const email = document.getElementById('email');
            const studentId = document.getElementById('student_id');
            
            // Simple email validation
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email.value)) {
                alert('Please enter a valid email address');
                event.preventDefault();
                return;
            }
            
            // Student ID validation (allowing hyphens and 5-15 characters)
            const idRegex = /^[A-Za-z0-9-]{5,15}$/;
            if (!idRegex.test(studentId.value)) {
                alert('Student ID should be 5-15 characters (letters, numbers, and hyphens allowed)');
                event.preventDefault();
                return;
            }
        });
    }
    
    // Search functionality for enrollment history
    const searchForm = document.getElementById('search-history-form');
    if(searchForm) {
        searchForm.addEventListener('submit', function(event) {
            const studentId = document.getElementById('search_student_id').value.trim();
            if (!studentId) {
                alert('Please enter a Student ID to search');
                event.preventDefault();
            }
        });
    }
});