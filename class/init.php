<?php
try {
        $database = new PDO('mysql:host=localhost;dbname=delimovie', 'root', 'root');
      } catch(PDOExeption $e) {
        die('Site indisponible');
      }

      ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
?>