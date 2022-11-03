<?php

try{
    $conn = mysqli_connect(
        'us-cdbr-east-06.cleardb.net',
        'b2489e226b3862',
        'e62bbca9',
        'heroku_c3ecbb00261dad7'
    );
}catch(Exception $e){
    echo "Database Not Connected".$e->getMessage();
}


?>