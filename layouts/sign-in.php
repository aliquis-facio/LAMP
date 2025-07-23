<!DOCTYPE html>

<?php
include_once("../includes/head.php");
?>

<body>
    <div class = "logo">
        <?php include_once("../includes/nav.php"); ?>
    </div>

    <div class = "bodyBox cyan">
        <form id="sign_in_form" action="../functions/signin_proc.php" method="POST">
            <input class = "long" name = "id" type="text" placeholder = "아이디">
            <input class = "long" name = "pw" type="password" placeholder="비밀번호">
            <button class = "long blue" type="button" onclick="sign_in_submit()">LOG IN</button>
        </form>
    </div>

    <div class = "footBox">
        <nav>
            <a href="./find-id.php">아이디 찾기</a> | 
            <a href="./find-pw.php">비밀번호 찾기</a> | 
            <a href="./sign-up.php">회원가입</a>
        </nav>
    </div>
</body>

</html>