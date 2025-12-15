/**
 * Responsive Menu Handler
 * Handles mobile menu interactions and responsive behaviors
 */

// Add mobile menu toggle functionality for sidebar
document.addEventListener("DOMContentLoaded", function () {
  // Create mobile menu toggle button for home page
  const sidebar = document.querySelector(".sidebar");

  if (sidebar && window.innerWidth <= 768) {
    // Create toggle button
    const toggleBtn = document.createElement("button");
    toggleBtn.className = "mobile-menu-toggle";
    toggleBtn.innerHTML = "☰";
    toggleBtn.setAttribute("aria-label", "Toggle Menu");

    // Insert toggle button before sidebar
    sidebar.parentNode.insertBefore(toggleBtn, sidebar);

    // Add click handler
    toggleBtn.addEventListener("click", function () {
      sidebar.classList.toggle("active");
      toggleBtn.classList.toggle("active");
    });

    // Close menu when clicking outside
    document.addEventListener("click", function (e) {
      if (!sidebar.contains(e.target) && !toggleBtn.contains(e.target)) {
        sidebar.classList.remove("active");
        toggleBtn.classList.remove("active");
      }
    });
  }
});

// Handle window resize
let resizeTimer;
window.addEventListener("resize", function () {
  clearTimeout(resizeTimer);
  resizeTimer = setTimeout(function () {
    // Reload functionality if needed for responsive adjustments
    const sidebar = document.querySelector(".sidebar");
    if (sidebar && window.innerWidth > 768) {
      sidebar.classList.remove("active");
    }
  }, 250);
});
