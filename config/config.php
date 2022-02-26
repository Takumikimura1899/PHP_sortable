<?php 
    /* データベース設定 */
    define('DB_DNS', 'mysql:host=localhost; dbname=cri_sortable; charset=utf8');
    define('DB_USER', 'root');
    // define('DB_PASSWORD', 'root');
    
    /* データベースへ接続 */
    try {
    //   $dbh = new PDO(DB_DNS, DB_USER, DB_PASSWORD);
      $dbh = new PDO(DB_DNS, DB_USER);
      $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    } catch (PDOException $e){
        echo $e->getMessage();
        exit;
} 
