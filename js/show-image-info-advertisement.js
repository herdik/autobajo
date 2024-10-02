let message_gallery = document.querySelector(".gallery p");
let imgFilesGallery = document.querySelector("#image-name-gallery");

let sentButtonGallery = document.querySelector("#btn-gall");
sentButtonGallery.disabled = true;

imgFilesGallery.addEventListener("input", ()=> {
    if (imgFilesGallery.files.length) {
        if(imgFilesGallery.files.length > 1){
            message_gallery.textContent = "Počet zvolených obrázkov: " + imgFilesGallery.files.length
            message_gallery.style.opacity = "1";
            sentButtonGallery.disabled = false;
        } else {
            message_gallery.textContent = "Zvolený obrázok: " + imgFilesGallery.files[0].name
            message_gallery.style.opacity = "1";
            sentButtonGallery.disabled = false;
        }
        
    } 
    else {
        message_gallery.style.opacity = "0";
    }
})


let message_title = document.querySelector(".title p");
let imgFilesTitle = document.querySelector("#image-name-title");

let sentButtonTitle = document.querySelector("#btn-title");
sentButtonTitle.disabled = true;

imgFilesTitle.addEventListener("input", ()=> {
    if (imgFilesTitle.files.length) {
        if(imgFilesTitle.files.length > 1){
            message_title.textContent = "Počet zvolených obrázkov: " + imgFilesTitle.files.length
            message_title.style.opacity = "1";
            sentButtonTitle.disabled = false;
        } else {
            message_title.textContent = "Zvolený obrázok: " + imgFilesTitle.files[0].name
            message_title.style.opacity = "1";
            sentButtonTitle.disabled = false;
        }
        
    } 
    else {
        message_title.style.opacity = "0";
    }
})


