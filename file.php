<html>
<head>
</head>
<body>
<former action="" >
<input type="text" placeholder="账号" name="username" />
<input type="password" placeholder="内容" name="pass" />
</former>
</body>
</html>


<?php
/**
  *your os file dirname
  *date 2021.11.10
  **
  */
  
if ($_POST['pass']==null||$_POST['username']==null){
exit;
}

class File{

public $New_Filename = '';




}

$this = new File();

for ($i=0;$i<10;$i++){
echo '<br/>';
echo $this->New_Filename=dirname(__FILE__);
}
  