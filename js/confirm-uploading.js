let confBtn = document.querySelector(".confirm-btn input")
let loadering = document.getElementsByClassName("loader")

confBtn.addEventListener('click', () => {
    loadering[0].style.display = "flex"
}) 