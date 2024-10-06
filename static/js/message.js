const message = document.getElementById("message");
document.getElementById("remove").addEventListener("click", () => {
    let opacity = 1;

    const fadeOut = setInterval(() => {
        if (opacity <= 0) {
            clearInterval(fadeOut);
            message.remove();
        } else {
            opacity -= 0.05;
            message.style.opacity = opacity;
        }
    }, 10);
});
