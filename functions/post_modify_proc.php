<?php
include_once("./error_report.php");
include_once("./sql_connect.php"); // $conn은 PDO 객체

if (!session_id()) {
    session_start();
}

$user = $_SESSION['user_id'] ?? null;
$title = $_POST["title"] ?? '';
$substance = $_POST["substance"] ?? '';
$post_id = $_POST["post_id"] ?? '';

date_default_timezone_set('Asia/Seoul');
$modified_date = (new DateTime("now"))->format('Y-m-d H:i:s');

// 유효성 검사
if (!$user || !$title || !$substance || !$post_id) {
    echo "<script>alert('입력값이 누락되었습니다'); history.back();</script>";
    exit;
}

try {
    // 게시글 업데이트
    $update_sql = "UPDATE board 
                   SET title = :title, substance = :substance, created_date = :created_date 
                   WHERE post_id = :post_id";

    $stmt = $conn->prepare($update_sql);
    $stmt->execute([
        ':title' => $title,
        ':substance' => $substance,
        ':created_date' => $modified_date,
        ':post_id' => $post_id
    ]);

    echo "<script>
        alert('수정되었습니다');
        location.replace('../index.php');
    </script>";

} catch (PDOException $e) {
    echo "<script>
        alert('DB 오류가 발생했습니다');
        history.back();
    </script>";
    // error_log($e->getMessage());
    exit;
}
?>
