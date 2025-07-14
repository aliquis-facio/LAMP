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
                <p>회원 탈퇴</p>
            </div>
            <form id="delete_account_form" action="../functions/delete_account_proc.php" method="post">
                <input type="password" name="pw" placeholder="비밀번호를 입력해주세요">
                <button class="red" type="button" onclick="delete_account()">탈퇴</button>
            </form>
        </div>
    </div>
</body>