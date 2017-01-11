<?php
    session_start();

    //Jesli uzytkownik nie jest zalogowany odsyla go do index.php
    if ((!isset($_SESSION['zalogowany'])) && ($_SESSION['permissions'] == 0))
    {
        header('Location: index.php');
        exit();
    }
    else
    {
        require_once "connect.php";
        
        $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
        
        if($polaczenie->connect_errno!=0)
        {
            echo "Error: " . $polaczenie->connect_errno;
        }
        else
        {
            $sql = "SELECT * FROM `events` WHERE (date >= CURRENT_DATE())";
            $result = $polaczenie->query($sql);
            

        }
    }
?>

<?php

            if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    echo $row['id'] . " ";
                }
            } else {
                echo "0 results";
            }
?>