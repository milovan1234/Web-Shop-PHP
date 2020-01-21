
function promenaStanja(obj){
    $.ajax({
        type: "GET",
        url: "promena-stanja-slajda.php?id-slike=" + $(obj).attr("data-id") + "&status=" + $(obj).val(),
        success: function (response) {
            let slajdovi = $(".aktivnost-slike");
            for(let i=0;i<slajdovi.length;i++){
                if($(obj).attr("data-id") == $(slajdovi[i]).attr("data-id")){
                    if($(obj).val() == 0){
                        $(slajdovi[i]).html('<small><i class="fas fa-circle text-danger"></i></small> Neaktivna');
                    }
                    else if($(obj).val() == 1){
                        $(slajdovi[i]).html('<small><i class="fas fa-circle text-success"></i></small> Aktivna');
                    }                    
                }                
            }
            $(obj).val("");
        }
    });
}