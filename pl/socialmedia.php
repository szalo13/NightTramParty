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
        $eventMessage = "Nadchodzące wydarzenia";
    }
    else {
        $eventMessage = "Brak wydarzeń w najbliższym czasie";
    }


}
?>



<div class="container offer-page site-header">
    <ul class="row title">
        <div class=""><img src="../img/logo.png" alt="night tram party krakow party"></div>
        <div class="">
            <h1>Social Media<?php //echo $eventMessage; ?></h1>
			
			  <div class="social">
			  <h3>Zapraszamy na nasze profile Social Media. <br>
			  Możesz poczytać co nasi imprezowicze napisali.<br>
			  Możesz zobaczyć jak nasi imprezowicze wspaniale się bawili.</h3>
			  <br><br>
			  
			  <ul>
        <li>
            <a href="https://www.facebook.com/NightTramParty/?fref=ts">
                <span class="fa fa-3x fa-facebook-official"></span> www.facebook.com/NightTramParty/<br><br>
            </a>
        </li>
        <li>
            <a href="https://www.instagram.com/nighttramparty/">
                <span class="fa fa-3x fa-instagram"></span> www.instagram.com/nighttramparty/<br><br>
            </a>
        </li>
		
		</ul>
		
    </div>
			
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
                                    <h3 class="ev-buy"><a href="' . $row['link1'] . '">Kup bilet</a></h4>
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