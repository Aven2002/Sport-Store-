
    function validateFullName(fullName) {
        var regex = /^[A-Z||a-z]+\s[A-Z||a-z]+$/;
        return regex.test(fullName);
    }
    function validateEmail(email) {
        var regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(email);
    }
    function validatePassword(password) {
        var regex = /^(?=.*[a-z]||[A-Z])(?=.*[!@#$%^&*]).{8,}$/;
        return regex.test(password);
    }
    function validateContactNumber(contactNum) {
        var regex = /^\d{3}-\d{3}-\d{4}$/;
        return regex.test(contactNum);
    }

    // Validate Submission
    function validateForm() {
    var fullName = document.getElementsByName("fullName")[0].value;
    var email = document.getElementsByName("email")[0].value;
    var password = document.getElementsByName("password")[0].value;
    var contactNum = document.getElementsByName("contactNum")[0].value;

        if (!validateFullName(fullName)) {
            alert("Full name format is invalid. Please enter in the format: Firstname Lastname");
            return false;
        }

        if (!validateEmail(email)) {
            alert("Email format is invalid. Please enter a valid email address.");
            return false;
        }

        if (!validatePassword(password)) {
            alert("Password format is invalid. It must be at least 8 characters long, and at least one special character.");
            return false;
        }

        if (!validateContactNumber(contactNum)) {
            alert("Contact number format is invalid. Please enter in the format: xxx-xxx-xxxx");
            return false;
        }

        return true; 
    }