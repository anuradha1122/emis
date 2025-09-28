import "./bootstrap";
import { createIcons, icons } from "lucide";
import Chart from "chart.js/auto";

window.Chart = Chart; // Make it available globally
// initialize icons first time
createIcons({ icons });

// Listen for theme changes
document.addEventListener("livewire:init", () => {
    Livewire.on("themeChanged", ({ darkMode }) => {
        document.documentElement.classList.toggle("dark", darkMode);
        localStorage.setItem("darkMode", darkMode);
    });
});