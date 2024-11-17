$(document).ready(function () {
    $("#btn-reserved").click({param: "reserved"}, runEvent);
    $("#btn-sold").click({param: "sold"}, runEvent);
})


function runEvent(event) {
    event.preventDefault();
        let action = event.data.param
        let status = false
        let valBtn = $(this).text()
        
        if (valBtn === "Rezervované" || valBtn === "Predané"){
            status = true
        } 
        let currentId = $("#current-id").val()
        
        $.ajax({
            type: "POST",
            url: "after-update-tire-advert.php",
            data: {
                'action': action,
                'status': status,
                'tire_id': currentId
                
            },

            success: function () {
                // window.location.reload()
                window.location.reload(history.back())
            }
        }); 
}