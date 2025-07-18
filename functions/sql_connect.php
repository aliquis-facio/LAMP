<?php
// DB 설정 상수
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'admin');
define('DB_PASSWORD', 'admin');
define('DB_NAME', 'NotOK');

$dsn = 'mysql:host=' . DB_SERVER . ';dbname=' . DB_NAME . ';charset=utf8mb4';

try {
    $conn = new PDO($dsn, DB_USERNAME, DB_PASSWORD, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,         // 예외 기반 에러 처리
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,    // fetch 결과는 연관배열
        PDO::ATTR_EMULATE_PREPARES => false                  // prepare는 실제로 서버에서 처리
    ]);
} catch (PDOException $e) {
    die('DB 연결 실패: ' . $e->getMessage());
}
?>
