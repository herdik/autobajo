let allSliders = document.querySelectorAll(".slide")

let mainSlider = document.querySelector(".slider")

if (allSliders.length < 3 ){
    mainSlider.classList.add("hide-slider")
} 


allSliders.forEach((slide, index) => {
    
    let delay = 30 / allSliders.length * (allSliders.length - index + 1) * (-1)
    
    slide.style.animationDelay = `${delay}s`
    slide.style.right = `max(calc(200px * ${allSliders.length}), 100%)`
});

mainSlider.addEventListener("mouseenter", () => {
    allSliders.forEach((slide) => {
        
        slide.style.animationPlayState = "paused"
    });
})
mainSlider.addEventListener("mouseleave", () => {
    allSliders.forEach((slide) => {
        
        slide.style.animationPlayState = "running"
    });
})


