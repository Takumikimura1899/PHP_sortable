<?php 
require_once('../config/config.php');

/* 移動したようその座標をデータベースへ登録 */
if(!empty($_POST['left'])){
    file_put_contents('log.txt','ajax空のデータが取れているか確認');
  try{
    $sql  = 'UPDATE `sortable` SET `left_x` = :LEFT, `top_y` = :TOP WHERE `id` = :NUMBER';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':LEFT'  , $_POST['left'], PDO::PARAM_INT);
    $stmt->bindParam(':TOP'   , $_POST['top'],  PDO::PARAM_INT);
    $stmt->bindParam(':NUMBER', $_POST['id'],   PDO::PARAM_INT);

    file_put_contents('log2.txt',print_r($stmt,true));

    $stmt->execute();
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
}
