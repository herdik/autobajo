$(document).ready(function () {
    $(".delete-label").click(function (e) { 
        // show loader 
        loader[0].style.display = "flex"
        // show loader 
        
        e.preventDefault();

        let formDeleteData

        let deleteData = $(this).parent()[0]
        formDeleteData = new FormData(deleteData)
        formDeleteData.append('submit', "Vymazať")
        

        $.ajax({
            type: "POST",
            url: "delete-tire-advertisement.php",
            data: formDeleteData,
            contentType: false,
            processData: false,
            success: function (res) {
                
                window.location.reload()
                
            }
        }); 

    });
});