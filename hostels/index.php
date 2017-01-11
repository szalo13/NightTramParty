<?php 
    session_start();

    if((isset($_SESSION['zalogowany']) && ($_SESSION['zalogowany']==true)) && (isset($_SESSION['permission']) && ($_SESSION['permission']==0)))
    {
        header('Location: hostels.php');
        exit();
    }
?>


<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Hostele NTP - logowanie</title>
    
    <?php
        require_once "head.php";
    ?>
    
    
</head>

<body>
    <div class="hero-container">
        <div class="hero-box">
            <h1 class="text-center text-bold text-white">NightTramParty
            <br/>Hostels</h1>
            <form action="zaloguj.php" method="post" >
              <div class="form-group">
                <input type="text" class="form-control" name="login" placeholder="Login"/>
              </div>
              <div class="form-group">
                <input type="password" class="form-control" name="haslo" placeholder="Haslo"/>
                  <?php 
                    if(isset($_SESSION['blad']))
                    {
                        //echo '<p class="help-block text-alert">Nieprawidlowy login lub haslo</p>';
                        echo $_SESSION['blad'] . '\n' . $_SESSION['haslo'];
                        unset($_SESSION['blad']);
                    }
                  ?>
              </div>
                <button type="submit" class="btn btn-warning">Zaloguj się</button>
            </form>
        </div>
    </div>
</body>
</html>