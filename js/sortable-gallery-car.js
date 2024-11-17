let confirmWindow = document.querySelector("#confirm-window")

$(document).ready(function () {

    $("#image-submit-sortable").click(function (e) { 
        e.preventDefault();

        
        let sortableData = new FormData()
        
        if ($("#image-name-sortable").css("background-color") === "rgb(0, 128, 0)") {

            // main div for all images in image gallery
            let allImages = $(".div-menu-images")
            
            $.each(allImages, function (index, element) { 
                // console.log(index)
                let imageID = element.children[0].value
                sortableData.append(index, imageID)
            });

        }

        $.ajax({
            type: "POST",
            url: "change-priority-img-car.php",
            data: sortableData,
            contentType: false,
            processData: false,
            success: function (res) {
                if (res){
                    confirmWindow.showModal()
                    window.location.reload(history.back())
                }
                    
                
                setTimeout(closeConfirmModal, 1000)
                $("#image-name-sortable").css({
                    "background-color" : "#b30606",
                    "border-color" : "#b30606"
                    });
                
                $( "#sortable" ).sortable( "disable" )

            }
        }); 

    });


    $("#image-name-sortable").click(function (e) { 
        e.preventDefault();
        $(this).css({
            "background-color" : "green",
            "border-color" : "green"
            });

        // $(".images-part").attr("id", "sortable")
        $( "#sortable" ).sortable();

        $(document).on('keydown', function(event) {
            if (event.key == "Escape") {
                $("#image-name-sortable").css({
                    "background-color" : "#b30606",
                    "border-color" : "#b30606"
                    });
                // $(".images-part").removeAttr('id');
                $( "#sortable" ).sortable( "disable" )
            }
        });


    });
});

function closeConfirmModal() {
    confirmWindow.close()
}