// JQUERY to added options (spesific car model) for selected car brand 
$(document).ready(function () {
    $("#car-brand").change(function (e) { 
        e.preventDefault();
        let currentBrand = $(this).val()
        let carModels = $("#car-models")
        let inputModel = $("#car-model")
        inputModel.val("")
    
        $.ajax({
            type: "POST",
            url: "change-model.php",
            data: {
                'select_changed': true,
                'type': "car",
                'car_brand': currentBrand
                
            },

            success: function (response) {
                if (response){
                    carModels.html("")
                    $.each(response, function (Key, value) { 
                        var newOption = $("<option></option>").text(value);
                        carModels.append(newOption);
                    });
                }
            }
        });   

    });
});