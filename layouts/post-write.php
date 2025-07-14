<!DOCTYPE HTML>
<html>

<?php
include_once("../includes/head.php");
include("../functions/user_session");
?>

<body>
    <div class = "logo">
        <?php include_once("../includes/nav.php"); ?>
    </div>

    <div class="container">
        <h1>글쓰기</h1>
        <button class="small orange" form="post_write" type="submit" onclick="post_write_submit()">등록</button>
    </div>

    <hr>

    <div>
        <form id="post_write_form" action="../functions/post_write_proc.php" method="POST">
            <input class="post_title" name = "title" type="text" placeholder="제목을 입력해주세요">
            <textarea class="post_content" name="substance" placeholder="내용을 입력해주세요"></textarea>
        </form>
    </div>
</body>

</html>