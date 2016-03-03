<?php
// $nameFile = date('Ymd_his').'__'.$this->Session->read('Auth.User.id').'.pdf';
header("Content-type: application/pdf charset=utf-8");
echo $content_for_layout; 

// header('Content-Disposition: attachment; filename="'.$nameFile.'"');
// echo $content_for_layout;

?>	