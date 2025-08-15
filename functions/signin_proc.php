<?php
include_once("./sql_connect.php"); // $conn은 PDO 객체

if (!session_id()) {
    session_start();
}

$uid = $_POST["uid"];
$pw = hash('sha512', $_POST["pw"]);

try {
    $select_sql = "SELECT * FROM member WHERE uid = :uid";
    $stmt = $conn->prepare($select_sql);
    $stmt->bindParam(':uid', $uid);
    $stmt->execute();

    $ret = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($ret && $ret['pw'] === $pw) {
        // 로그인 성공
        $_SESSION['uid'] = $ret['uid'];
        header("Location: ../layouts/index.php");
        exit;
    } else {
        // 로그인 실패
        echo "<script>alert('로그인 오류');</script>";
        echo "<script>location.href = '../layouts/sign-in.php';</script>";
        exit;
    }

} catch (PDOException $e) {
    // 예외 처리
    echo "DB 오류: " . $e->getMessage();
    exit;
}
?>
