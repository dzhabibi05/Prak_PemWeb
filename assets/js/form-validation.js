/**
 * Form Validation Handler
 * Provides real-time form validation and user feedback
 */

document.addEventListener("DOMContentLoaded", function () {
  // Validate input fields on blur
  const inputs = document.querySelectorAll(
    'input[type="text"], input[type="email"], input[type="password"], input[type="number"]'
  );

  inputs.forEach((input) => {
    input.addEventListener("blur", function () {
      validateInput(this);
    });

    input.addEventListener("input", function () {
      // Remove error state while typing
      this.classList.remove("error");
      const errorMsg = this.nextElementSibling;
      if (errorMsg && errorMsg.classList.contains("error-message")) {
        errorMsg.remove();
      }
    });
  });

  function validateInput(input) {
    const value = input.value.trim();
    let isValid = true;
    let errorMessage = "";

    // Check if field is required
    if (input.hasAttribute("required") && value === "") {
      isValid = false;
      errorMessage = "This field is required";
    }

    // Email validation
    if (input.type === "email" && value !== "") {
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailRegex.test(value)) {
        isValid = false;
        errorMessage = "Please enter a valid email address";
      }
    }

    // Password validation
    if (input.type === "password" && value !== "" && value.length < 6) {
      isValid = false;
      errorMessage = "Password must be at least 6 characters";
    }

    // Number validation
    if (input.type === "number" && value !== "") {
      if (isNaN(value) || value < 0) {
        isValid = false;
        errorMessage = "Please enter a valid number";
      }
    }

    // Display error or success
    if (!isValid) {
      showError(input, errorMessage);
    } else if (value !== "") {
      showSuccess(input);
    }
  }

  function showError(input, message) {
    input.classList.add("error");
    input.classList.remove("success");

    // Remove existing error message
    const existingError = input.nextElementSibling;
    if (existingError && existingError.classList.contains("error-message")) {
      existingError.remove();
    }

    // Add new error message
    const errorDiv = document.createElement("div");
    errorDiv.className = "error-message";
    errorDiv.textContent = message;
    input.parentNode.insertBefore(errorDiv, input.nextSibling);
  }

  function showSuccess(input) {
    input.classList.remove("error");
    input.classList.add("success");

    // Remove error message if exists
    const errorMsg = input.nextElementSibling;
    if (errorMsg && errorMsg.classList.contains("error-message")) {
      errorMsg.remove();
    }
  }

  // Form submission validation
  const forms = document.querySelectorAll("form");

  forms.forEach((form) => {
    form.addEventListener("submit", function (e) {
      let isFormValid = true;
      const formInputs = this.querySelectorAll(
        'input[type="text"], input[type="email"], input[type="password"], input[type="number"]'
      );

      formInputs.forEach((input) => {
        validateInput(input);
        if (input.classList.contains("error")) {
          isFormValid = false;
        }
      });

      if (!isFormValid) {
        e.preventDefault();

        // Scroll to first error
        const firstError = this.querySelector(".error");
        if (firstError) {
          firstError.scrollIntoView({ behavior: "smooth", block: "center" });
          firstError.focus();
        }

        // Show notification
        showNotification("Please fix the errors before submitting", "error");
      }
    });
  });

  // Show notification function
  function showNotification(message, type = "info") {
    const notification = document.createElement("div");
    notification.className = `notification notification-${type}`;
    notification.textContent = message;

    document.body.appendChild(notification);

    setTimeout(() => {
      notification.classList.add("show");
    }, 10);

    setTimeout(() => {
      notification.classList.remove("show");
      setTimeout(() => notification.remove(), 300);
    }, 3000);
  }
});

// Add validation styles
const validationStyle = document.createElement("style");
validationStyle.textContent = `
    input.error {
        border: 2px solid #e74c3c !important;
        animation: shake 0.3s ease;
    }
    
    input.success {
        border: 2px solid #2ecc71 !important;
    }
    
    .error-message {
        color: #e74c3c;
        font-size: 12px;
        margin-top: 5px;
        margin-bottom: 10px;
        display: block;
    }
    
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }
    
    .notification {
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px 20px;
        border-radius: 8px;
        color: white;
        font-weight: 500;
        opacity: 0;
        transform: translateY(-20px);
        transition: all 0.3s ease;
        z-index: 10000;
        max-width: 300px;
    }
    
    .notification.show {
        opacity: 1;
        transform: translateY(0);
    }
    
    .notification-error {
        background: #e74c3c;
    }
    
    .notification-success {
        background: #2ecc71;
    }
    
    .notification-info {
        background: #3498db;
    }
    
    @media (max-width: 576px) {
        .notification {
            top: 10px;
            right: 10px;
            left: 10px;
            max-width: none;
        }
    }
`;
document.head.appendChild(validationStyle);
