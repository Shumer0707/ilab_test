<?php

include 'static/header.php';
if(isset($succes)){
    echo $succes;
}
if(isset($error)){
    echo '<pre>';
        print_r($error);
    echo '</pre>';
}
include 'static/footer.php';