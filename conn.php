<?php
     $conn = mysqli_connect('localhost', 'root', '','blog') OR die('Bad connection');
     if(session_status() !== PHP_SESSION_ACTIVE) {
          session_start();
     }
?>