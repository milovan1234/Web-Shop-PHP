$(document).ready(function () {
    let urladresa = "svi-korisnici.php?broj-strane=1";
    $("#sort").change(function() {
        let sortArtikla = $(this);
        urladresa = "svi-korisnici.php?broj-strane=1";
        if ($(sortArtikla).val() != "") {
            urladresa += "&sort=" + $(sortArtikla).val();
        }
        if ($("#pretraga").val() != "") {
            urladresa += "&pretraga=" + $("#pretraga").val();
        }
        window.location.href = urladresa;
    });
    
    $("#btn-pretraga").click(function(){
        let pretraga = $(this);
        urladresa = "svi-korisnici.php?broj-strane=1";
        if ($("#sort").val() != "") {
            urladresa += "&sort=" + $("#sort").val();
        }
        if ($("#pretraga").val() != "") {
            urladresa += "&pretraga=" + $("#pretraga").val();
        }
        window.location.href = urladresa;
    });

    $(".btn-page").click(function() {
        let button = $(this);
        let urladresa ="svi-korisnici.php?broj-strane=" + button.attr("btn-id");
        if ($("#sort").val() != "") {
            urladresa += "&sort=" + $("#sort").val();
        }
        if ($("#pretraga").val() != "") {
            urladresa += "&pretraga=" + $("#pretraga").val();
        }
        window.location.href = urladresa;
    });


    let allItems = $(".btn-page");
    function setActiveButton(index) {
        for (let i = 0; i < allItems.length; i++) {
            $(allItems[i]).removeClass("btn-info");
            $(allItems[index]).addClass("btn-info");
        }
    }

    let numOfPage = parseInt($("#broj-strane-skriveno").val());
    setActiveButton(numOfPage - 1);


    $(".btn-page-prev").click(function() {
        let index = null;
        for (let i = 0; i < allItems.length; i++) {
            let clas = $(allItems[i]).attr("class");
            if (clas.includes("btn-info")) {
                index = i;
                break;
            }
        }
        if (index > 0) {
            urladresa ="svi-korisnici.php?broj-strane=" + (numOfPage - 1);
            if ($("#sort").val() != "") {
                urladresa += "&sort=" + $("#sort").val();
            }
            if ($("#pretraga").val() != "") {
                urladresa += "&pretraga=" + $("#pretraga").val();
            }
            window.location.href = urladresa;
        }
    });
    
    $(".btn-page-next").click(function() {
        let index = null;
        for (let i = 0; i < allItems.length; i++) {
            let clas = $(allItems[i]).attr("class");
            if (clas.includes("btn-info")) {
                index = i;
                break;
            }
        }
        if (index < allItems.length - 1) {
            urladresa = "svi-korisnici.php?broj-strane=" + (numOfPage + 1);
            if ($("#sort").val() != "") {
                urladresa += "&sort=" + $("#sort").val();
            }
            if ($("#pretraga").val() != "") {
                urladresa += "&pretraga=" + $("#pretraga").val();
            }
            window.location.href = urladresa;
        }
    });   

});
function brisanjeKorisnika(obj){
    if(confirm("Da li ste sigurni da želite da obiršete korisnika?")){
        $.ajax({
            type: "GET",
            url: "brisanje-korisnika.php?id-korisnika=" + $(obj).attr("data-id"),
            success: function (response) {
                $(obj).parent().parent().parent().parent().parent().remove();
            }
        });
    }
}