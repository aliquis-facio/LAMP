<?php
include_once("./error_report.php");
include_once("./sql_connect.php"); // $conn은 PDO 객체

if (!session_id()) {
    session_start();
}

$user = $_SESSION['uid'] ?? null;
$title = $_POST["title"] ?? '';
$content = $_POST["content"] ?? '';
$pid = $_POST["pid"] ?? '';

date_default_timezone_set('Asia/Seoul');
$modifiedDate = (new DateTime("now"))->format('Y-m-d H:i:s');

// 유효성 검사
if (!$user || !$title || !$content || !$pid) {
    echo "<script>alert('입력값이 누락되었습니다'); history.back();</script>";
    exit;
}

try {
    // 게시글 업데이트
    $update_sql = "UPDATE board 
                   SET title = :title, content = :content, createdDate = :createdDate 
                   WHERE pid = :pid";

    $stmt = $conn->prepare($update_sql);
    $stmt->execute([
        ':title' => $title,
        ':content' => $content,
        ':createdDate' => $modifiedDate,
        ':pid' => $pid
    ]);
    echo "<script>alert('수정되었습니다');</script>";
    header("Location: ../layouts/post-view.php?pid={$pid}");
} catch (PDOException $e) {
    echo "<script>
        alert('오류가 발생했습니다');
        history.back();
    </script>";
    // error_log($e->getMessage());
    exit;
}
?>
