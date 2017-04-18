<?php
    session_start();

    //Jesli uzytkownik nie jest zalogowany odsyla go do index.php
    if ((!isset($_SESSION['zalogowany'])) || (!$_SESSION['permissions'] == 0))
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
            $sql = "SELECT * FROM `events` WHERE (date >= CURRENT_DATE()) ORDER BY date ASC";
            $result = $polaczenie->query($sql);
            
            //Wiadomosc pokazywana nad tabela z wydarzeniami
            if($result->num_rows > 0) {
                $_SESSION['message'] = "Najbliższe imprezy:";
            }
            else {
                $_SESSION['message'] = "Brak imprez w najbliższym czasie.";
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
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="#">Night Tram Party</a>
            </div>
        
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav">
              </ul>
                
             
              <ul class="nav navbar-nav navbar-right">
                  <li><a href="logout.php">Wyloguj</a></li>
              </ul>
            </div><!-- /.navbar-collapse -->
        </div>
    </nav>
    
    <div class="sz-section">
        <div class="container text-center">
            <h1>
                <?php
                    if(isset($_SESSION['message'])){
                        echo $_SESSION['message'];
                        unset($_SESSION['message']);
                    }
                ?>
            </h1>
            <p class="text-danger">
                <?php
                    if(isset($_SESSION['secondMessage'])){
                        echo $_SESSION['secondMessage'];
                        unset($_SESSION['secondMessage']);
                    }                
                ?>
            </p>
            <table class="table table-hover table-condensed text-center select-width">
                <?php
                    if($result->num_rows > 0){
                        echo '<thead>
                                <tr>
                                    <th>Imię</th>
                                    <th>Nazwa</th>
                                    <th>Data</th>
                                    <th>Godzina</th>
                                    <th>Dostępne bilety</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>';
                        while($row = $result->fetch_assoc()){
                            $availableTickets = $row['tickets'] - $row['soldTickets'];
                            $timeFormated = date('H:i', strtotime($row['time']));
                            
                            echo '<tbody>
                                    <tr>
                                        <form action="updateinfo.php" method="post" name="nazwa formularza">
                                        
                                        <td><input type="text" placeholder="Podaj imię" name="buyerName"></input></td>
                                        <td>' . $row['name'] . '</td>
                                        <td>' . $row['date'] . '</td>
                                        <td>' . $timeFormated. '</td>
                                        <td>' . $availableTickets . '</td>
                                        <td><select name="soldTickets">'; 
                                        
                                        for ($i = 0; $i <= $availableTickets; $i++){
                                            echo '<option value="' . $i . '">' . $i . '</option>';
                                        }
                                    //Przycik posiada przypisane ID imprezy, 
                                        echo '</select></td> 
                                        <td><button class="btn btn-small btn-success" type="submit" name="id" value="' . $row['id'] . '"';
                                    //Wylaczenie przycisku gdy brak dostepnych biletow
                                        if($availableTickets==0){
                                            echo ' disabled>';
                                        } else {
                                            echo '>';
                                        }
                            
                                        echo '<i class="fa fa-trash-o fa-lg"></i> Kup teraz </button></td></form>
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