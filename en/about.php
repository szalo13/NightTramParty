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
            <h1><?php //echo $eventMessage; ?>About us..</h1>
			<h3><br>
		<p>
			"We make fun !!"<br><br>
When you have a very great story<br>about how your product or service<br>was built to change young people lives,<br>share it with them at NIGHTRAMPARTY EVENTS !!<br><br>

Good stories humanize your brand..,<br>providing context.. and meaning for your product..<br>and the best way is to do that at NIGHTRAMPARTY EVENTS !!<br><br>What’s more.., good stories are very "sticky",<br>which means people are more likely to connect with them.. and pass them on..<br><br>

We are waiting for you !!<br>NIGHTRAMPARTY TEAM<br>
</p>

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