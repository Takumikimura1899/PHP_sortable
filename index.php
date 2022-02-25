<?php

error_reporting(-1);

   require_once('./config/config.php');

   
?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>sortable</title>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script>
    <script src="js/sort.js"></script>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div id="wrapper">       
        <div id="input_form">
            <form action="./function/insert.php" method="post">
                <input type="text" name="inputName" placeholder="新メンバー名を入力">
                <?php
                $sql = 'SELECT * FROM genders';
                $stmt = $dbh->query($sql);
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($result as $val) {
                  $checked = ($val['id'] == 1) ? ' checked="checked"' : ''; //男性にチェックを入れる
                  echo '  <input type="radio" name="inputGender" value="'.$val['id'].'"' . $checked . '>'.$val['gender'].PHP_EOL;
                }
                ?>
                <input type="submit" value="登録">
            </form>
            <div id="drag-area">
                <?php 
                // $name = '木村拓光';
                // $message = 'こんにちは!';
                
                // echo $name.'さん'.$message;
                
                $sql = 'SELECT t1.*,genders.gender FROM sortable AS t1 LEFT JOIN `genders` ON t1.gender_id = genders.id';
                $stmt = $dbh->query($sql);
                // PDO::FETCH_ASSOCで(カラム名で添え字をつけた配列を返す)
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                // print_r($result) 
                foreach ($results as $result) {
                    echo ' <div class="drag gender'.$result['gender_id'].'" data-num="'.$result['id'].'" style="left:'.$result['left_x'].'px; top:'.$result['top_y'].'px;">'.PHP_EOL;
                    echo '    <p><span class="name">'.$result['id'].' '.$result['name'].'('.$result['gender'].')</span></p>'.PHP_EOL;
                    echo '  </div>'.PHP_EOL;
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>
