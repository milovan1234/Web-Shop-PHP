<?php
    session_start();
    if(!(isset($_SESSION["Prijavljen"]) &&  $_SESSION["Status"] == "Administrator")){    
        //Provera da li je prijavljeni korisnik Administrator
        header("Location: ./");
    }
    require_once "rad-sa-bazom.php";
    require_once "klase.php";
    $slikeSlajder = [];
    $query = "SELECT * FROM Slajder";
    if($result = mysqli_query($connection,$query)){
        while($object = mysqli_fetch_object($result)){
            $s = new Slajder();
            $s->id = $object->Id;
            $s->putanjaSlike = $object->Slika;
            $s->aktivna = $object->Aktivna;
            $s->datumDodavanja = $object->DatumDodavanja;
            $slikeSlajder[] = $s;
        }
    }
    else {
        die("Poruka o grešci: " . mysqli_error($connection));
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Slajder početna - Administrator</title>
    <?php 
        require_once "bootstrap-head.php";
    ?>
</head>

<body>
    <?php
        require_once "navigacija-admin.php";
        echo '<div class="main prikaz-deo">';
    ?>
    <div class="container">
        <h2 class="text-center py-4 font-weight-normal">Slike za slajder</h2>
        <a href="dodaj-sliku-slajder.php" class="btn btn-success font-weight-bold">Dodaj novu sliku&nbsp;&nbsp;<i class="fas fa-plus"></i></a>
        <?php
            if(count($slikeSlajder) == 0){
                echo '
                    <hr />
                    <div class="alert alert-danger alert-dismissible fade show text-center py-4" role="alert">
                        <strong>Trenutno nema ni jedne slike za slajder na početnoj strani!</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <hr />
                ';
            }
            else {
                echo '
                    <hr />
                    <div class="row">
                ';
                
                for($i=0; $i<count($slikeSlajder); $i++){
                    if($slikeSlajder[$i]->aktivna == 1){
                    echo '                           
                            <div class="col-sm-6 col-md-6 col-lg-4">
                                <div class="card mb-3 slajder-senka">
                                    <img class="card-img-top border" src="'. $slikeSlajder[$i]->putanjaSlike .'" alt="Card image cap">
                                    <div class="card-body">
                                        <h6 class="aktivnost-slike" data-id="' . $slikeSlajder[$i]->id . '"><small><i class="fas fa-circle text-success"></i></small> Aktivna</h6>
                                        <h6><small class="text-muted">Dodato: ' . date("d.m.Y H:i",strtotime($slikeSlajder[$i]->datumDodavanja)) . '</small></h6>
                                        <select data-id="' . $slikeSlajder[$i]->id . '" onchange="promenaStanja(this)" class="form-control aktivna" id="aktivna" name="aktivna">
                                            <option value="">Odaberite aktivnost slike</option>
                                            <option value="0">Neaktivna</option>
                                            <option value="1">Aktivna</option>
                                        </select>
                                        <button type="button" data-toggle="modal" data-img="'. $slikeSlajder[$i]->putanjaSlike .'"
                                             onclick="postaviSliku(this)" data-target="#modal-slika" class="btn btn-info mt-3">Puna veličina 
                                             <i class="fas fa-compress"></i></button>
                                    </div>
                                </div>
                            </div>
                        
                        ';
                    }
                    else {
                        echo '
                            <div class="col-sm-6 col-md-6 col-lg-4">
                                <div class="card mb-3 slajder-senka">
                                    <img class="card-img-top border" src="'. $slikeSlajder[$i]->putanjaSlike .'" alt="Card image cap">
                                    <div class="card-body">
                                        <h6 class="aktivnost-slike" data-id="' . $slikeSlajder[$i]->id . '"><small><i class="fas fa-circle text-danger"></i></small> Neaktivna</h6>
                                        <h6><small class="text-muted">Dodato: ' . date("d.m.Y H:i",strtotime($slikeSlajder[$i]->datumDodavanja)) . '</small></h6>
                                        <select data-id="' . $slikeSlajder[$i]->id . '" onchange="promenaStanja(this)" class="form-control aktivna" id="aktivna" name="aktivna">
                                            <option value="">Odaberite aktivnost slike</option>
                                            <option value="0">Neaktivna</option>
                                            <option value="1">Aktivna</option>
                                        </select>
                                        <button type="button" data-toggle="modal" data-img="'. $slikeSlajder[$i]->putanjaSlike .'"
                                        onclick="postaviSliku(this)"  data-target="#modal-slika" class="btn btn-info mt-3">Puna veličina <i class="fas fa-compress"></i></button>
                                    </div>
                                </div>
                            </div>
                        ';
                    }
                }

                echo '
                    </div>
                    <hr />
                ';
            }
        ?>
    </div>
    
    <?php
        require_once "bootstrap-body.php";
        //Modal Slika
        echo '
        <div class="modal fade" id="modal-slika" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <img data-toggle="modal" data-target="#modal-slika" id="modal-slike-slajder" class="img-fluid" src="">
            </div>
        </div>        
        ';
    ?>

    <script>
        $(document).ready(function() {
            $(".futer").addClass("d-block");
            $(".futer").addClass("d-lg-none");
        });
        function postaviSliku(obj){
            $("#modal-slike-slajder").attr("src",$(obj).attr("data-img"));
        }
    </script>
    <script src="js/js-navigacija-admin.js"></script>
    <script src="js/js-slajder-admin.js"></script>
    <?php
        echo '</div>';
        require_once "footer.php";
    ?>
</body>

</html>