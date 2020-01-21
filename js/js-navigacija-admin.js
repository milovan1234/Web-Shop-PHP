//Vertikalna i horizontalna navigacija na admin strani
function izmenaPrikaza() {
    if($(window).width() < 992){
        $(".main").removeClass("prikaz-deo");
    }
    else if($(window).width() > 992) {
        $(".main").addClass("prikaz-deo");
    }
}
$(document).ready(function () {
    izmenaPrikaza()
});
$(window).resize(function(){
    izmenaPrikaza()
});