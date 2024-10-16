// JQUERY to added options (spesific car model) for selected car brand 
$(document).ready(function () {
    $("#tire-brand").change(function (e) { 
        e.preventDefault();
        let currentBrand = $(this).val()
        let tireModels = $("#tires-model")
        let inputModel = $("#model-tires")
        inputModel.val("")
        
    
        $.ajax({
            type: "POST",
            url: "change-model.php",
            data: {
                'select_changed': true,
                'type': "tire",
                'tire_brand': currentBrand
                
            },

            success: function (response) {

                if (response){
                    tireModels.html("")
                    $.each(response, function (Key, value) { 
                        var newOption = $("<option></option>").text(value);
                        tireModels.append(newOption);
                    });
                }
            }
        });   

    });
});