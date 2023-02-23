$("document").ready(function(){
    $("#cluedo").click(function(){
        $("#juegoModal").removeClass().addClass("modal-open");
    })

    $("#close-cluedo").click(function(){
        $("#juegoModal").removeClass().addClass("modal");
    })
})