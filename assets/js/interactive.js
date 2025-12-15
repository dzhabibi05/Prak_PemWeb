/**
 * Interactive Elements Handler
 * Adds smooth transitions and interactive feedback
 */

document.addEventListener("DOMContentLoaded", function () {
  // Add smooth scroll behavior
  document.documentElement.style.scrollBehavior = "smooth";

  // Add ripple effect to buttons
  const buttons = document.querySelectorAll(
    ".button, .nav-btn, .btn-cancel, .btn-logout, .submit-btn, button"
  );

  buttons.forEach((button) => {
    button.addEventListener("click", function (e) {
      const ripple = document.createElement("span");
      ripple.className = "ripple-effect";

      const rect = this.getBoundingClientRect();
      const size = Math.max(rect.width, rect.height);
      const x = e.clientX - rect.left - size / 2;
      const y = e.clientY - rect.top - size / 2;

      ripple.style.width = ripple.style.height = size + "px";
      ripple.style.left = x + "px";
      ripple.style.top = y + "px";

      this.style.position = "relative";
      this.style.overflow = "hidden";
      this.appendChild(ripple);

      setTimeout(() => ripple.remove(), 600);
    });
  });

  // Add focus effects to input fields
  const inputs = document.querySelectorAll(
    ".input-box, input, select, textarea"
  );

  inputs.forEach((input) => {
    input.addEventListener("focus", function () {
      this.style.transform = "scale(1.02)";
      this.style.transition = "transform 0.2s ease";
    });

    input.addEventListener("blur", function () {
      this.style.transform = "scale(1)";
    });
  });

  // Add hover effect to cards
  const cards = document.querySelectorAll(
    ".card, .history-card, .transaction-card, .form-wrapper, .welcome-wrapper"
  );

  cards.forEach((card) => {
    card.addEventListener("mouseenter", function () {
      this.style.transform = "translateY(-5px)";
      this.style.transition = "transform 0.3s ease, box-shadow 0.3s ease";
      this.style.boxShadow = "0 10px 30px rgba(0, 0, 0, 0.3)";
    });

    card.addEventListener("mouseleave", function () {
      this.style.transform = "translateY(0)";
      this.style.boxShadow = "none";
    });
  });

  // Add loading animation to forms
  const forms = document.querySelectorAll("form");

  forms.forEach((form) => {
    form.addEventListener("submit", function (e) {
      const submitBtn = this.querySelector('button[type="submit"], .button');
      if (submitBtn && !submitBtn.disabled) {
        submitBtn.innerHTML =
          '<span class="loading-spinner"></span> Loading...';
        submitBtn.disabled = true;
        submitBtn.style.opacity = "0.7";
      }
    });
  });

  // Add animation to menu items
  const menuItems = document.querySelectorAll(".menu-item");

  menuItems.forEach((item, index) => {
    item.style.opacity = "0";
    item.style.transform = "translateX(-20px)";

    setTimeout(() => {
      item.style.transition = "opacity 0.5s ease, transform 0.5s ease";
      item.style.opacity = "1";
      item.style.transform = "translateX(0)";
    }, index * 100);
  });

  // Add touch feedback for mobile
  if ("ontouchstart" in window) {
    const touchElements = document.querySelectorAll(
      "a, button, .menu-item, .action-box"
    );

    touchElements.forEach((element) => {
      element.addEventListener("touchstart", function () {
        this.style.opacity = "0.7";
      });

      element.addEventListener("touchend", function () {
        this.style.opacity = "1";
      });
    });
  }

  // Add scroll reveal animation
  const observerOptions = {
    threshold: 0.1,
    rootMargin: "0px 0px -50px 0px",
  };

  const observer = new IntersectionObserver(function (entries) {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.style.opacity = "1";
        entry.target.style.transform = "translateY(0)";
      }
    });
  }, observerOptions);

  // Observe elements with reveal animation
  const revealElements = document.querySelectorAll(
    ".history-card, .action-box"
  );
  revealElements.forEach((element) => {
    element.style.opacity = "0";
    element.style.transform = "translateY(20px)";
    element.style.transition = "opacity 0.6s ease, transform 0.6s ease";
    observer.observe(element);
  });
});

// CSS for ripple effect (inject into head)
const style = document.createElement("style");
style.textContent = `
    .ripple-effect {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.5);
        transform: scale(0);
        animation: ripple-animation 0.6s ease-out;
        pointer-events: none;
    }
    
    @keyframes ripple-animation {
        to {
            transform: scale(2);
            opacity: 0;
        }
    }
    
    .loading-spinner {
        display: inline-block;
        width: 14px;
        height: 14px;
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-top-color: white;
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
        vertical-align: middle;
        margin-right: 5px;
    }
    
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
`;
document.head.appendChild(style);
