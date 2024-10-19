$(document).ready(function () {
    // **** GET ****
    // ***** part-get for + button  - add new line *****
    $(".add-alu-basic").click({param: "after-alu-price-list-basic-service.php"}, addNewLine);
    $(".add-alu-premium").click({param: "after-alu-price-list-premium-service.php"}, addNewLine);
    $(".add-metal-basic").click({param: "after-metal-price-list-basic-service.php"}, addNewLine);
    $(".add-metal-premium").click({param: "after-metal-price-list-premium-service.php"}, addNewLine);
    $(".add-truck-service").click({param: "after-price-list-truck-service.php"}, addNewLine);
    $(".add-adhesive-weight").click({param: "after-price-list-adhesive-weight.php"}, addNewLine);

    // ***** part-get for + button  - add new line *****
    // **** GET ****

    // **** POST ****
    // ***** part-post for X button and OK button *****
    let aluBasicServChildren = $(".alu-basic-service")
    $.each(aluBasicServChildren, function (index, myForm) { 
        $('input#confirm-btn', myForm).click({param1: myForm, param2: "after-alu-price-list-basic-service.php"}, editService);
        $('input#delete-btn', myForm).click({param1: myForm, param2: "after-alu-price-list-basic-service.php"}, editService);
        // $(myForm).on("submit", function (e) {
        //     e.preventDefault();
        //     // alert(index)
        //     var confBtn = $('input#confirm-btn', this).val();
        //     var delBtn = $('input#delete-btn', this).val();
        //     console.log(confBtn)
        //     console.log(delBtn)
        //  });
    });

    let aluPremiumServChildren = $(".alu-premium-service")
    $.each(aluPremiumServChildren, function (index, myForm) { 
        $('input#confirm-btn', myForm).click({param1: myForm, param2: "after-alu-price-list-premium-service.php"}, editService);
        $('input#delete-btn', myForm).click({param1: myForm, param2: "after-alu-price-list-premium-service.php"}, editService);
    });
    
    let metBasicServChildren = $(".metal-basic-service")
    $.each(metBasicServChildren, function (index, myForm) { 
        $('input#confirm-btn', myForm).click({param1: myForm, param2: "after-metal-price-list-basic-service.php"}, editService);
        $('input#delete-btn', myForm).click({param1: myForm, param2: "after-metal-price-list-basic-service.php"}, editService);
    });

    let metPremiumServChildren = $(".metal-premium-service")
    $.each(metPremiumServChildren, function (index, myForm) { 
        $('input#confirm-btn', myForm).click({param1: myForm, param2: "after-metal-price-list-premium-service.php"}, editService);
        $('input#delete-btn', myForm).click({param1: myForm, param2: "after-metal-price-list-premium-service.php"}, editService);
    });

    let truckServChildren = $(".truck-service")
    $.each(truckServChildren, function (index, myForm) { 
        $('input#confirm-btn', myForm).click({param1: myForm, param2: "after-price-list-truck-service.php"}, editService);
        $('input#delete-btn', myForm).click({param1: myForm, param2: "after-price-list-truck-service.php"}, editService);
    });

    let adhesiveWeightChildren = $(".adhesive-weight")
    $.each(adhesiveWeightChildren, function (index, myForm) { 
        $('input#confirm-btn', myForm).click({param1: myForm, param2: "after-price-list-adhesive-weight.php"}, editService);
        $('input#delete-btn', myForm).click({param1: myForm, param2: "after-price-list-adhesive-weight.php"}, editService);
    });
    // ***** part-post for X button and OK button *****
    // **** POST ****
});




// ***** FUNCTONS ***** 

// ***** function FOR part-get for + button  - add new line *****
function addNewLine (e) { 
    e.preventDefault();
    let redirectUrl = e.data.param

    $.ajax({
        type: "GET",
        url: redirectUrl,
        data: {
            'new_line': true
        },
        
    success: function () {
        window.location.reload()
    }
    });
    
}
// ***** function FOR part-get for + button  - add new line *****



// ***** function FOR part-post for X button and OK button *****
function editService(e) { 
    e.preventDefault();
    let formServiceData
    let btnValue = $(this).val()
    let myForm = e.data.param1
    let myFormUrl = e.data.param2
    formServiceData = new FormData(myForm)
    formServiceData.append('btn', btnValue)
    
    $.ajax({
        type: "POST",
        url: myFormUrl,
        data: formServiceData,
        contentType: false,
        processData: false,

    success: function (response) {
        console.log(response)
        window.location.reload()
    }
    });
    
    
}
// ***** function FOR part-post for X button and OK button *****

// ***** FUNCTONS ***** 