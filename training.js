// Handling form submission and showing success message
document.getElementById("registrationForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevents the form from submitting the default way

    // Grab all form values
    const fullName = document.getElementById("fullName").value;
    const email = document.getElementById("email").value;
    const phone = document.getElementById("phone").value;
    const qualification = document.getElementById("qualification").value;
    const gisExperience = document.getElementById("gisExperience").value;
    const reason = document.getElementById("reason").value;
    const referral = document.getElementById("referral").value;
    const jobAssistance = document.getElementById("jobAssistance").value;

    // Validation (if needed)
    if (!fullName || !email || !phone || !reason) {
        alert("Please fill out all required fields.");
        return;
    }

    // Display success message
    document.getElementById("successMessage").style.display = "block";
    
    // Optionally, you can hide the form after submission
    document.getElementById("registrationForm").reset();
});

