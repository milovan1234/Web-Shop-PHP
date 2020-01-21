$(document).ready(function() {
    let urladresa = "bela-tehnika.php?broj-strane=1";

$(".btn-page").click(function() {
    let button = $(this);
    let urladresa ="bela-tehnika.php?broj-strane=" + button.attr("btn-id");
    if ($("#sort-cena").val() != "") {
        urladresa += "&sort-cena=" + $("#sort-cena").val();
    }
    if ($("#sort-vreme").val() != "") {
        urladresa += "&sort-vreme=" + $("#sort-vreme").val();
    }
    if ($("#naziv-artikla").val() != "") {
        urladresa += "&naziv-artikla=" + $("#naziv-artikla").val();
    }
    if ($("#marka-artikla").val() != "") {
        urladresa += "&marka-artikla=" + $("#marka-artikla").val();
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
        urladresa ="bela-tehnika.php?broj-strane=" + (numOfPage - 1);
        if ($("#sort-cena").val() != "") {
            urladresa += "&sort-cena=" + $("#sort-cena").val();
        }
        if ($("#sort-vreme").val() != "") {
            urladresa += "&sort-vreme=" + $("#sort-vreme").val();
        }
        if ($("#naziv-artikla").val() != "") {
            urladresa += "&naziv-artikla=" + $("#naziv-artikla").val();
        }
        if ($("#marka-artikla").val() != "") {
            urladresa += "&marka-artikla=" + $("#marka-artikla").val();
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
        urladresa ="bela-tehnika.php?broj-strane=" + (numOfPage + 1);
        if ($("#sort-cena").val() != "") {
            urladresa += "&sort-cena=" + $("#sort-cena").val();
        }
        if ($("#sort-vreme").val() != "") {
            urladresa += "&sort-vreme=" + $("#sort-vreme").val();
        }
        if ($("#naziv-artikla").val() != "") {
            urladresa += "&naziv-artikla=" + $("#naziv-artikla").val();
        }
        if ($("#marka-artikla").val() != "") {
            urladresa += "&marka-artikla=" + $("#marka-artikla").val();
        }
        window.location.href = urladresa;
    }
});


$("#sort-cena").change(function() {
    let sortArtikla = $(this);
    urladresa = "bela-tehnika.php?broj-strane=1";
    if ($(sortArtikla).val() != "") {
        urladresa += "&sort-cena=" + $(sortArtikla).val();
    }
    if ($("#sort-vreme").val() != "") {
        urladresa += "&sort-vreme=" + $("#sort-vreme").val();
    }
    if ($("#naziv-artikla").val() != "") {
        urladresa += "&naziv-artikla=" + $("#naziv-artikla").val();
    }
    if ($("#marka-artikla").val() != "") {
        urladresa += "&marka-artikla=" + $("#marka-artikla").val();
    }
    window.location.href = urladresa;
});

$("#sort-vreme").change(function() {
    let sortArtikla = $(this);
    urladresa = "bela-tehnika.php?broj-strane=1";
    if ($("#sort-cena").val() != "") {
        urladresa += "&sort-cena=" + $("#sort-cena").val();
    }
    if ($(sortArtikla).val() != "") {
        urladresa += "&sort-vreme=" + $(sortArtikla).val();
    }    
    if ($("#naziv-artikla").val() != "") {
        urladresa += "&naziv-artikla=" + $("#naziv-artikla").val();
    }
    if ($("#marka-artikla").val() != "") {
        urladresa += "&marka-artikla=" + $("#marka-artikla").val();
    }
    window.location.href = urladresa;
});


$("#btn-pretrazi").click(function(){
    urladresa = "bela-tehnika.php?broj-strane=1";
    if ($("#sort-cena").val() != "") {
        urladresa += "&sort-cena=" + $("#sort-cena").val();
    }
    if ($("#sort-vreme").val() != "") {
        urladresa += "&sort-vreme=" + $("#sort-vreme").val();
    }
    if ($("#naziv-artikla").val() != "") {
        urladresa += "&naziv-artikla=" + $("#naziv-artikla").val();
    }
    if ($("#marka-artikla").val() != "") {
        urladresa += "&marka-artikla=" + $("#marka-artikla").val();
    }
    window.location.href = urladresa;
});

});