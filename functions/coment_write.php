<?php
include_once("./sql_connect.php"); // $conn 은 PDO 객체
include_once("./user_session.php");

// 파라미터 준비
$writer = $_SESSION['user_id'] ?? null;
$reply = htmlspecialchars($_POST["reply"]) ?? null;
$post_id = $_POST["post_id"] ?? null;

date_default_timezone_set('Asia/Seoul');
$created_date = (new DateTime("now"))->format('Y-m-d H:i:s');
$coment_id = hash('sha256', $writer . $created_date);

// 필수값 검증
if (!$writer || !$reply || !$post_id) {
    echo "<script>
        alert('입력값이 누락되었습니다');
        history.back();
    </script>";
    exit;
}

try {
    // INSERT 쿼리 실행
    $insert_sql = "INSERT INTO coment (coment_id, post_id, created_date, writer, reply)
                   VALUES (:coment_id, :post_id, :created_date, :writer, :reply)";
    
    $stmt = $conn->prepare($insert_sql);
    $stmt->execute([
        ':coment_id' => $coment_id,
        ':post_id' => $post_id,
        ':created_date' => $created_date,
        ':writer' => $writer,
        ':reply' => $reply
    ]);

    echo "<script>
        alert('등록되었습니다');
        location.replace('../post_view.php?post_id={$post_id}');
    </script>";

} catch (PDOException $e) {
    echo "<script>
        alert('DB 오류가 발생했습니다');
        history.back();
    </script>";
    // 개발 중이라면 로그: error_log($e->getMessage());
    exit;
}
?>
