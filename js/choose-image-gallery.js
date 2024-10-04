

let allImages = document.querySelectorAll(".div-menu-images")

let add_btn = document.getElementById("image-name-add")
let delete_btn = document.getElementById("image-name-delete")

let addImg = document.getElementById("image-id")

let selectedGalImages = []



add_btn.addEventListener("click", changeColorAdd)

delete_btn.addEventListener("click", changeColorDel)

document.addEventListener("keydown", function(event) {
    const key = event.key; // Or const {key} = event; in ES6+
    if (key === "Escape") {

        add_btn.style.backgroundColor = "#b30606"
        add_btn.style.border = "5px solid #b30606"
        add_btn.style.color = "#fff"

        delete_btn.style.backgroundColor = "#b30606"
        delete_btn.style.border = "5px solid #b30606"
        delete_btn.style.color = "#fff"

        allImages.forEach((oneImage) => {
            
            oneImage.removeEventListener("click", selectImage)
            oneImage.removeEventListener("click", selectImages)
            oneImage.style.border = "1px solid #fff"
        
    
        });
        
    }
});


function changeColorAdd () {
    this.style.backgroundColor = "green"
    this.style.border = "5px solid green"
    this.style.color = "#fff"

    delete_btn.style.backgroundColor = "#b30606"
    delete_btn.style.borderColor = "#b30606"
    delete_btn.style.color = "#fff"

    allImages.forEach((oneImage) => {
        
        oneImage.removeEventListener("click", selectImages)
        oneImage.style.border = "1px solid #fff"
        oneImage.addEventListener("click", selectImage)
        
        
    });
}

function changeColorDel () {
    this.style.backgroundColor = "green"
    this.style.borderColor = "green"
    this.style.color = "#fff"

    add_btn.style.backgroundColor = "#b30606"
    add_btn.style.borderColor = "#b30606"
    add_btn.style.color = "#fff"

    allImages.forEach((oneImage) => {
    
        oneImage.removeEventListener("click", selectImage)
        oneImage.style.border = "1px solid #fff"
        oneImage.addEventListener("click", selectImages)
    });



}


function selectImage () {
    // this.style.border = "5px solid #b30606"

    allImages.forEach((oneImage) => {
        if (oneImage === this) {
            this.style.border = "5px solid #b30606"

            // add select images to form add new title img
            addImg.value = this.closest("div").children[0].value
            console.log(addImg)
            

        } else {
            oneImage.style.border = "1px solid #fff"
        }
    })
    
}

function selectImages () {
    this.style.border = "5px solid #b30606"
}

// $(document).ready(function () {
//     $('#image-submit').click(function (e) { 
//         e.preventDefault();
        
//         if (add_btn.style.backgroundColor){
//             makesomething
//         }
//     });
// });





