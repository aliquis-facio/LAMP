<!DOCTYPE HTML>
<html>

<?php
    include_once("../includes/head.php");
    include_once("../functions/sql_connect.php");

    session_start();
    $uid = $_SESSION['uid'];
    session_destroy();
?>

<body>
    <div class="container">
        <div class="head_box">
            <?php include_once("../includes/nav.php"); ?>
            <h1>비밀번호 변경</h1>
        </div>
        
        <div class="body_box">
            <div>
                <form method="post" action="/change_password.php">
                    <input type="password" name="pw" required minlength="8" />
                    <input type="hidden" name="csrf_token" value="<?php 
                        $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); 
                        echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES); 
                    ?>">
                    <button type="submit">변경</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
