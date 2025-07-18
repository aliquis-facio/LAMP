<?php
include_once("./user_session.php");
include_once("./sql_connect.php"); // $conn은 PDO 객체

try {
    // 현재 유저 정보 가져오기
    $select_sql = "SELECT * FROM member WHERE id = :id";
    $stmt = $conn->prepare($select_sql);
    $stmt->execute([':id' => $user_id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        throw new Exception("사용자 정보를 찾을 수 없습니다.");
    }

    $id = $row['id'];
    $curr_pw = $row['pw'];
    $curr_name = $row['name'];
    $curr_birth = $row['birth'];
    $curr_email = $row['email'];
    $curr_number = $row['number'];

    // 입력값 처리 (입력 없으면 기존 값 유지)
    $new_name = $_POST['new_name'] ?: $curr_name;
    $new_number = $_POST['new_number'] ?: $curr_number;
    $new_email = $_POST['new_email'] ?: $curr_email;
    $new_birth = $_POST['new_birth'] ?: $curr_birth;

    $input_curr_pw = hash('sha512', $_POST['input_curr_pw'] ?? '');
    $new_pw = empty($_POST['new_pw']) ? $curr_pw : hash('sha512', $_POST['new_pw']);

    // 비밀번호 확인
    if ($input_curr_pw !== $curr_pw) {
        echo "<script>
            alert('비밀번호를 잘못 입력하셨습니다!');
            history.back();
        </script>";
        exit;
    }

    // 사용자 정보 업데이트
    $update_sql = "UPDATE member 
                   SET name = :name, birth = :birth, number = :number, email = :email, pw = :pw 
                   WHERE id = :id";

    $stmt = $conn->prepare($update_sql);
    $stmt->execute([
        ':name' => $new_name,
        ':birth' => $new_birth,
        ':number' => $new_number,
        ':email' => $new_email,
        ':pw' => $new_pw,
        ':id' => $id
    ]);

    echo "<script>
        alert('개인정보 변경이 완료되었습니다!');
        location.href = '../mypage.php';
    </script>";
    exit;

} catch (Exception $e) {
    echo "<script>
        alert('오류가 발생했습니다: {$e->getMessage()}');
        history.back();
    </script>";
    // 개발 중에는 아래 로깅 권장
    // error_log($e->getMessage());
    exit;
}
?>
