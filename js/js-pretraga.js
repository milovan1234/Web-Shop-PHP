$(document).ready(function() {
    let urladresa = "pretraga.php?pretraga=" + $("#pretraga").val() + "&broj-strane=1";

$(".btn-page").click(function() {
    let button = $(this);
    let urladresa ="pretraga.php?pretraga=" + $("#pretraga").val() + "&broj-strane=" + button.attr("btn-id");
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
        urladresa ="pretraga.php?pretraga=" + $("#pretraga").val() + "&broj-strane=" + (numOfPage - 1);
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
        urladresa = "pretraga.php?pretraga=" + $("#pretraga").val() + "&broj-strane=" + (numOfPage + 1);
        window.location.href = urladresa;
    }
});

});