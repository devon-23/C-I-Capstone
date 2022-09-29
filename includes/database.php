<?php
    /**
     *  Get the database connection 
     * 
     *  @return object Connection to a MySQL server
     */
    function getDB() {
        $db_host = "localhost";
        $db_name = "barcla29";
        $db_user = "barcla29";
        $db_pass = "1Blushingpig!";

        $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

        if (mysqli_connect_error()) {
            echo mysqli_connect_error();
            exit;
        }
        // print_r("Connected");
        return $conn;
    }
?>
