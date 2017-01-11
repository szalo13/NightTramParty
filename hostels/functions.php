<?php
function isAdmin() {
    //Jesli uzytkownik nie jest zalogowany odsyla go do index.php
    if ((!isset($_SESSION['zalogowany'])) || (!$_SESSION['permissions'] == 1))
    {   
        header('Location: index.php');
    }
    else 
    {
        return 1;
    }
}

//Updatuje historie zakupu, podczas sprzedazy
function updateHistory($dbConnection,$soldTickets, $currentDate, $currentTime, $buyerName, $hostelName, $partyId){
    
    $sql = "INSERT INTO `history`
    (
    `id`,
    `tickets`,
    `date`,
    `time`,
    `buyerName`,
    `hostelName`,
    `partyId`
    ) 
    
    VALUES 
    ('',
    '".$soldTickets."',
    '".$currentDate."',
    '".$currentTime."',
    '".$buyerName."',
    '".$hostelName."',
    '".$partyId."')";
    
    $dbConnection->query($sql);
}

//Pobiera wszystkie elementy tablicy segregujac po dacie malejaco, z danej bazy $dbName
function getAllByDateDesc($dbConnection, $dbName)
{
    $sql = "SELECT * FROM `".$dbName."` WHERE (date <=CURRENT_DATE()) ORDER BY date DESC";
    
    $result = $dbConnection->query($sql);
    
    return $result;
}

//Pobiera historie zakupow - hostel, nazwe kupujacego, date i czas imprezy a nastepnie zegreguje po dacie i czasie
function getAllHistory($dbConnection)
{
    $sql = "SELECT history.tickets, history.buyerName, history.hostelName, events.name, events.date, events.time FROM history INNER JOIN events ON events.id=history.partyId ORDER BY history.date, history.time DESC";
    
    $result = $dbConnection->query($sql);
    
    return $result; 
}
//Pobiera rezultat zwrocony przez baze danych, tworzy tablice asocjacyjna i wypisuje wyniki w postaci tabeli
function printHistory($result){
    echo "<table class='table'>";
        echo "<thead>
                    <tr>
                        <th>Hostel</th>
                        <th>Imię kupującego</th>
                        <th>Nazwa imprezy</th>
                        <th>Data Imprezy</th>
                        <th>Godzina Imprezy</th>
                        <th>Ilość biletów</th>
                    </tr>
                </thead>
                ";
        echo "<tbody>";

        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                
                echo "<tr>";
                    echo "<td>". $row['hostelName'] ."</td>";
                    echo "<td>". $row['buyerName'] ."</td>";
                    echo "<td>". $row['name'] ."</td>";
                    echo "<td>". $row['date'] ."</td>";
                    echo "<td>". $row['time'] ."</td>";
                    echo "<td>". $row['tickets'] ."</td>";
                echo "</tr>";
            }
        }
        echo "</tbody>";
        echo "</table>";
    
}








?>