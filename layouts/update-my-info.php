<!DOCTYPE HTML>
<html>

<?php
include_once("../includes/head.php");
include_once("../functions/user_session.php");
include_once("../functions/sql_connect.php");
?>

<body>
    <div class="container">
        <div class="head_box">
            <?php include_once("../includes/nav.php"); ?>
            
            <h1>내 정보</h1>
        </div>
                    
        <div class="body_box">
            <div>
                <p>개인정보 변경</p>
                <p>변경하지 않을 시 공란으로 두시면 됩니다</p>
                <?php
                try {
                    $select_sql = "SELECT * FROM `member` WHERE id = ?";
                    $stmt = $pdo->prepare($select_sql);
                    $stmt->execute([$user_id]);
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($row) {
                        $name = htmlspecialchars($row['name']);
                        $number = htmlspecialchars($row['number']);
                        $birth = htmlspecialchars($row['birth']);
                        $email = htmlspecialchars($row['email']);

                        echo "
                        <form id='update_form' action='../functions/update_my_information_proc.php' method='post'>
                            <div>
                                <p>이름: <input type='text' name='new_name' placeholder=\"{$name}\"></p>
                            </div>
                            <div>
                                <p>전화번호: <input type='text' name='new_number' placeholder=\"{$number}\"></p>
                                <p>생년월일: <input type='text' name='new_birth' placeholder=\"{$birth}\"></p>
                            </div>
                            <div>
                                <p>이메일: <input type='text' name='new_email' placeholder=\"{$email}\"></p>
                            </div>
                            <div>
                                <p>현재 비밀번호: <input id='pw_input' type='password' name='input_curr_pw'></p>
                                <p>새로운 비밀번호: <input id='new_pw_input' type='password' name='new_pw'></p>
                                <p>새로운 비밀번호 확인: <input id='new_pw_confirm_input' type='password' name='new_pw_confirm'></p>
                            </div>
                            <button class='red' type='button' onclick='update_my_inform_submit()'>변경</button>
                        </form>";
                    } else {
                        echo "<script>alert('회원 정보를 불러올 수 없습니다.'); history.back();</script>";
                    }
                } catch (PDOException $e) {
                    echo "<script>alert('오류가 발생했습니다.'); history.back();</script>";
                }
                ?>
            </div>
        </div>
    </div>
</body>
