<!DOCTYPE html>

<?php
include_once("../includes/head.php");
?>

<body>
    <div class="container">
        <div class = "logo">
            <?php include_once("../includes/nav.php"); ?>
        </div>
    
        <div class = "bodyBox cyan">
            <h1>비밀번호 찾기</h1>
            <h3>비밀번호 찾는 방법을 선택해 주세요.</h3>

            <div>
                <input class = "long" id="check-btn-number" type="checkbox">
                <label for="check-btn-number">회원정보에 등록한 휴대전화로 인증</label>
                <div class="number-container">
                    <form action="../functions/find_pw_proc.php" method="post">
                        <input class = "long" name="id1" type="text" placeholder="비밀번호를 찾고자하는 아이디를 입력해주세요.">
                        <input class = "long" name="number" type="text" placeholder="휴대전화번호">
                        <button class = "long blue" type="submit">휴대전화로 인증</button>
                    </form>
                </div>
            </div>

            <div>
                <input class = "long" id="check-btn-email" type="checkbox">
                <label for="check-btn-email">본인확인 이메일로 인증</label>
                <div class="email-container">
                    <form action="../functions/find_pw_proc.php" method="post">
                        <input class = "long" name="id2" type="text" placeholder="비밀번호를 찾고자하는 아이디를 입력해주세요.">
                        <input class = "long" name="email" type="text" placeholder="이메일 주소">
                        <button class = "long blue" type="submit">이메일로 인증</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>