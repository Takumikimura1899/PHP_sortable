<?php

use LDAP\Result;

    error_reporting(-1);
    
    /* データベース設定 */
    define('DB_DNS', 'mysql:host=localhost; dbname=cri_sortable; charset=utf8');
    define('DB_USER', 'root');
    // define('DB_PASSWORD', 'root');
    
    /* データベースへ接続 */
    try {
    //   $dbh = new PDO(DB_DNS, DB_USER, DB_PASSWORD);
      $dbh = new PDO(DB_DNS, DB_USER,);
      $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    } catch (PDOException $e){
        echo $e->getMessage();
        exit;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>sortable</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div id="wrapper">
        <div id="drag-area">
            <?php 
            $name = '木村拓光';
            $message = 'こんにちは!';

            echo $name.'さん'.$message;

            $sql = 'SELECT * FROM sortable';
            $stmt = $dbh->query($sql);
            // PDO::FETCH_ASSOCで(カラム名で添え字をつけた配列を返す)
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // print_r($result) 
            foreach ($results as $result) {
                echo ' <div class="drag" data-num="'.$result['id'].'" style="left:'.$result['left_x'].'px; top:'.$result['top_y'].'px;">'.PHP_EOL;
                echo '    <p><span class="name">'.$result['id'].' '.$result['name'].'</span></p>'.PHP_EOL;
                echo '  </div>'.PHP_EOL;
            }
            ?>

            
        </div>
    </div>
</body>
</html>
