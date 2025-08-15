<?php
include_once("./error_report.php");
include_once("./sql_connect.php"); // $conn은 PDO 객체
include_once("./user_session.php");

$cid = $_GET['cid'] ?? null;
$pid = $_GET['pid'] ?? null;

if (!$cid || !$pid) {
    die("잘못된 요청입니다.");
}

try {
    // 댓글 삭제 쿼리 실행
    $delete_sql = "DELETE FROM coment WHERE cid = :cid";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bindParam(':cid', $cid, PDO::PARAM_STR);
    $stmt->execute();

    echo "<script>alert('삭제되었습니다');</script>";
    header("Location: ../layouts/post-view.php?pid={$pid}");
    exit;
} catch (PDOException $e) {
    echo "DB 오류: " . $e->getMessage();
    exit;
}
?>
