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
            <h1><?php //echo $eventMessage; ?>O nas..</h1>
			<h3><br>
		
			Organizowanie imprez to nasza pasja..<br>
Staramy się zapewniać rozrywkę na najwyższym poziomie.<br>

Intensywny, elektryzujący charakter naszych imprez,<br>
to niepowtarzalna okazja do fantastycznej zabawy.<br>

Zapraszamy na nasze imprezy wszystkich lubiących dobrą zabawę..<br>

Zapraszamy też do współpracy firmy<br>od bardzo dużych do małych, zapraszamy do współpracy agencje reklamowe.<br>

Zapraszamy do współpracy sponsorów,<br>firmy tworzące produkty: kosmetyczne, modowe, konsumpcyjne.<br>

<a href="http://nighttramparty.com/pdf/Oferta-Night-Tram-Party.pdf"><img src="http://nighttramparty.com/img/pdf2.jpg" alt="Pobierz ofertę (pdf) .."></a><br>

Dane kontaktowe w zakładce 'kontakt'.<br>Prosimy o telefon lub maila.<br><br><br>

Jesteśmy prospołeczni i ogromnie pozytywnie nastawieni<br>do organizacji ewentów dla społeczności lokalnej<br>i do wszelkich działań na rzecz społeczności lokalnej.<br>
<br>
Jesteśmy firmą wyznającą zasady społecznej odpowiedzialność biznesu.<br>Podczas organizowania imprez<br>najważniejsza dla nas jest dbałość o uczestników<br>oraz tworzenie dobrego wizerunku miasta Krakowa i dobrego wizerunku Polski.<br><br> 


Firmy i osoby zainteresowane współpracą zapraszamy do kontaktu..<br></h3>

<a href="http://nighttramparty.com/pdf/Oferta-Night-Tram-Party.pdf"><img src="http://nighttramparty.com/img/pdf2.jpg" alt="Pobierz ofertę (pdf) .."></a><br>
			
			<h1><a href="http://nighttramparty.com/pdf/Oferta-Night-Tram-Party.pdf">Pobierz ofertę (pdf) ..</a></h1>
			
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