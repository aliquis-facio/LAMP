<?php
declare(strict_types=1);
require_once __DIR__ . '/sql_connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Method Not Allowed');
}

# 입력값
$pw = $_POST['pw'];
$uid = $_POST['uid'];

// 비밀번호 해시
$hash = password_hash($pw, PASSWORD_DEFAULT);

try {
    // PDO 에러모드가 예외인지 확인 (sql_connect.php에서 설정하는 것을 권장)
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = 'UPDATE member SET pw = :pw, updated_at = NOW() WHERE uid = :uid';
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':pw'  => $hash,
        ':uid' => $uid,
    ]);

    if ($stmt->rowCount() === 0) {
        // uid가 없거나 내용 동일(같은 해시)일 수 있음
        // 굳이 자세한 이유를 사용자에게 노출하지 않음
        $_SESSION['flash'] = '변경사항이 없거나 계정을 찾을 수 없습니다.';
    } else {
        $_SESSION['flash'] = '비밀번호가 변경되었습니다.';
    }

    // CSRF 토큰 1회용
    unset($_SESSION['csrf_token']);

    // 안전한 리다이렉트
    header('Location: ./sign-in.php');
    exit;

} catch (PDOException $e) {
    http_response_code(500);
    // 상세 에러는 로그로만 남기고, 사용자에게는 일반 메시지
    error_log('DB Error (password update): ' . $e->getMessage());
    exit('서버 오류가 발생했습니다. 잠시 후 다시 시도해주세요.');
}
?>