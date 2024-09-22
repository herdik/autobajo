let message = document.querySelector(".images p");
let img_file = document.querySelector("#car-image");


img_file.addEventListener("input", ()=> {
    if (img_file.files.length) {
        if(img_file.files.length > 1){
            message.textContent = "Počet zvolených obrázkov: " + img_file.files.length
            message.style.opacity = "1";
        } else {
            message.textContent = "Zvolený obrázok: " + img_file.files[0].name
            message.style.opacity = "1";
        }
        
    } 
    else {
        message.style.opacity = "0";
    }
})
