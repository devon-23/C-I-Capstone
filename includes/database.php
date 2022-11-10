<?php
    /**
     *  Get the database connection 
     * 
     *  @return object Connection to a MySQL server
     */
    function getDB() {
        $db_host = "sql9.freemysqlhosting.net";
        $db_name = "sql9556147";
        $db_user = "sql9556147";
        $db_pass = "yNEXvCef8f";

        $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

        if (mysqli_connect_error()) {
            echo mysqli_connect_error();
            exit;
        }
        print_r("Connected");
        return $conn;
    }
?>
