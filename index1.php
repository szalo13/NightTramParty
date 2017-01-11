<?php

    session_start();

    require_once "hostels/connect.php";

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
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <title>Kraków - Night Tram Party</title>
    <link rel="icon" type="image/png" sizes="16x16" href="img/favicon.png">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Krakow - Night Tram Party - Best Party in Krakow!">
    <meta name="author" content="">
    
    
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet">
    
    <!-- Custom Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Vollkorn:700,400' rel='stylesheet' type='text/css'>
    
    <link href='https://fonts.googleapis.com/css?family=Unica+One&subset=latin-ext,latin' rel='stylesheet' type='text/css'>
    
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,800' rel='stylesheet' type='text/css'>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="font-awesome/css/font-awesome.css" type="text/css">
</head>
<body>
<!-- HERO FRONT PAGE -->
    <div id="header" class="hero header">
    <!-- NAVBAR -->
        <nav class="nav navbar-fixed-top">
            <div class="container-fluid">
                <ul class="col-sm-6 col-sm-offset-3 content">
                        <li><a href="#about" class="page-scroll">About</a></li>
                        <li><span><a href="#tickets" class="page-scroll">Sign Up!</a></span></li>
                        <li><a href="#googleMap" class="page-scroll">Map</a></li>
                </ul>
                <ul class="col-sm-3 social-logo">
                    <li>
                        <a href="https://www.facebook.com/NightTramParty/?fref=ts"><span class="fa fa-large fa-facebook-official"></span></a>
                    </li>
                    <li>
                        <a href="https://www.instagram.com/nighttramparty/"><span class="fa fa-large fa-instagram"></span></a>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="main-logo-padd">
            <div class="main-logo">
            </div>
        </div>
        <div class="movedown">
            <a href="#about" class="page-scroll"><span class="fa fa-4x fa-angle-double-down pulse"</span></a>
        </div>
    </div>
<!-- ABOUT SECTION -->
    <div class="container-fluid">
        <div id="about" class="section row about">
    <!--SECTION COVER IMAGE -->
            <div class="section-cover">
                <div class="container">
                    <div class="col-sm-8 col-sm-offset-2">
                        <div class="row">
                            <div class="head">
                                <h1>Night Tram Party!</h1>
                                <span>sounds <b>impossible</b>?</span>
                            </div>
                        </div>
                        <div class="row">
                            <div>
                                <h2>Not anymore!</h2>
                                <h3>We invite you for the best night tram ride of all times which joins partying and night sightseeing. </h3>
                            </div>
                        </div>
                        <div class="separator">
                            <div class="separator-line"></div>
                        </div>
                        <div class="row">
                            <div class="text-center content">
                                <p>Discover the amazing <b>Cracow's nightlife</b> which is probably the most exciting in Europe. Get on the party tram board with us and give yourself a chance to <b>meet travelers from around the world!</b></p>
                                <p>The two hours' Night Tram Party ride is followed by the <b>pub crawl!</b>
                                    Our crew will take you to the best local clubs and pubs where <b>the party is going to be continued.</b></p>
                                <strong>Buy a ticket now! The number of them is limited.</strong></p>
                            </div>
                        </div>
                        <div class="separator">
                            <div class="separator-line"></div>
                        </div>
                </div>
                <div class="col-sm-6 col-sm-offset-3">
                        <div class="row">
                            <div id="howItWorks" class="howItWorks">
                                <h3>How it works</h3>
                                    <ol class="text-left">
                                        <li>
                                            Each night party starts at <u>9:30 PM</u>.
                                        </li>
                                        <li>
                                            <u>Buy the ticket online</u> via one of platforms provided
                                        </li>
                                        <li>
                                            We start on tram station: <u>Pl. Wszystkich Świętych</u>. Be there at least <u>15minutes earlier</u> so that our crew could exchange Your ticket for <u>bracelet</u>.
                                        </li>
                                        <li>
                                            The party ride on The Night Tram Least <u>2 hours</u>.
                                        </li>
                                        <li>
                                            When the party ride is over you will be taken for the <u>pub crawl</u> showing you the best local pubs and clubs. <u>The entrance is free!</u>
                                        </li>
                                        <li>
                                            The number of tickets is limited - only 80 per one ride.
                                        </li>
                                        <li>
                                            <u>Be prepared!</u> We don't sell drinks on board!
                                        </li>
                                    </ol>
                            </div>
                        </div>
                </div>
                    <!-- HOW TO SIGN UP -->
                        <div class="row">
                            <div class="ico-con">
                                <div class="img">
                                    <img src="img/tram-logo.svg">
                                </div>
                                <div class="content">
                                    <span>
                                        All You have to do is to <b>Sign Up!</b> <br>
                                        Easy, Isn't it?
                                    </span>
                                </div>
                                <div class="movedown">
                                    <a href="#tickets" class="page-scroll"><span class="fa fa-4x fa-angle-double-down pulse"</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
<!-- GALLERY -->
    <div class="container-fluid" id="gallery">
        <div class="row no-gutter">
            <div class="col-lg-3 col-xs-6">
                <a href="#" class="gallery-box">
                    <img src="img/homeGallery/4.jpg" class="img-responsive" alt="">
                </a>
            </div>
            <div class="col-lg-3 col-xs-6">
                <a href="#" class="gallery-box">
                    <img src="img/homeGallery/2.jpg" class="img-responsive" alt="">
                </a>
            </div>
            <div class="col-lg-3 col-xs-6">
                <a href="#" class="gallery-box">
                    <img src="img/homeGallery/3.jpg" class="img-responsive" alt="">
                </a>
            </div>
            <div class="col-lg-3 col-xs-6">
                <a href="#" class="gallery-box">
                    <img src="img/homeGallery/1.jpg" class="img-responsive" alt="">
                </a>
            </div>
            <div class="col-lg-3 col-xs-6">
                <a href="#" class="gallery-box">
                    <img src="img/homeGallery/5.jpg" class="img-responsive" alt="">
                </a>
            </div>
            <div class="col-lg-3 col-xs-6">
                <a href="#" class="gallery-box">
                    <img src="img/homeGallery/6.jpg" class="img-responsive" alt="">
                </a>
            </div>
            <div class="col-lg-3 col-xs-6">
                <a href="#" class="gallery-box">
                    <img src="img/homeGallery/7.jpg" class="img-responsive" alt="">
                </a>
            </div>
            <div class="col-lg-3 col-xs-6">
                <a href="#" class="gallery-box">
                    <img src="img/homeGallery/8.jpg" class="img-responsive" alt="">
                </a>
            </div>
        </div>
    </div>
<!-- TICKETS -->
    <div class="tick-cont container">
            <div id="tickets" class="time clearfix">
                <div class="row">
                    
                    <?php
                    while($row = $result->fetch_assoc()){
                        $timeFormated = date('H:i', strtotime($row['time']));
                        
                        echo '<div class="col-sm-3 ev-box">
                            <li><h4>' . $row['date'] . '</h4></li>
                            <li>' . $timeFormated . '</li>
                            <li><h5><a href="' . $row['link1'] . '">Buy Ticket</a></h5></li>
                        </div>';
                        
                    }
                    ?>
                    
                </div>
            </div>
            <div class="tickets">
                <div class="content fx-size-500">
                    <span>DON’T FORGET TO SHOW UP AT LEAST 15 MINUTES ON THE Tram Stop TO TAKE A BRACELET!
                    </span>
                </div>
                 <div class="social">


                    <div class="social-logo">
                        <a href="https://www.facebook.com/NightTramParty/?fref=ts">
                            <span class="fa fa-facebook-official"></span>
                        </a>
                        <a href="https://www.instagram.com/nighttramparty/">
                            <span class="fa fa-instagram"></span>
                        </a>
                    </div>
                </div>
            </div>
    </div>
<!-- Map Section -->
    <div class="container-fluid">
        <div class="row">
            <div id="googleMap">
            </div>
        </div>
    </div>
<!-- Footer -->
    <div id="footer" class="footer">
        <span>© 2016 - Szalo - All rights reserved.</span>
    </div>
    
    <!-- Bootstrap Core JavaScript -->
    <script src="js/jquery.js"></script>
            
    <!-- Bootstrap Google Maps -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB8k58-iZb3EXNceSUS3TlGKF5SqvgvuHI"></script>
    <script src="js/googleMaps.js"></script>    
            
    <!-- Plugin JavaScript -->
    <script src="js/jquery.easing.min.js"></script>
    
    <!-- Plugin JavaScript -->
    <script src="js/scripts.js"></script>

        <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    
    <!-- Evenea -->
    <script type="text/javascript" src="//cdn.evenea.pl/js/iframe/new/iframeResizer2.js"></script>
    
</body>
</html>