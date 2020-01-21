<?php
    echo '
        <div class="futer bg-dark p-4 text-light mt-5">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-10">
                    <div class="row">
    ';
    $query = "SELECT * FROM Grupa WHERE Aktivna=1";
    if($result = mysqli_query($connection,$query)){
        echo '
            <div class="col-md-2">
                <span style="border-left:10px solid #17a2b8;"> </span>
                &nbsp;&nbsp;<a href="./" class="text-light artikal-link">Početna</a>
            </div>
        ';
        while($object = mysqli_fetch_object($result)){
            echo '
                <div class="col-md-2">
                    <span style="border-left:10px solid #17a2b8;"> </span>
                    &nbsp;&nbsp;<a href="' . vratiStranicu($object->Naziv) . '" class="text-light artikal-link">' . $object->Naziv . '</a>
                </div>
            ';
        }        
    }
    else {
        die("Poruka o grešci: " . mysqli_error($connection));
    }
    echo'
                    </div>                    
                </div>
            </div>
            <!--<div class="text-center mt-4">
                <a href="#" class="text-info mx-2"><i class="fab fa-facebook fa-2x"></i></a>
                <a href="#" class="text-info mx-2"><i class="fab fa-instagram fa-2x"></i></a>
                <a href="#" class="text-info mx-2"><i class="fab fa-twitter-square fa-2x"></i></a>
            </div>-->
            <h6 class="text-center mt-3">
                Copyright &copy; Prodavnica Tehnike - ' .date("Y") . '.
            </h6>
        </div>
    ';
?>