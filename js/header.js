const menuIcon = document.querySelector(".menu-icon")
const burger = document.querySelector(".material-symbols-outlined")
const navigation = document.querySelector("header nav")
const myBody = document.querySelector("body")


menuIcon.addEventListener('click', () => {
    if (burger.textContent === "menu"){
        burger.textContent = "close"
        myBody.style.overflowY = "hidden"
        navigation.style.display = "block"
    } else {
        burger.textContent = "menu"
        myBody.style.overflowY = "auto"
        navigation.style.display = "none"
    }
})