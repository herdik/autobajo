const mainImage = document.querySelector(".main-image")
const gallerySlider = document.querySelector(".gallery-slider")
const closeBtn = document.querySelector(".close")

const leftArrow = document.querySelector(".left")
const rightArrow = document.querySelector(".right")

const allSliderImages = document.querySelectorAll(".show-image img")

const firstImage = allSliderImages[0].src

let imgInfo = document.querySelector(".img-info")

let index = 0


mainImage.addEventListener("click", () => {
    imgInfo.textContent = (index + 1) + "/" + allSliderImages.length
    gallerySlider.showModal()
})

closeBtn.addEventListener("click", () => {
    gallerySlider.close()
})

rightArrow.addEventListener("click", () => {
    index += 1 
    if (index == allSliderImages.length){
        index = 0
        allSliderImages[0].src = firstImage
    } else {
        allSliderImages[0].src = allSliderImages[index].src
    }
    imgInfo.textContent = (index + 1) + "/" + allSliderImages.length
})
leftArrow.addEventListener("click", () => {
    index -= 1 
    if (index == 0){ 
        allSliderImages[0].src = firstImage
    } else if (index == -1){
        index = allSliderImages.length - 1
        allSliderImages[0].src = allSliderImages[index].src
    } 
    else {
        allSliderImages[0].src = allSliderImages[index].src
    }
    imgInfo.textContent = (index + 1) + "/" + allSliderImages.length
})

