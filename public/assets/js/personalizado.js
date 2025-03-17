document.addEventListener("DOMContentLoaded", function () {
    const htmlElement = document.documentElement;
    const darkModeToggle = document.querySelector(".light-dark-mode");

    // Comprobar si hay una configuración guardada
    if (localStorage.getItem("darkMode") === "enabled") {
        htmlElement.setAttribute("data-layout-mode", "dark");
    } else {
        htmlElement.setAttribute("data-layout-mode", "light");
    }

    // Evento para cambiar el modo oscuro
    darkModeToggle.addEventListener("click", function () {
        if (htmlElement.getAttribute("data-layout-mode") === "dark") {
            htmlElement.setAttribute("data-layout-mode", "light");
            localStorage.setItem("darkMode", "disabled");
        } else {
            htmlElement.setAttribute("data-layout-mode", "dark");
            localStorage.setItem("darkMode", "enabled");
        }
    });
});
