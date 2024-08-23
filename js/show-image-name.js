let message = document.querySelector(".basic-car-info p");
let img_file = document.querySelector("#car-image");


img_file.addEventListener("input", ()=> {
    if (img_file.files.length) {
        message.textContent = "Zvolený obrázok: " + img_file.files[0].name
        message.style.opacity = "1";
    } 
    else {
        message.style.opacity = "0";
    }
})
