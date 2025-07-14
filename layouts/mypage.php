<!DOCTYPE HTML>
<html>

<?php
    include_once("../includes/head.php");
    include_once("../functions/user_session.php");
    include_once("../functions/sql_connect.php");
?>

<body>
    <div class="container">
        <div class = "head_box">
            <?php include_once("../includes/nav.php"); ?>
            
            <h1>내 정보</h1>
        </div>
                    
        <div class="body_box">
            <div>
                <p>기본 정보</p>
                <?php
                    $select_sql = "SELECT * FROM `member` WHERE id=?";
                    $stmt = $conn->prepare($select_sql);
                    $stmt->bind_param('s', $user_id);
                    $stmt->execute();
                    $ret = $stmt->get_result();
                    $row = $ret->fetch_assoc();

                    echo "<div>
                        <p>이름: {$row['name']}</p>
                        <p>ID: {$row['id']}</p>
                    </div>
                    <div>
                        <p>전화번호: {$row['number']}</p>
                        <p>생년월일: {$row['birth']}</p>
                    </div>
                    <div>
                        <p>이메일: {$row['email']}</p>
                    </div>";
                ?>
            </div>
        </div>

        <div class="foot_box">
            <p><a href="./update-my-info.php">개인정보 변경</a></p>
            <p><a href="./delete-account.php">회원탈퇴</a></p>
        </div>
    </div>
</body>