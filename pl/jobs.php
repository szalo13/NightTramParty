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
            <h1>Praca..<?php //echo $eventMessage; ?></h1>
			
			<div class="">
			<h3><p>Organizowanie imprez wymaga pracy wielu osób.<br>
			Często potrzebujemy pomocy.<br>
			Jeśli interesujesz się organizacją dużych imprez<br>i jeśli jest to Twoja pasja, odwiedzaj naszą stronę.<br>
			Aktualne oferty znajdziesz poniżej.<br><br>
			Nasza praca sprowadza się do zabawy.<br>
Poszukujemy aktualnie do pomocy:<br><br>
<ul type="square">
<li>Fotografów imprezowych.</li>
<li>Chłopaka do obsługi sprzętu muzycznego z własnym samochodem.</li>
<li>Przewodników imprezowych z biegłą znajomością j. angielskiego i donośnym głosem.</li>
<li>Promotorów.</li>

</ul>
</p></div></h3>
			<?php //include 'box-text.php'; ?>
			
			
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