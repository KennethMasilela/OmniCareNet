// theme.js

// Function to apply the theme
function applyTheme(theme) {
    document.body.classList.toggle("dark", theme === "dark");
  
    // Update toggle icon if it exists
    const toggleBtn = document.querySelector(".theme-toggle");
    if (toggleBtn) {
      toggleBtn.textContent = theme === "dark" ? "☀️" : "🌙";
    }
  }
  
  // Detect system theme
  function detectSystemTheme() {
    return window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
  }
  
  // On page load
  document.addEventListener("DOMContentLoaded", () => {
    const savedTheme = localStorage.getItem("theme") || detectSystemTheme();
    applyTheme(savedTheme);
  
    // Add toggle logic if button exists
    const toggleBtn = document.querySelector(".theme-toggle");
    if (toggleBtn) {
      toggleBtn.addEventListener("click", () => {
        const isDark = document.body.classList.toggle("dark");
        const newTheme = isDark ? "dark" : "light";
        localStorage.setItem("theme", newTheme);
        toggleBtn.textContent = isDark ? "☀️" : "🌙";
      });
    }
  });
  