// JQUERY to added options (spesific car model) for selected car brand 
$(document).ready(function () {
    $("#wheels-brand").change(function (e) { 
        e.preventDefault();
        let currentBrand = $(this).val()
        let wheelModels = $("#wheels-model")
        let inputModel = $("#model-wheels")
        inputModel.val("")
        
    
        $.ajax({
            type: "POST",
            url: "change-model.php",
            data: {
                'select_changed': true,
                'type': "wheel",
                'wheel_brand': currentBrand
                
            },

            success: function (response) {

                if (response){
                    wheelModels.html("")
                    $.each(response, function (Key, value) { 
                        var newOption = $("<option></option>").text(value);
                        wheelModels.append(newOption);
                    });
                }
            }
        });   

    });
});