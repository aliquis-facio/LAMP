<?php
    //sql 서버 연결
    define('DB_SERVER', 'localhost');
    define('DB_USERNAME', 'admin');
    define('DB_PASSWORD', 'admin');
    define('DB_NAME', 'NotOK');

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    $stmt = $conn->stmt_init();

    if ($conn->connect_error) {
        die($conn->connect_error);
    }
?>