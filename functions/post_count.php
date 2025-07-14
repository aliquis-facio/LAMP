<?php
$select_sql = "SELECT board_id FROM board WHERE writer = '{$writer}'";
$result = mysqli_query($conn, $select_sql);
if ($result) {
    $cnt = mysqli_num_rows($result);
} else $cnt = 0;
?>