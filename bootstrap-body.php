<?php 
    echo '
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script>
            $(document).ready(function(){
    ';
    if(isset($_SESSION["Artikli-Korpa"])){
        echo '
            $("#korpa-ukupno-artikala").html(' . count($_SESSION["Artikli-Korpa"]) . ');
            $("#link-korpa").removeClass("text-light");
            $("#link-korpa").addClass("text-warning");
        ';
        $ukupnaCena = 0;
        for($i = 0;$i< count($_SESSION["Artikli-Korpa"]);$i++){
            $ukupnaCena += $_SESSION["Artikli-Korpa"][$i]["cena"];
        }
        echo '
            $("#cena-korpa-ukupno").html("' . intval($ukupnaCena) . ' RSD");
        ';
    }
    if(!isset($_SESSION["Artikli-Korpa"]) || count($_SESSION["Artikli-Korpa"]) == 0) {
        echo '
            $("#cena-korpa-ukupno").html("0.00 RSD");
            $("#link-korpa").addClass("text-light");
            $("#link-korpa").removeClass("text-warning");
        ';
    }
    echo '
            });
        </script>
    ';
?>