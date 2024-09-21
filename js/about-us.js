let tel1 = document.querySelector("#tel1");
let tel2 = document.querySelector("#tel2");

if (tel2.value.length === 0) {
    document.querySelector(".tel2").classList.remove("hide")
} else {
    document.querySelector(".tel2").classList.add("hide")
}

if (tel1.value.length === 0) {
    document.querySelector(".tel1").classList.remove("hide")
} else {
    document.querySelector(".tel1").classList.add("hide")
}


tel1.addEventListener("input", () => {

   
    let text = tel1.value

    console.log(tel1.value.lastIndexOf(" "))

    if (tel1.value.length === 0) {
        document.querySelector(".tel1").classList.remove("hide")
    } else {
        document.querySelector(".tel1").classList.add("hide")
    }
    
    if (tel1.value.length === 3 || tel1.value.length === 7 || tel1.value.length === 11) {
        tel1.value = tel1.value + " "
    } else if (text.lastIndexOf(" ") != -1){
        let text3 = text.trimEnd()
        tel1.value = text3
    } 

    if (tel1.value.length > 15) {
        let max_tel_nr = tel1.value.slice(0, -1)
        tel1.value = max_tel_nr
    }

    
})

tel2.addEventListener("input", () => {

   
    let text = tel2.value

    console.log(tel2.value.lastIndexOf(" "))

    if (tel2.value.length === 0) {
        document.querySelector(".tel2").classList.remove("hide")
    } else {
        document.querySelector(".tel2").classList.add("hide")
    }
    
    if (tel2.value.length === 3 || tel2.value.length === 7 || tel2.value.length === 11) {
        tel2.value = tel2.value + " "
    } else if (text.lastIndexOf(" ") != -1){
        let text3 = text.trimEnd()
        tel2.value = text3
    } 

    if (tel2.value.length > 15) {
        let max_tel_nr = tel2.value.slice(0, -1)
        tel2.value = max_tel_nr
    }

    
})