<?php
include_once("./user_session.php");
include_once("./sql_connect.php"); // $conn 은 PDO 객체

$post_id = $_GET['post_id'] ?? null;

if (!$post_id) {
    echo "<script>alert('잘못된 요청입니다'); history.back();</script>";
    exit;
}

try {
    // 게시글 삭제
    $delete_sql = "DELETE FROM board WHERE post_id = :post_id";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bindParam(':post_id', $post_id, PDO::PARAM_STR);
    $stmt->execute();

    echo "<script>
        alert('삭제되었습니다');
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
