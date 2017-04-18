<?php

    session_start();

    require_once "connect.php";

    $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);

    if($polaczenie->connect_errno!=0)
    {
        echo "Error: ".$polaczenie->connect_errno;
    }
    else
    {
        
        $login = $_POST['login'];
        //$haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);
        //$haslo = $_POST['haslo']; 
        $haslo_unhash = $_POST['haslo'];
        
        $login = htmlentities($login, ENT_QUOTES, "UTF-8");
        $haslo1 = htmlentities($haslo_unhash, ENT_QUOTES, "UTF-8");
        $haslo = password_hash($haslo1, PASSWORD_DEFAULT);
        
        $_SESSION['login'] = $login;
        
        $sql = "SELECT * FROM users WHERE user='$login' AND pass='$haslo'";
        
        if($rezultat = @$polaczenie->query(
        sprintf("SELECT * FROM users WHERE login ='%s'",
        mysqli_real_escape_string($polaczenie, $login))))
        {
            $ilu_userow = $rezultat->num_rows;
            
            if ($ilu_userow>0)
            {
                
                $wiersz = $rezultat->fetch_assoc();
                
                if ($haslo == $wiersz['password'])
                {
                    $_SESSION['zalogowany'] = true;

                    $_SESSION['name'] = $wiersz['name'];
                    $_SESSION['permissions'] = $wiersz['permissions'];

                    unset($_SESSION['blad']);
                    $rezultat->free_result(); 

                    
                    //ROZDZIAL NA HOSTELS I ADMIN PANEL
                    if ($_SESSION['permissions'] == 1)
                    {
                        header('Location: adminpanel.php');
                    }
                    else 
                    {
                        header('Location: hostels.php');
                    }
                    
                    
                } 
                else 
                {
					//$_SESSION['blad'] = '<span style="color:red">Nieprawidlowy login lub hasło!</span> show pass: ' . $haslo . ' ' ;
                    $_SESSION['blad'] = $haslo;
                    $_SESSION['haslo'] = $wiersz['password'];
                    header('Location: index.php');
                }
                
            } else {
                //$_SESSION['blad'] = '<span style="color:red">Nieprawidlowy login lub hasło!</span> show pass: ' . $haslo . ' ' ;
                $_SESSION['blad'] = 'xxx';
                header('Location: index.php');
            }
        }
        
        $polaczenie->close();
    }

?>