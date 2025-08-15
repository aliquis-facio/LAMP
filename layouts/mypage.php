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
                <p>기본 정보</p>
                <?php
                try {
                    $select_sql = "SELECT * FROM member WHERE uid = :uid";
                    $stmt = $conn->prepare($select_sql);
                    $stmt->execute([':uid' => $uid]);
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($row) {
                        echo "<div>
                                <p>이름: " . htmlspecialchars($row['name']) . "</p>
                                <p>ID: " . htmlspecialchars($row['uid']) . "</p>
                              </div>
                              <div>
                                <p>전화번호: " . htmlspecialchars($row['number']) . "</p>
                                <p>생년월일: " . htmlspecialchars($row['birth']) . "</p>
                              </div>
                              <div>
                                <p>이메일: " . htmlspecialchars($row['email']) . "</p>
                              </div>";
                    } else {
                        echo "<p>회원 정보를 불러올 수 없습니다.</p>";
                    }
                } catch (PDOException $e) {
                    echo "<p>DB 오류 발생: " . htmlspecialchars($e->getMessage()) . "</p>";
                }
                ?>
            </div>
        </div>

        <div class="foot_box">
            <p><a href="./update-my-info.php">개인정보 변경</a></p>
            <p><a href="./delete-account.php">회원탈퇴</a></p>
        </div>
    </div>
</body>
</html>
