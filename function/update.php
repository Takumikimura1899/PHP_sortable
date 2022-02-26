<?php 
require_once('../Controller/Connect.php');
require_once('../Controller/AppController.php');

/* 移動したようその座標をデータベースへ登録 */
if(!empty($_POST['left'])){
    file_put_contents('log.txt','ajax空のデータが取れているか確認');
  try{
    $sql  = 'UPDATE `sortable` SET `left_x` = :LEFT, `top_y` = :TOP WHERE `id` = :NUMBER';
    $obj = new AppController();
    $obj->update_sortable($sql,$_POST['left'],$_POST['top'],$_POST['id']);
    $stmt->execute();
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
}
