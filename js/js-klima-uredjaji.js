function naziviZaMarku(){
    $.ajax({
        type: "POST",
        url: "ajax-obrada.php?funkcija=naziviZaMarku",
        data: {
            "marka": $("#marka-artikla").val(),
            "grupa": 'Klima uređaji'
        },
        dataType: "json",
        success: function (response) {
            let nazivValue = $("#naziv-artikla").val();
            $("#naziv-artikla").empty();
            let html = ``;
            html += `
                <option value="">Odaberite naziv artikla</option>
            `;
            for(let obj of response){
                html += `
                    <option value="${obj}">${obj}</option>
                `;
            }               
            $("#naziv-artikla").append(html);
            $("#naziv-artikla").val(nazivValue);  
        }
    });
}


function markeZaNaziv(){
    $.ajax({
        type: "POST",
        url: "ajax-obrada.php?funkcija=markeZaNaziv",
        data: {
            "naziv": $("#naziv-artikla").val(),
            "grupa": 'Klima uređaji'
        },
        dataType: "json",
        success: function (response) {
            let markaValue = $("#marka-artikla").val();
            $("#marka-artikla").empty();
            let html = ``;
            html += `
                <option value="">Odaberite marku artikla</option>
            `;
            for(let obj of response){
                html += `
                    <option value="${obj}">${obj}</option>
                `;
            }           
            $("#marka-artikla").append(html);
            $("#marka-artikla").val(markaValue);
        }
    });  
}

$(document).ready(function() {
    let urladresa = "klima-uređaji.php?broj-strane=1";

$(".btn-page").click(function() {
    let button = $(this);
    let urladresa ="klima-uređaji.php?broj-strane=" + button.attr("btn-id");
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
        urladresa ="klima-uređaji.php?broj-strane=" + (numOfPage - 1);
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
        urladresa ="klima-uređaji.php?broj-strane=" + (numOfPage + 1);
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




$("#naziv-artikla").change(function(){
    markeZaNaziv();
});
markeZaNaziv();


$("#marka-artikla").change(function(){
    naziviZaMarku();
});
naziviZaMarku();



$("#sort-cena").change(function() {
    let sortArtikla = $(this);
    urladresa = "klima-uređaji.php?broj-strane=1";
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
    urladresa = "klima-uređaji.php?broj-strane=1";
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
    urladresa = "klima-uređaji.php?broj-strane=1";
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
