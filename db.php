<?php

try{
    $conn = mysqli_connect(
        'localhost',
        'root',
        '',
        'payutick',
        '3308'
    );
}catch(Exception $e){
    echo "Database Not Connected".$e->getMessage();
}


?>