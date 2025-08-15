<?php
if(!session_id()) {
    session_start();
}

if(!isset($_SESSION['uid'])) {
    echo "<script>location.replace('../layouts/sign-in.php');</script>";
} else {
    // UID를 난수화해서 UID를 통해서 사용자의 id랑 이름을 가져오는 게 낫지 않을까?
    $uid = $_SESSION['uid'];
}
?>