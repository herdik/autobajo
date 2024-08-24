let allInputs = document.querySelectorAll('input[type="text"]');
let alltextarea = document.querySelectorAll('textarea');

allInputs.forEach(oneInput => {
    oneInput.addEventListener('input', ()=> {

        if ((oneInput.value).length > 0){
            oneInput.value = (oneInput.value[0].toUpperCase() +
            oneInput.value.slice(1));
        }
        
    });
    
});

alltextarea.forEach(oneTextarea => {
    oneTextarea.addEventListener('input', ()=> {

        if ((oneTextarea.value).length > 0){
            oneTextarea.value = (oneTextarea.value[0].toUpperCase() +
            oneTextarea.value.slice(1));
        }
        
    });
    
});