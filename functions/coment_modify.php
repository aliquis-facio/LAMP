<?php
include_once("./sql_connect.php"); // $conn은 PDO 객체
include_once("./user_session.php");

// 파라미터 설정
date_default_timezone_set('Asia/Seoul');
$created_date = (new DateTime("now"))->format('Y-m-d H:i:s');
$reply = $_POST["reply"] ?? null;
$cid = $_POST["cid"] ?? null;
$pid = $_POST["pid"] ?? null;

// 기본 파라미터 체크
if (!$reply || !$cid || !$pid) {
    echo "<script>
        alert('입력값이 누락되었습니다.');
        history.back();
    </script>";
    exit;
}

try {
    // 댓글 업데이트
    $update_sql = "UPDATE coment SET reply = :reply, createdDate = :createdDate WHERE cid = :cid";
    $stmt = $conn->prepare($update_sql);
    $stmt->execute([
        ':reply' => $reply,
        ':createdDate' => $created_date,
        ':cid' => $cid
    ]);

    echo "<script>
        alert('수정되었습니다');
        location.replace('../layouts/post-view.php?pid={$pid}');
    </script>";

} catch (PDOException $e) {
    echo "<script>
        alert('DB 오류가 발생했습니다');
        history.back();
    </script>";
    // 개발 중일 경우: echo "Error: " . $e->getMessage();
    exit;
}
?>
