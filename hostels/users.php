<?php
    session_start();
    require_once "functions.php";

    //Jesli uzytkownik nie jest zalogowany odsyla go do index.php
    if ((!isset($_SESSION['zalogowany'])) || (!$_SESSION['permissions'] == 1))
    {   
        header('Location: index.php');
        exit();
    }
    else
    {
    //Ustalenie polaczenia z baza danych MySql
        require_once "connect.php";
        
        $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
        
        if($polaczenie->connect_errno!=0)
        {
            echo "Error: " . $polaczenie->connect_errno;
        }
        else
        {
            //Wyslanie zapytania
            $sql = "SELECT * FROM `users` WHERE 1 ORDER BY permissions DESC";
            $result = $polaczenie->query($sql);
            
            //Wiadomosc pokazywana nad tabela z wydarzeniami
            if($result->num_rows > 0) {
                $_SESSION['message'] = "Użytkownicy";
            }
            else {
                $_SESSION['message'] = "Brak użytkowników";
            }   
            

        }
        $polaczenie->close();
    }
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>NightTramParty Hostels</title>   
    
    <?php
        require_once "head.php";
    ?>
</head>

<body>
    <?php
        require_once "adminNav.php";
    ?>
    <div class="sz-section"></div>
    <div class="">
        <div class="container text-center">
                <?php
                    if(isset($_SESSION['message'])){
                        echo "<h1>" . $_SESSION['message'] . "</h1>";
                        unset($_SESSION['message']);
                    }
                    if(isset($_SESSION['secondMessage'])){
                        echo '<p class="text-danger">' . $_SESSION['secondMessage'] . '</p>';
                        unset($_SESSION['secondMessage']);
                    }            
                echo '<table class="table table-hover table-condensed text-center select-width td-width-sm">';
                        echo '<thead>
                                <tr>
                                    <th>Login</th>
                                    <th>Nazwa Hostelu</th>
                                    <th>Uprawnienia</th>
                                </tr>
                            </thead>
                            <tbody>';
                if($result->num_rows > 0){
                        //Wyswietlenie wszystkich wydarzen w tabeli
                        while($row = $result->fetch_assoc()){
                            
                            echo '<tr class="">
                                        <form action="updateinfo.php" method="post">
                                        
                                        <td>' . $row['login'] . '</td>
                                        <td>' . $row['name'] . '</td>
                                        <td>' . $row['permissions'] . '</td>
                                        
                                    </tr>
                                </tbody>';
                        }
                    }
                ?>
            </table>
        </div>
    </div>
    
    <?php
        require_once "scripts.php";
    ?>
</body>
</html>