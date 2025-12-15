// Simple Animations - No layout changes
document.addEventListener("DOMContentLoaded", function () {
  // Skip on game page
  if (window.location.pathname.includes("game.php")) {
    return;
  }

  // Add animation styles
  const style = document.createElement("style");
  style.textContent = `
    /* Fade in animation */
    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }
    
    /* Slide in from bottom - subtle */
    @keyframes slideUp {
      from { 
        opacity: 0;
        transform: translateY(10px);
      }
      to { 
        opacity: 1;
        transform: translateY(0);
      }
    }
    
    /* Slide in from left - subtle */
    @keyframes slideRight {
      from { 
        opacity: 0;
        transform: translateX(-10px);
      }
      to { 
        opacity: 1;
        transform: translateX(0);
      }
    }

    /* Apply animations */
    body {
      animation: fadeIn 0.3s ease-out;
    }

    .card, .transaction-card, .form-wrapper, .form-card, .logout-box {
      animation: slideUp 0.4s ease-out;
    }

    .sidebar {
      animation: slideRight 0.4s ease-out;
    }

    .menu-item {
      opacity: 0;
      animation: fadeIn 0.3s ease-out forwards;
    }

    .menu-item:nth-child(1) { animation-delay: 0.1s; }
    .menu-item:nth-child(2) { animation-delay: 0.15s; }
    .menu-item:nth-child(3) { animation-delay: 0.2s; }
    .menu-item:nth-child(4) { animation-delay: 0.25s; }
    .menu-item:nth-child(5) { animation-delay: 0.3s; }

    /* Hover effects - no layout change */
    button:not(.ripple-active), .button:not(.ripple-active), a.menu-item {
      transition: opacity 0.2s ease, transform 0.2s ease;
    }

    button:hover, .button:hover {
      opacity: 0.9;
      transform: scale(1.02);
    }

    button:active, .button:active {
      transform: scale(0.98);
    }

    .menu-item:hover {
      opacity: 1;
      transform: translateX(5px);
    }

    .back-btn {
      transition: transform 0.2s ease;
    }

    .back-btn:hover {
      transform: translateX(-5px);
    }

    /* Input focus animation */
    input:focus, select:focus, textarea:focus {
      outline: none;
      box-shadow: 0 0 0 2px rgba(0, 168, 255, 0.3);
      transition: box-shadow 0.2s ease;
    }

    /* Card hover effect */
    .card:hover, .transaction-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    /* Ripple effect */
    .ripple {
      position: absolute;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.5);
      pointer-events: none;
      transform: scale(0);
      animation: ripple 0.5s ease-out;
    }

    @keyframes ripple {
      to {
        transform: scale(4);
        opacity: 0;
      }
    }
  `;
  document.head.appendChild(style);

  // Add ripple effect on button clicks
  document.addEventListener("click", function (e) {
    const button = e.target.closest("button, .button");
    if (!button) return;

    const ripple = document.createElement("span");
    const rect = button.getBoundingClientRect();
    const size = Math.max(rect.width, rect.height);
    const x = e.clientX - rect.left - size / 2;
    const y = e.clientY - rect.top - size / 2;

    ripple.style.width = ripple.style.height = size + "px";
    ripple.style.left = x + "px";
    ripple.style.top = y + "px";
    ripple.classList.add("ripple");

    button.style.position = "relative";
    button.style.overflow = "hidden";
    button.classList.add("ripple-active");
    button.appendChild(ripple);

    setTimeout(() => {
      ripple.remove();
      button.classList.remove("ripple-active");
    }, 500);
  });

  // Smooth scroll for anchor links
  document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener("click", function (e) {
      const href = this.getAttribute("href");
      if (href === "#") return;

      e.preventDefault();
      const target = document.querySelector(href);
      if (target) {
        target.scrollIntoView({
          behavior: "smooth",
          block: "start",
        });
      }
    });
  });
});
