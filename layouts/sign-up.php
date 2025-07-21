<!DOCTYPE html>

<?php
include_once("../includes/head.php");
?>

<body>
    <div class = 'container'>
        <div class = "logo">
            <?php include_once("../includes/nav.php"); ?>
        </div>
    
        <div class = "bodyBox cyan">
            <form id="sign_up_form" action="../functions/signup_proc.php" method="POST">
                <input class = "long" name = "id" type="text" placeholder = "ID">
                <input class = "long" name = "pw" type="password" placeholder="PW">
                <input class = "long" name = "email" type="text" placeholder="example@example.com">
                <input class = "long" name = "name" type="text" placeholder="Name">
                <input class = "long" name = "birth" type="date" placeholder="Birth: 0000-00-00">
                <input class = "long" name = "number" type="text" placeholder="01012345678">
                <button class = "long blue" type="button" onclick="sign_up_submit()">REGIST</button>
            </form>
        </div>
    </div>
</body>

</html>