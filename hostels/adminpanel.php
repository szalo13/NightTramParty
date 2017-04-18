<?php
    session_start();
    require_once "functions.php";

    //Jesli uzytkownik nie jest zalogowany odsyla go do index.php
    if ((!isset($_SESSION['zalogowany'])) || (!$_SESSION['permissions'] == 1))
    {   
        header('Location: index.php');
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
            $sql = "SELECT * FROM `events` WHERE (date >= CURRENT_DATE()) ORDER BY date ASC";
            $result = $polaczenie->query($sql);
            
            //Wiadomosc pokazywana nad tabela z wydarzeniami
            if($result->num_rows > 0) {
                $_SESSION['message'] = "Najbliższe imprezy:";
            }
            else {
                $_SESSION['message'] = "Brak imprez w najbliższym czasie.";
            }   
            
            
            $pastEventsSql = "SELECT * FROM `events` WHERE (date <= CURRENT_DATE()) ORDER BY date DESC";
            $pastEvents = $polaczenie->query($pastEventsSql);
            

            //Wiadomosc pokazywana nad tabela z wydarzeniami
            if($pastEvents->num_rows > 0) {
                $_SESSION['pastMessage'] = "Minione imprezy:";
            }
            else {
                $_SESSION['pastMessage'] = "";
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
                                    <th>Nazwa</th>
                                    <th>Data</th>
                                    <th>Godzina</th>
                                    <th>Bilety</th>
                                    <th>Sprzedane</th>
                                    <th>Link</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>';
                        //Wyswietlenie lini dodawania wydarzen
                        $tickets = 120;
                        echo '<tr class="tr-add">
                                <form action="updateinfo.php" method="post">
                                    <td><input type="text" name="name" value="NightTramParty"></input></td>
                                    <td><input type="date" name="date" placeholder="YYYY-MM-DD"></input></td>
                                    <td><input type="time" name="time" placeholder="HH:MM"></input></td>
                                    <td><input type="text" name="tickets" value="' . $tickets . '"></input></td>
                                    <td><input type="text" name="soldTickets" value="0"></input></td>
                                    <td><input type="text" name="link1" placeholder="Link do imprezy"></input></td>
                                    <td><button class="btn btn-small btn-warning" type="submit" name="add" value=""><i class="fa fa-plus fa-lg"></i> Dodaj </button></td>
                                </form>
                            </tr>';
                if($result->num_rows > 0){
                        //Wyswietlenie wszystkich wydarzen w tabeli
                        while($row = $result->fetch_assoc()){
                            $availableTickets = $row['tickets'] - $row['soldTickets'];
                            $timeFormated = date('H:i', strtotime($row['time']));
                            
                            echo '<tr class="">
                                        <form action="updateinfo.php" method="post">
                                        
                                        <td><input type="text" name="name" value="' . $row['name'] . '"</input></td>
                                        <td><input type="date" name="date" value="' . $row['date'] . '"</input></td>
                                        <td><input type="time" name="time" value="' . $row['time'] . '"</input></td>
                                        <td><input type="text" name="tickets" value="' . $row['tickets'] . '"</input></td>
                                        <td><input type="text" name="soldTickets" value="' . $row['soldTickets'] . '"</input></td>
                                        <td><input type="text" name="link1" value="' . $row['link1'] . '"</input></td>
                                        
                                        <td class="td-btn"><button class="btn btn-small btn-success" type="submit" name="change" value="' . $row['id'] . '">';
                                        echo '<i class="fa fa-floppy-o fa-lg"></i></button>
                                        
                                        <button class="btn btn-small btn-danger" type="submit" name="delete" value="' . $row['id'] . '">';
                                        echo '<i class="fa fa-trash-o fa-lg"></i></button></td></form>
                                    </tr>
                                </tbody>';
                        }
                    }
                ?>
            </table>
        </div>
    </div>
    
    
    <div class="">
        <div class="container text-center">
            <table class="table table-hover table-condensed text-center select-width ">
                <?php
                        
                        if(isset($_SESSION['pastMessage'])){
                            echo "<h1>" . $_SESSION['pastMessage'] . "</h1>";
                            unset($_SESSION['pastMessage']);
                        }
                        echo '<thead>
                                <tr>
                                    <th>Nazwa</th>
                                    <th>Data</th>
                                    <th>Godzina</th>
                                    <th>Bilety</th>
                                    <th>Sprzedane</th>
                                    <th>Link</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>';
                if($pastEvents->num_rows > 0){
                        //Wyswietlenie wszystkich wydarzen w tabeli
                        while($pastRow = $pastEvents->fetch_assoc()){
                            $availableTickets = $pastRow['tickets'] - $pastRow['soldTickets'];
                            $timeFormated = date('H:i', strtotime($pastRow['time']));

                            echo '<tr>
                                        <form action="updateinfo.php" method="POST">
                                        <td>' . $pastRow['name'] . '</td>
                                        <td>' . $pastRow['date'] . '</td>
                                        <td>' . $timeFormated . '</td>
                                        <td>' . $pastRow['tickets'] . '</td>
                                        <td>' . $pastRow['soldTickets'] . '</td>
                                        <td>' . $pastRow['link1'] . '</td>
                                        <td class="td-btn"><button class="btn btn-small btn-danger" type="submit" name="delete" value="' . $pastRow['id'] . '">';
                                        echo '<i class="fa fa-trash-o fa-lg"></i></button></td></form>
                                    </tr>
                                </tbody';
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