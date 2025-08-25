<?php
include("./sql_connect.php");

function get_pw(PDO $conn, string $uid, string $type, string $var): void {
    if (!in_array($type, ['email', 'number'])) {
        echo "<script>
        alert('잘못된 요청입니다');
        location.replace('../layouts/find-pw.php');
        </script>";
        exit;
    }

    $select_sql = "SELECT uid, {$type} FROM member WHERE uid = :uid AND {$type} = :var";
    $stmt = $conn->prepare($select_sql);
    $stmt->execute([
        ':uid' => $uid,
        ':var' => $var
    ]);

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result && $uid == $result['uid'] && $var == $result["{$type}"]) {
        session_start();
        $_SESSION['uid'] = $uid;
        header("Location: ../layouts/change-password.php");
    } else {
        echo "<script>alert('아이디 또는 {$type}이 일치하지 않습니다');</script>";
        echo "<script>location.replace('../layouts/find-pw.php');</script>";
        exit;
    }
}

// // 입력값 수집
$input_id1 = $_POST['id1'] ?? '';
$input_number = $_POST["number"] ?? '';
$input_id2 = $_POST['id2'] ?? '';
$input_email = $_POST["email"] ?? '';

// // 입력값 유효성 검사
$check1 = empty($input_id1) || empty($input_number);
$check2 = empty($input_id2) || empty($input_email);

if ($check1 && $check2) {
    echo "<script>alert('입력칸을 모두 채워주세요');</script>";
    echo "<script>location.replace('../layouts/find-pw.php');</script>";
    exit;
} else if ($check2) {
    get_pw($conn, $input_id1, 'number', $input_number);
} else if ($check1) {
    get_pw($conn, $input_id2, 'email', $input_email);
}
?>
