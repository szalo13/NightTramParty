<?php require_once "header.php" ?>


<?php

session_start();

require_once "../functions/connect.php";

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



<div class="container offer-page site-header">
    <ul class="row title">
        <div class=""><img src="../img/logo.png" alt="night tram party krakow party"></div>
        <div class="">
            <h1>NIGHTTRAMPARTY<!-- Tu stary mechanizm automatyczny eventow --><?php //echo $eventMessage; ?></h1>
			<h2></h2><br>
			<h3>NIGHTTRAMPARTY - 2 MARCH 2017<br><a href="https://www.eventbrite.com/e/night-tram-party-2nd-march-tickets-32211577696">- BUY TICKET !! - [ENGLISH]</a></h3><br>
			<h3>NIGHTTRAMPARTY - 2 MARCH 2017<br><a href="https://ntpmarch.evenea.pl/"> - BUY TICKET !! - [POLISH]</a></h3><br>
 
			
        </div>
    </ul>
    <div class="clearfix ev-cont">

            <?php
            while($row = $result->fetch_assoc()){
                $timeFormated = date('H: i', strtotime($row['time']));

                echo '
                    <div class="row">
                        <div class="col-sm-12 ev-box ev-box-cvr">
                            <div class="ev-box-cvr">
                            </div>
                            <div class="col-sm-6">
                                    <h1>' . $row['name'] . '</h1>
                                    <h3><span class="ev-date">' . $row['date'] . '</span><span class="ev-time">' . $timeFormated . '</h4>
                            </div>
                            <div class="col-sm-6">
                                    <h3 class="ev-buy"><a href="' . $row['link1'] . '">Buy Ticket</a></h4>
                                    <h3 class="ev-price">50zł</h3>
                            </div>
                        </div>
                    </div>';
            }
            ?>

    </div>
</div>





<?php
require_once "googleMap.php";

require_once "contact.php";

require_once "footer.php";
?>