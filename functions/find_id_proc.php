<?php
include("./user_session.php");
include("./sql_connect.php"); // $conn = PDO 객체로 가정

function get_id(PDO $conn, string $name, string $type, string $var): void {
    // $type은 email 또는 number 중 하나
    if (!in_array($type, ['email', 'number'])) {
        echo "<script>alert('잘못된 요청입니다'); location.replace('../find_id.php');</script>";
        exit;
    }

    $select_sql = "SELECT name, {$type}, id FROM member WHERE name = :name AND {$type} = :var";
    $stmt = $conn->prepare($select_sql);
    $stmt->execute([
        ':name' => $name,
        ':var' => $var
    ]);

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result && isset($result['id'])) {
        $found_id = htmlspecialchars($result['id'], ENT_QUOTES, 'UTF-8');
        echo "<script>alert('당신의 아이디는 {$found_id}입니다.');</script>";
        echo "<script>location.replace('../index.php');</script>";
    } else {
        echo "<script>alert('이름 혹은 {$type}을 잘못 입력하셨습니다');</script>";
        echo "<script>location.replace('../find_id.php');</script>";
        exit;
    }
}

// 입력값 받기
$input_name1 = $_POST["name1"] ?? null;
$input_number = $_POST["number"] ?? null;
$input_name2 = $_POST["name2"] ?? null;
$input_email = $_POST["email"] ?? null;

// 입력값 체크
$check1 = empty($input_name1) || empty($input_number);
$check2 = empty($input_name2) || empty($input_email);

if ($check1 && $check2) {
    echo "<script>alert('입력값을 모두 채워주세요.');</script>";
    echo "<script>location.replace('../find_id.php');</script>";
    exit;
} else if ($check2) {
    get_id($conn, $input_name1, 'number', $input_number);
} else if ($check1) {
    get_id($conn, $input_name2, 'email', $input_email);
}

// PDO는 명시적으로 close할 필요 없음
?>
