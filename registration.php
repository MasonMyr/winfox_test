<?php
class operations
{
    public function sqlConnect()
    {
        $cfg = require_once('config.php');
        $conn = new mysqli($cfg['host'], $cfg['username'], $cfg['password']);
        if ($conn->connect_error) {
            die("Ошибка соединения");
        }
        $sql = "CREATE DATABASE IF NOT EXISTS winfoxtest";
        if ($conn->query($sql) === TRUE) {
            $conn->close();
            $pdo = new PDO(
                'mysql:host=' . $cfg['host'] . ';
                dbname=' . $cfg['db'] . '',
                $cfg['username'],
                $cfg['password']
            );
            $pdo->query("CREATE TABLE IF NOT EXISTS users ( `id` INT NOT NULL AUTO_INCREMENT , `fname` VARCHAR(25) NOT NULL , `sname` VARCHAR(25) NOT NULL , `email` VARCHAR(25) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB; ");
            return $pdo;
        }
    }

    public function addRecord($pdo)
    {
        $fname = $_POST['fname'];
        $sname = $_POST['sname'];
        $email = $_POST['email'];
        $check = $pdo->query("SELECT `email` FROM `users` WHERE `email` = '$email'");
        $num = $check->fetchColumn();
        if ($num != 0) {
            echo "Email занят";
            exit();
        }else{
            $pdo -> query("INSERT INTO `users` (`fname`, `sname`, `email`) VALUES ('$fname', '$sname', '$email');");
        }
    }
}

$operations = new operations();
$connect = $operations ->sqlConnect();
$operations -> addRecord($connect);
