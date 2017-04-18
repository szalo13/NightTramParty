<?php

	session_start();
    if ((!isset($_SESSION['zalogowany'])) || (!$_SESSION['permissions'] == 1))
    {   
        header('Location: index.php');
        exit();
    } else {
        if (isset($_POST['nick']))
        {
            //Udana walidacja? Załóżmy, że tak!
            $wszystko_OK=true;

            //Sprawdź poprawność nickname'a
            $nick = $_POST['nick'];

            //Sprawdzenie długości nicka
            if ((strlen($nick)<3) || (strlen($nick)>20))
            {
                $wszystko_OK=false;
                $_SESSION['e_nick']="Nazwa hostelu musi posiadać od 3-20 znaków";
            }

            if (ctype_alnum($nick)==false)
            {
                $wszystko_OK=false;
                $_SESSION['e_nick']="Nick może składać się tylko z liter i cyfr (bez polskich znaków)";
            }

            //Sprawdzenie długości nazwy hostelu
            $hostelName = $_POST['hostelName'];

            if ((strlen($nick)<3) || (strlen($nick)>20))
            {
                $wszystko_OK=false;
                $_SESSION['e_hostelName']="Nazwa hostelu musi posiadać od 3-20 znaków";
            }

            if (ctype_alnum($nick)==false)
            {
                $wszystko_OK=false;
                $_SESSION['e_hostelName']="Nick może składać się tylko z liter i cyfr (bez polskich znaków)";
            }

            //Sprawdź poprawność hasła
            $haslo1 = $_POST['haslo1'];
            $haslo2 = $_POST['haslo2'];

            if ((strlen($haslo1)<8) || (strlen($haslo1)>20))
            {
                $wszystko_OK=false;
                $_SESSION['e_haslo']="Hasło musi posiadać od 8 do 20 znaków!";
            }

            if ($haslo1!=$haslo2)
            {
                $wszystko_OK=false;
                $_SESSION['e_haslo']="Podane hasła nie są identyczne!";
            }	

            $haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);


            //Zapamiętaj wprowadzone dane
            $_SESSION['fr_nick'] = $nick;
            $_SESSION['hostelName'] = $hostelName;
            $_SESSION['fr_haslo1'] = $haslo1;
            $_SESSION['fr_haslo2'] = $haslo2;

            require_once "connect.php";
            mysqli_report(MYSQLI_REPORT_STRICT);

            try 
            {       
                $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
                if ($polaczenie->connect_errno!=0)
                {
                    throw new Exception(mysqli_connect_errno());
                }
                else
                {
                    //Czy nick jest już zarezerwowany?
                    $rezultat = $polaczenie->query("SELECT id FROM users WHERE login='$nick'");

                    if (!$rezultat) throw new Exception($polaczenie->error);

                    $ile_takich_nickow = $rezultat->num_rows;
                    if($ile_takich_nickow>0)
                    {
                        $wszystko_OK=false;

                        $_SESSION['e_nick']="Istnieje już Hostel o podanej nazwie";
                    }

                    if ($wszystko_OK==true)
                    {
                        //Hurra, wszystkie testy zaliczone, dodajemy gracza do bazy

                        if ($polaczenie->query("INSERT INTO users VALUES (NULL, '$nick', '$haslo_hash', '$hostelName', '$permissions', 0)"))
                        {

                            $_SESSION['udanarejestracja']=true;
                            header('Location: users.php');
                        }
                        else
                        {
                            throw new Exception($polaczenie->error);
                        }

                    }

                    $polaczenie->close();
                }

            }
            catch(Exception $e)
            {
                echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
                echo '<br />Informacja developerska: '.$e;
            }

        } 

    }
    ?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>NTP - Admin - users</title>
	<script src='https://www.google.com/recaptcha/api.js'></script>

    <?php
        require_once "head.php";
    ?>
</head>

<body>
    <?php
        require_once "adminNav.php";
    ?>
	<div class="hero-container container">
        <div class="hero-box">
            <h1 class="text-white text-bold">Dodaj nowy Hostel</h1>
            <form method="post">
                <div class="form-group"> <input type="text" placeholder="Login:" class="form-control" value="<?php
                        if (isset($_SESSION['fr_nick']))
                        {
                            echo $_SESSION['fr_nick'];
                            unset($_SESSION['fr_nick']);
                        }
                    ?>" name="nick" />
                </div>

                <div class="form-group">
                    <input type="text" placeholder="Nazwa Hostelu:" class="form-control" value="<?php
                        if (isset($_SESSION['fr_hostelName']))
                        {
                            echo $_SESSION['fr_HostelName'];
                            unset($_SESSION['fr_HostelName']);
                        }
                    ?>" name="hostelName" />
                </div>
                <?php
                    if (isset($_SESSION['e_nick']))
                    {
                        echo '<div class="error">'.$_SESSION['e_nick'].'</div>';
                        unset($_SESSION['e_nick']);
                    }
                ?>

                <div class="form-group">
                    <input type="password" placeholder="Hasło:" class="form-control"  value="<?php
                        if (isset($_SESSION['fr_haslo1']))
                        {
                            echo $_SESSION['fr_haslo1'];
                            unset($_SESSION['fr_haslo1']);
                        }
                    ?>" name="haslo1" />
                </div>
                <div class="form-group">
                    <?php
                        if (isset($_SESSION['e_haslo']))
                        {
                            echo '<div class="error">'.$_SESSION['e_haslo'].'</div>';
                            unset($_SESSION['e_haslo']);
                        }
                    ?>
                </div>

                <div class="form-group">
                    <input type="password" placeholder="Powtórz hasło" class="form-control" value="<?php
                        if (isset($_SESSION['fr_haslo2']))
                        {
                            echo $_SESSION['fr_haslo2'];
                            unset($_SESSION['fr_haslo2']);
                        }
                    ?>" name="haslo2" />
                </div>

                <input type="submit" value="Dodaj Hostel" class="btn btn-info" />

            </form>
        </div>
    </div>
    <?php
        require_once "scripts.php";
    ?>
</body>
</html>