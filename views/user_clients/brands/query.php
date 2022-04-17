<?php
 
 if (!function_exists('base_url')) {
    function base_url($atRoot=FALSE, $atCore=FALSE, $parse=FALSE){
        if (isset($_SERVER['HTTP_HOST'])) {
            $http = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off' ? 'https' : 'http';
            $hostname = $_SERVER['HTTP_HOST'];
            $dir =  str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);

            $core = preg_split('@/@', str_replace($_SERVER['DOCUMENT_ROOT'], '', realpath(dirname(__FILE__))), NULL, PREG_SPLIT_NO_EMPTY);
            $core = $core[0];

            $tmplt = $atRoot ? ($atCore ? "%s://%s/%s/" : "%s://%s/") : ($atCore ? "%s://%s/%s/" : "%s://%s%s");
            $end = $atRoot ? ($atCore ? $core : $hostname) : ($atCore ? $core : $dir);
            $base_url = sprintf( $tmplt, $http, $hostname, $end );
        }
        else $base_url = 'http://localhost/';

        if ($parse) {
            $base_url = parse_url($base_url);
            if (isset($base_url['path'])) if ($base_url['path'] == '/') $base_url['path'] = '';
        }

        return $base_url;
    }
}
    $url = base_url();

    #error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT & E_ERROR & E_WARNING);
    $conn = mysqli_connect("localhost", "root", "", "stock");
 
    if (isset($_POST["save"]))
    {

        $customer_id = $_POST["customer_id"];
        $customer_name = $_POST["customer_name"];
        $user_username = $_POST["users_username"];

        #echo "Array length: ".count($customer_id)."</br>";
        #$rows = $_POST["items"];

        #echo count($customer_id);

        for ($a = 0; $a < count($customer_id); $a++)
        {
            #echo "a: ".$a."</br>";
            #echo "Customer id echo: ".$customer_id[$a]."</br>";
            #echo "Customer name echo: ".$customer_name[$a]."</br>";
            #echo "users username echo: ".$user_username[$a]."</br>";

            $sql = "SELECT id from users where users.username = '".$user_username[$a]."'";
            #echo "</br> SELECT SQL: ".$sql."</br>";
            $result = mysqli_query($conn, $sql);
            $user_id = mysqli_fetch_array($result, MYSQLI_NUM);
            #echo "</br> user_id: ".$user_id[0]."</br>";

            $sql = "INSERT INTO customers (id, parent_id, name) VALUES ('".$customer_id[$a]."', ".$user_id[0].", '".$customer_name[$a]."')";
            #echo "</br> INSERT SQL: ".$sql."</br>";
            $result = mysqli_query($conn, $sql);

            if($result){
                echo "Client '".$customer_name[$a]."' was added successfully! </br>";
                echo "<form action='$url'> <input type='submit' value='Kthehu' /></form>";
            } else {
                echo "Client '".$customer_name[$a]."' was NOT added successfully! </br> Check ID! </br>";
                    echo "<form action='$url'> <input type='submit' value='Kthehu' /></form>";
            }
        }

    }
 
?>