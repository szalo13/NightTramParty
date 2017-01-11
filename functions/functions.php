<?php

function connect() {
    session_start();

    require_once "connect.php";

    $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);

    if($polaczenie->connect_errno!=0)
    {
        echo "Error: ".$polaczenie->connect_errno;
    }
    else
    {
        $sql = "SELECT * FROM `events` WHERE (date >= CURRENT_DATE()) ORDER BY date ASC";
        $result = $polaczenie->query($sql);

        if($result->num_rows > 0) {
            $eventMessage = "Upcoming Events";
        }
        else {
            $eventMessage = "There is no events for now";
        }


    }
    return $result;
}




connect();
?>