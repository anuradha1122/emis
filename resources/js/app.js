// import "./bootstrap";
// import { createIcons, icons } from "lucide";
// import Chart from "chart.js/auto";

// window.Chart = Chart; // Make it available globally
// // initialize icons first time
// createIcons({ icons });

// // Listen for theme changes
// document.addEventListener("livewire:init", () => {
//     Livewire.on("themeChanged", ({ darkMode }) => {
//         document.documentElement.classList.toggle("dark", darkMode);
//         localStorage.setItem("darkMode", darkMode);
//     });
// });

// app.js
import "./bootstrap"; // your bootstrap/alpine imports
import { createIcons, icons } from "lucide";
import Chart from "chart.js/auto";

// Make Chart globally available
window.Chart = Chart;

// -----------------------------
// Lucide icons helper
// -----------------------------
function renderIcons() {
    createIcons({ icons });
}

// Initial icon rendering
renderIcons();

// -----------------------------
// Livewire integration
// -----------------------------
document.addEventListener("livewire:load", () => {
    // Theme toggle listener
    Livewire.on("themeChanged", ({ darkMode }) => {
        document.documentElement.classList.toggle("dark", darkMode);
        localStorage.setItem("darkMode", darkMode);
    });

    // Re-render icons and initialize charts after Livewire updates
    Livewire.hook("message.processed", (message, component) => {
        // Re-render Lucide icons for dynamically added HTML
        renderIcons();

        // Initialize Chart.js for any canvas with class 'chart-js'
        document.querySelectorAll(".chart-js").forEach((canvas) => {
            if (!canvas.dataset.rendered) {
                const config = canvas.dataset.config ? JSON.parse(canvas.dataset.config) : null;
                if (config) {
                    new Chart(canvas, config);
                    canvas.dataset.rendered = "true"; // prevent double initialization
                }
            }
        });
    });
});

// -----------------------------
// Optional: Chart helper
// -----------------------------
// Usage in Blade:
// <canvas class="chart-js" data-config='{"type":"bar","data":{...},"options":{...}}'></canvas>
