$(document).ready(function() {
    let urladresa = "svi-artikli.php?naziv-grupe=" + $("#naziv-grupe-skriveno").val() + "&broj-strane=1";

$(".btn-page").click(function() {
    let button = $(this);
    let urladresa ="svi-artikli.php?naziv-grupe=" + $("#naziv-grupe-skriveno").val() + "&broj-strane=" + button.attr("btn-id");
    if ($("#sort").val() != "") {
        urladresa += "&sort=" + $("#sort").val();
    }
    if ($("#naziv-artikla").val() != "") {
        urladresa += "&naziv-artikla=" + $("#naziv-artikla").val();
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
        urladresa ="svi-artikli.php?naziv-grupe=" + $("#naziv-grupe-skriveno").val() + "&broj-strane=" + (numOfPage - 1);
        if ($("#sort").val() != "") {
            urladresa += "&sort=" + $("#sort").val();
        }
        if ($("#naziv-artikla").val() != "") {
            urladresa += "&naziv-artikla=" + $("#naziv-artikla").val();
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
        urladresa = "svi-artikli.php?naziv-grupe=" + $("#naziv-grupe-skriveno").val() + "&broj-strane=" + (numOfPage + 1);
        if ($("#sort").val() != "") {
            urladresa += "&sort=" + $("#sort").val();
        }
        if ($("#naziv-artikla").val() != "") {
            urladresa += "&naziv-artikla=" + $("#naziv-artikla").val();
        }
        window.location.href = urladresa;
    }
});

let sveGrupe = $(".grupe");
let nazivGrupe = $("#naziv-grupe-skriveno").val();
for (let i = 0; i < sveGrupe.length; i++) {
    if ($(sveGrupe[i]).attr("alt") == nazivGrupe) {
        $(sveGrupe[i]).addClass("border-success");
        $(sveGrupe[i]).removeClass("border-danger");
    }
}

$("#naziv-artikla").change(function() {
    let nazivArtikla = $(this);
    urladresa = "svi-artikli.php?naziv-grupe=" + $("#naziv-grupe-skriveno").val() + "&broj-strane=1";
    if ($("#sort").val() != "") {
        urladresa += "&broj-strane=1&sort=" + $("#sort").val();
    }
    if ($(nazivArtikla).val() != "") {
        urladresa += "&naziv-artikla=" + $(nazivArtikla).val();
    }
    window.location.href = urladresa;
});

$("#sort").change(function() {
    let sortArtikla = $(this);
    urladresa = "svi-artikli.php?naziv-grupe=" + $("#naziv-grupe-skriveno").val() + "&broj-strane=1";
    if ($(sortArtikla).val() != "") {
        urladresa += "&sort=" + $(sortArtikla).val();
    }
    if ($("#naziv-artikla").val() != "") {
        urladresa += "&naziv-artikla=" + $("#naziv-artikla").val();
    }
    window.location.href = urladresa;
});
  

//Brisanje Artikala asinhronim putem
$(".btn-delete").click(function(){
    let button = $(this);
    if(confirm("Da li ste sigurni da želite da obrišete artikal?")){
        $.ajax({
            method: "GET",
            url: "brisanje-artikla.php?id-artikla=" + button.attr("delete-id"),
            success: function () {
                window.location.href = "svi-artikli.php?naziv-grupe=Bela Tehnika&broj-strane=1";
            }
        });
    }
});


});

function brisanjeArtikla(obj){
    if(confirm("Da li ste sigurni da želite da obrišete Artikal?")){
        window.location.href = "brisanje-artikla.php?id-artikla=" + $(obj).attr("data-id");
    }   
}
