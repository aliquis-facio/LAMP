<?php
// 엄격한 타입 체크 모드 활성화: 정확한 유형의 변수만 허용
declare(strict_types=1);

if(!session_id()) { // 세션이 없을 경우
    session_start(); // 세션 실행
}

// 세션에 uid 저장
if(!isset($_SESSION['uid'])) {
    http_response_code(401); // 클라이언트가 인증되지 않았거나, 유효한 인증 정보가 부족해 요청이 거부됨
    exit('로그인이 필요합니다');
} else {
     $uid = $_SESSION['uid'];
}

// DB 설정 상수
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'admin');
define('DB_PASSWORD', 'student1234');
define('DB_NAME', 'LAMP');

$dsn = 'mysql:host=' . DB_SERVER . ';dbname=' . DB_NAME . ';charset=utf8mb4';

try {
    $conn = new PDO($dsn, DB_USERNAME, DB_PASSWORD, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,         // 예외 기반 에러 처리
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,    // fetch 결과는 연관배열
        PDO::ATTR_EMULATE_PREPARES => false                  // prepare는 실제로 서버에서 처리
    ]);
} catch (PDOException $e) {
    exit('DB 연결 실패');
}
?>