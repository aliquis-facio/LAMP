<!DOCTYPE HTML>
<html>

<?php
include_once("../includes/head.php");
include("../functions/user_session.php");
include("../functions/sql_connect.php");

$user_id = $_SESSION['user_id'];
$post_id = $_GET['post_id'];

$select_sql = "SELECT * FROM board WHERE post_id = ?";
$stmt->prepare($select_sql);
$stmt->bind_param('s', $post_id);
$stmt->execute();
$ret = $stmt->get_result();

if ($ret) {
    $row = $ret->fetch_assoc();
    
    $title = $row['title'];
    $substance = $row['substance'];
} else {
    echo "<script>alert('오류가 발생했습니다');</script>";
}
?>

<body>
    <div class = "logo">
        <?php include_once("../includes/nav.php"); ?>
    </div>

    <div>
        <h1>수정하기</h1>
        <button form = "post_modify" class = "orange" onclick="post_modify_submit()">등록</button>
        <hr>
    </div>

    <div>
        <form id="post_modify_form" action="../functions/post_modify_proc.php" method="post">
            <?php
                echo "<input id = 'title_modify_input' class='post_title' type='text' name='title' value = '{$title}'>
                <textarea class='post_substance' name='substance'>{$substance}</textarea>
                <input type='hidden' name='post_id' value='$post_id'>";
            ?>
        </form>
    </div>

    <div>
        <a href="./index.php">뒤로 가기</a>
    </div>
</body>

</html>