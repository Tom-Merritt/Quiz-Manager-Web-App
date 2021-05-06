<?php
//Connect To Database
$connect_db = mysqli_connect('localhost', 'root', '', 'quiz-manager');

//Check Database Connection
if(!$connect_db){
    echo 'Connection Error: '. mysqli_connect_error();
}
?>
