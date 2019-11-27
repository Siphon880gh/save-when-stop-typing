<?php
    if(isset($_POST["log"])) {
        $log = $_POST["log"];
        $fptr = fopen("data.txt", "w");
        fwrite($fptr, $log);
    }
?>