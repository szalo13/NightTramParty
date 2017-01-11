<?php
    session_start();
    require_once "functions.php";

    if (isAdmin()) {
        require_once "connect.php";
        
        $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
        
        if($polaczenie->connect_errno!=0)
        {
            echo "Error: " . $polaczenie->connect_errno;
        }
        else 
        {
            $dbName = 'history';
            $result = getAllHistory($polaczenie, $dbName);
            
            $row = $result->fetch_assoc();
        }
    }

?>

<?php 
    require_once "html_header.php";  
?>

<body>
    <?php 
        require_once "adminNav.php";
    ?>
    
    <div class="sz-section">
        <div class="container text-center">
            <?php
                printHistory($result);
            ?>
        </div>
    </div>
</body>