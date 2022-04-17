<?php

    $name = $_POST["name"];
    $conn = new mysqli("localhost","root","","stock");
    $sql = "delete from customers where customers.name ='".$name."';";
    $conn -> query($sql);
    echo $sql;
?>