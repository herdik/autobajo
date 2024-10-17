let confirmWindow = document.querySelector("#confirm-window")
$(document).ready(function () {
    $("#btn-contact").click(function (e) { 
        e.preventDefault();
        let contactInfos = $("#main-contact-form")[0]
        let formData = new FormData(contactInfos)
        formData.append('submit', "Potvrdiť")
        $.ajax({
            type: "POST",
            url: "after-reg-main-contact.php",
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response){
                    confirmWindow.showModal()
                }
                    
                
                setTimeout(closeConfirmModal, 1000)
                
                
            }
        });   

    });
});

function closeConfirmModal() {
    confirmWindow.close()
}



