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
            <h1>아이디 찾기</h1>
            <h3>아이디 찾는 방법을 선택해 주세요.</h3>

            <div>
                <input id="check-btn-number" type="checkbox">
                <label for="check-btn-number">회원정보에 등록한 휴대전화로 인증</label>
                <div class="number-container">
                    <h6>회원정보에 등록한 휴대전화 번호와 입력한 휴대전화 번호가 같아야, 아이디를 받을 수 있습니다.</h6>
                    <form action="../functions/find_id_proc.php" method="post">
                        <input class = "long" name = "name1" type="text" placeholder="이름">
                        <input class = "long" name = "number" type="text" placeholder="휴대전화번호">
                        <button class = "long blue">휴대전화로 인증</button>
                    </form>
                </div>
            </div>

            <div>
                <input id="check-btn-email" type="checkbox">
                <label for="check-btn-email">본인확인 이메일로 인증</label>
                <div class="email-container">
                    <h6>본인확인 이메일 주소와 입력한 이메일 주소가 같아야, 아이디를 받을 수 있습니다.</h6>
                    <form action="../functions/find_id_proc.php" method="post">
                        <input name="name2" type="text" placeholder="이름">
                        <input name="email" type="text" placeholder="이메일 주소">
                        <button class = "long blue">이메일로 인증</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>