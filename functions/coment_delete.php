<?php
include_once("./error_report.php");
include_once("./sql_connect.php"); // $conn은 PDO 객체
include_once("./user_session.php");

$coment_id = $_GET['coment_id'] ?? null;
$post_id = $_GET['post_id'] ?? null;

if (!$coment_id || !$post_id) {
    die("잘못된 요청입니다.");
}

try {
    // 댓글 삭제 쿼리 실행
    $delete_sql = "DELETE FROM coment WHERE coment_id = :coment_id";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bindParam(':coment_id', $coment_id, PDO::PARAM_STR);
    $stmt->execute();

    echo "<script>alert('삭제되었습니다');</script>";
    header("Location: ../post_view.php?post_id={$post_id}");
    exit;
} catch (PDOException $e) {
    echo "DB 오류: " . $e->getMessage();
    exit;
}
?>
