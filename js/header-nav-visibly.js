document.addEventListener("scroll", (e) => {
    if (window.scrollY > 30) {
        
        document.querySelector("header").style.backgroundColor = "#000"
        document.querySelector("header").style.zIndex = "100"
    
    } else {
        document.querySelector("header").style.backgroundColor = "transparent"
        document.querySelector("header").style.zIndex = "100"
        
    }
    })