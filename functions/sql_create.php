<?php
include_once("./error_report.php");
    
function sql_select($cols, $table) {
    $select_sql = "SELECT";
    $length = count($cols);
    for ($i = 0; $i < $length - 1; $i++) {
        $select_sql = $select_sql . " " . $cols[$i] . ",";
    }
    $select_sql = $select_sql . " " . $cols[$length - 1] . " FROM " . $table;
    
    return $select_sql;
}
?>