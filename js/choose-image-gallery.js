// main div for all images in image gallery
let allImages = document.querySelectorAll(".div-menu-images")

// button for select just image from image gallery - and active button for add image to title advertisement
let add_btn = document.getElementById("image-name-add")

// button for select multiple images friom image gallery - and active button for delete images from gallery for advertisement
let delete_btn = document.getElementById("image-name-delete")

// representing selected value - from image gallery -> for title image input 
let addImg = document.getElementById("image-id-add")

// confirm button to update title image 
let confirmBtnAdd = document.getElementById("image-submit-add")
// default for confirm button is disabled
confirmBtnAdd.disabled = true

// confirm button to delete image from image gallery
let confirmBtnDel = document.getElementById("image-submit-delete")
// default for confirm button is disabled
confirmBtnDel.disabled = true

let selectedGalImages = []


// on click actived add button and change colot green ("ON") a prepare to select just one image from gallery
add_btn.addEventListener("click", changeColorAdd)

// on click actived delete button and change colot green ("ON") a prepare to select multiple images from gallery
delete_btn.addEventListener("click", changeColorDel)





// ESCAPE button to deactive all buttons (add and delete) and also deactive possibilty select image from image gallery
document.addEventListener("keydown", function(event) {
    const key = event.key
    if (key === "Escape") {

        // deactive color for add button
        add_btn.style.backgroundColor = "#b30606"
        add_btn.style.border = "5px solid #b30606"
        add_btn.style.color = "#fff"

        // deactive color for delete button
        delete_btn.style.backgroundColor = "#b30606"
        delete_btn.style.border = "5px solid #b30606"
        delete_btn.style.color = "#fff"

        // reset selected value for title image which was selected from image gallery
        addImg.value = ""

        // default for confirm button to update title image is disabled
        confirmBtnAdd.disabled = true


        allImages.forEach((oneImage) => {
            
            // deactive eventlistener for select one image from image gallery
            oneImage.removeEventListener("click", selectImage)
            // deactive eventlistener for select multiple images from image gallery
            oneImage.removeEventListener("click", selectImages)
            // reset image to default it means not selected image
            oneImage.style.border = "1px solid #fff"
        
    
        });
        
    }
});


// function for add button to select one image froom image gallery
function changeColorAdd () {
    // change color to active add button
    this.style.backgroundColor = "green"
    this.style.border = "5px solid green"
    this.style.color = "#fff"

    // reset delete button / deactive color to red
    delete_btn.style.backgroundColor = "#b30606"
    delete_btn.style.borderColor = "#b30606"
    delete_btn.style.color = "#fff"

    // main setting for gallery - SELECT ONE IMAGE
    allImages.forEach((oneImage) => {

        // deactived and reset default settings for selected mupltiple imges
        oneImage.removeEventListener("click", selectImages)
        oneImage.style.border = "1px solid #fff"

        // actived to select one image
        oneImage.addEventListener("click", selectImage)
        
        
    });
}

// function for delete button to select multiple images from image gallery
function changeColorDel () {
    // change color to active delete button
    this.style.backgroundColor = "green"
    this.style.borderColor = "green"
    this.style.color = "#fff"

    // reset add button / deactive color to red
    add_btn.style.backgroundColor = "#b30606"
    add_btn.style.borderColor = "#b30606"
    add_btn.style.color = "#fff"

    // reset selected value for title image which was selected from image gallery
    addImg.value = ""

    // default for confirm button to update title image is disabled
    confirmBtnAdd.disabled = true
    
    // main setting for gallery - SELECT MULTIPLE IMAGES
    allImages.forEach((oneImage) => {
        
        // deactived and reset default settings for selected one image
        oneImage.removeEventListener("click", selectImage)
        oneImage.style.border = "1px solid #fff"

        // actived to select mupltiple images
        oneImage.addEventListener("click", selectImages)
    });



}

// function for one image to select just one image if add button is actived
function selectImage () {
    

    allImages.forEach((oneImage) => {
        if (oneImage === this) {
            this.style.border = "5px solid #b30606"

            // add select images (info from nearest input for selected image) to form/input add new title image
            addImg.value = this.closest("div").children[0].value
            console.log(addImg)

            if (addImg.value.length > 0){
                // confirm button to update title image is enabled
                confirmBtnAdd.disabled = false
            }

        } else {
            oneImage.style.border = "1px solid #fff"
        }
    })
    
}

// function for images to select multiple images if delete button is actived
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





