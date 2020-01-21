<?php
    $connection = mysqli_connect("localhost","root","","prodavnica-tehnike");
    if(mysqli_connect_errno()){
        die("Poruka o grešci: " . mysqli_connect_error());
    }
    mysqli_query($connection,"SET NAMES utf-8");
?>