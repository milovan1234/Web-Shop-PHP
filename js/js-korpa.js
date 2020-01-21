function dodajUKorpu(obj){
    $.ajax({
        type: "POST",
        url: "ajax-obrada.php?funkcija=dodajKorpa",
        data: {
            "id-artikla": $(obj).attr("data-id")
        },
        dataType: "json",
        success: function (response) {
            if(response == "Greska-Postoji"){
                alert("Ne možete dodati u korpu Artikal koji ste već prethodno dodali!");
            }
            else if(response == "Greska-BrojStanja"){
                alert("Izabrani Artikal trenutno nije na stanju!");
            }
            else {
                $("#korpa-ukupno-artikala").html(response.length);
                let ukupnaCena = 0;
                for(let i=0;i<response.length;i++){
                    ukupnaCena += parseInt(response[i].cena);
                }
                $("#cena-korpa-ukupno").html(ukupnaCena + " RSD");
                $("#link-korpa").removeClass("text-light");
                $("#link-korpa").addClass("text-warning");
            }            
        },
        error: function (error) {
            console.log(error);
        }
    });
}


function brisanjeArtiklaKorpa(obj){
    $.ajax({
        type: "POST",
        url: "ajax-obrada.php?funkcija=brisanjeArtiklaKorpa",
        data: {
            "id-artikla": $(obj).attr("data-id")
        },
        dataType: "json",
        success: function (response) {
            window.location.href = "korpa.php";
        }
    });
}

function kupiProizvod(){
    let artikliKupovina = $(".artikli-kupovina"); 
    let greska = "";
    if(artikliKupovina.length > 0) {
        for(let i=0;i<artikliKupovina.length;i++){
            let kolicina = $(artikliKupovina[i]).children(".col-md-9").children(".row").children(".col-sm-3").children("#kolicina-artikla");
            if(parseInt($(kolicina).val()) < parseInt($(kolicina).attr("min")) 
                || parseInt($(kolicina).val()) > parseInt($(kolicina).attr("max"))){
                greska += "Unos količine kod  " + (i+1) + ". artikla je van dozvoljenog opsega(" + $(kolicina).attr("min") + "," + $(kolicina).attr("max") + ").\n";
            }                 
        }
    }    
    if(artikliKupovina.length == 0){
        alert("Da bi ste izvršili kupovinu morate odabrati neki Artikal!");
    }
    else if(greska != ""){
        alert("Greška kod unosa količine:\n" + greska);
    }
    else {
        let artikli = [];
        for(let i=0;i<artikliKupovina.length;i++){
            let art = {
                "idArtikla": $(artikliKupovina[i]).children("#id-artikla").val(),
                "nazivArtikla": $(artikliKupovina[i]).children("#naziv-artikla").val(),
                "markaArtikla": $(artikliKupovina[i]).children("#marka-artikla").val(),
                "opisArtikla": $(artikliKupovina[i]).children("#opis-artikla").val(),
                "cenaArtikla": parseInt($(artikliKupovina[i]).children("#cena-artikla").val()),
                "kolicina": parseInt($(artikliKupovina[i]).children(".col-md-9").children(".row").children(".col-sm-3").children("#kolicina-artikla").val())
            };
            artikli.push(art);            
        }
        let racun = {
            "artikli": artikli,
            "ukupnaCena": parseInt($("#ukupno-cena-racun").val())
        };
        $.ajax({
            type: "POST",
            url: "ajax-obrada.php?funkcija=kupovinaProizvoda",
            data: {
                "racun": JSON.stringify(racun)
            },
            dataType: "json",
            success: function (response) {
                $("#racun-broj-transakcije").html(response.brojTransakcije);
                $("#racun-ime-prezime").html(response.imePrezime);
                $("#racun-broj-kupljenih").html(response.brojKupljenih);
                $("#racun-ukupno-cena").html(response.ukupnaCena + " RSD");
                $(".alert-racun").addClass("d-block");
                $(".alert-racun").removeClass("d-none");
                $(".alert-korpa").addClass("d-block");
                $(".alert-korpa").removeClass("d-none");
                $(".artikli-kupovina").empty();
                $("#cena-korpa-ukupno").html("0.00 RSD");
                $("#ukupno-cena-korpa").html("0.00 RSD");
                $("#korpa-ukupno-artikala").html(0);
                $("#link-korpa").addClass("text-light");
                $("#link-korpa").removeClass("text-warning");
            },
            error: function (error) {
                console.log(error);
            }
        });
    }
}