const body = document.body;

const applyTheme = () => {
    const userTheme = localStorage.getItem("theme");
    const systemPrefersDark = window.matchMedia("(prefers-color-scheme: dark)").matches;

    if (userTheme) {
        userTheme === "dark" ? body.classList.add("dark") : body.classList.remove("dark");
    } else {
        systemPrefersDark ? body.classList.add("dark") : body.classList.remove("dark");
    }
};

const changeTheme = () => {
    const currentTheme = body.classList.contains("dark") ? "dark" : "light";

    if (currentTheme === "dark") {
        localStorage.setItem("theme", "light");
        body.classList.remove("dark");
    } else {
        localStorage.setItem("theme", "dark");
        body.classList.add("dark");
    }
};

document.addEventListener("DOMContentLoaded", () => {
    applyTheme();

    const themeToggleButton = document.getElementById("theme");
    if (themeToggleButton) {
        themeToggleButton.addEventListener("click", changeTheme, false);
    }
});
