<?php
include_once("./user_session.php");
include_once("./sql_connect.php"); // $conn은 PDO 객체

$input_pw = hash('sha512', $_POST['pw'] ?? '');
$uid = $_SESSION['uid'] ?? null;

if (!$uid || !$input_pw) {
    echo "<script>alert('잘못된 접근입니다'); history.back();</script>";
    exit;
}

try {
    // 1. 사용자 비밀번호 가져오기
    $select_sql = "SELECT pw FROM member WHERE uid = :uid";
    $stmt = $conn->prepare($select_sql);
    $stmt->bindParam(':uid', $uid);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $db_pw = $row['pw'] ?? null;

    if (!$db_pw || $db_pw !== $input_pw) {
        echo "<script>
            alert('비밀번호가 일치하지 않습니다');
            history.back();
        </script>";
        exit;
    }

    // 2. 계정 삭제
    $delete_sql = "DELETE FROM member WHERE uid = :uid";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bindParam(':uid', $uid);
    $stmt->execute();

    // 3. 세션 해제 및 리디렉션
    session_destroy();
    echo "<script>
        alert('계정이 삭제되었습니다');
        location.replace('/layouts/sign-in.php');
    </script>";

} catch (PDOException $e) {
    echo "<script>
    alert('오류가 발생했습니다');
    history.back();
    </script>";
    // error_log($e->getMessage()); // 디버깅 로그
    exit;
}
?>
