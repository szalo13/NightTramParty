<?php
    session_start();
    require_once "functions.php";

//----------------------------------------------------------------------------------//
//Update informacji z panelu hostels
    if ((isset($_SESSION['zalogowany'])) && ($_SESSION['permissions'] == 0)){
        
        if(isset($_POST['id'])){
            
            $id = $_POST['id']; //id eventu, dla ktorego beda sprzedawane bilety
            $tickets = $_POST ['soldTickets']; //pobranie wartosci biletow do sprzedazy
            
            $hostelName = $_SESSION['name'];
            $currentDate = date("Y-m-d");
            $currentTime = date("H:i");
            $buyerName = $_POST ['buyerName'];
            
            //Nawiazanie polaczenia z baza danych
            require_once "connect.php";

            $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);

            if($polaczenie->connect_errno!=0)
            {
                echo "Error: ".$polaczenie->connect_errno;
            }
            else
            {
                //Event update
                $sql = "SELECT soldTickets FROM `events` WHERE id = " . $id . "";
                $result = $polaczenie->query($sql);
                
                if ($result->num_rows > 0){
                    $row = $result->fetch_assoc();
                    
                    $soldTickets = $tickets + $row['soldTickets'];  //suma biletow zakupionych wczesniej oraz aktualnie zakupowanych
                    
                    $sql = "UPDATE events SET soldTickets=" . $soldTickets . " WHERE id=". $id ."";
                    $updateTickets = $polaczenie->query($sql);
                    
                }
                
                //History update
                updateHistory($polaczenie,$tickets, $currentDate, $currentTime, $buyerName, $hostelName, $id);
                
             $polaczenie->close();  
             header ('Location: hostels.php');
            }
        }
        else {
            $_SESSION['secondMessage'] = "Zakup biletu się nie powiódł, spróbuj jeszcze raz";
            header ('Location: hostels.php');
        }

        
        
        
//----------------------------------------------------------------------------------//        
//Update informacji z panelu Admin
    } else if ((isset($_SESSION['zalogowany'])) && ($_SESSION['permissions'] == 1)){
        
        if(isset($_POST['add'])){
//------------------------------------------------ADD    
            $name = $_POST['name'];
            $date = $_POST['date'];
            $time = $_POST['time'];
            $tickets = $_POST['tickets'];
            $soldTickets = 0;
            $link1 = $_POST['link1'];
            
            //Nawiazanie polaczenia z baza danych
            require_once "connect.php";

            $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);

            if($polaczenie->connect_errno!=0)
            {
                echo "Error: ".$polaczenie->connect_errno;
            }
            else
            {
                $sql = "INSERT INTO `events`(`id`, `name`, `date`, `time`, `tickets`, `soldTickets`, `link1`) VALUES ('','".$name."', '".$date."', '".$time."', '".$tickets."', '".$soldTickets."', '".$link1."')"; 
                
                
                $result = $polaczenie->query($sql);
                
                if ($result){
                    
                    header ('Location: adminpanel.php');
                } else {
                    echo "niepowodzenie, nie dodano do bazy danych";
                }
             
             $polaczenie->close();   
            }
            
//------------------------------------------------CHANGE
        } else if(isset($_POST['change'])){
            
            $id = $_POST['change'];
            $name = $_POST['name'];
            $date = $_POST['date'];
            $time = $_POST['time'];
            $tickets = $_POST['tickets'];
            $soldTickets = $_POST['soldTickets'];
            $link1 = $_POST['link1'];
            
            //Nawiazanie polaczenia z baza danych
            require_once "connect.php";

            $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);

            if($polaczenie->connect_errno!=0)
            {
                echo "Error: ".$polaczenie->connect_errno;
            }
            else
            {
                $sql = "UPDATE events SET name='" . $name . "', date='" . $date . "', time='" . $time . "', tickets='" . $tickets . "', soldTickets='" . $soldTickets . "', link1='" . $link1 . "' WHERE id=". $id ."";
                
                
                $result = $polaczenie->query($sql);
                
                if ($result){
                    header ('Location: adminpanel.php');
                } else {
                    $_SESSION['secondMessage'] = "niepowodzenie, nie dodano do bazy danych";
                }
             
             $polaczenie->close();   
            }  
//------------------------------------------------DELETE
        } else if (isset($_POST['delete'])){
            
            $id = $_POST['delete'];
                
            //Nawiazanie polaczenia z baza danych
            require_once "connect.php";

            $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);

            if($polaczenie->connect_errno!=0)
            {
                echo "Error: ".$polaczenie->connect_errno;
            }
            else
            {
                $sql = "DELETE FROM `events` WHERE `events`.`id` = ".$id."";
                
                
                $result = $polaczenie->query($sql);
                
                if ($result){
                    header ('Location: adminpanel.php');
                } else {
                    $_SESSION['secondMessage'] = "niepowodzenie, nie dodano do bazy danych";
                }
             $polaczenie->close();   
            }        
        }
        else {
            $_SESSION['secondMessage'] = "Zmiana wydarzenia nie powiodła się, spróbuj jeszcze raz";
            header ('Location: adminpanel.php');
        }           
        
        
    } else {
        header ('Location: index.php');
    }

?>