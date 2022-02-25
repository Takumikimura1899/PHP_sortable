<?php

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

if(!empty($_POST['inputName'])) {
    try{
        $sql = 'INSERT INTO sortable(name,gender_id) VALUES(:ONAMAE,:GENDER)';
        // prepare:値をデータベースに入れる準備をする
        $stmt = $dbh->prepare($sql);
        // bindParam:指定された変数名にパラメータを結びつける
        // PDO::PARAM_STR:文字列データであることを指示。
        $stmt->bindParam(':ONAMAE', $_POST['inputName'],PDO::PARAM_STR);
        $stmt->bindParam(':GENDER', $_POST['inputGender'],PDO::PARAM_INT);
        $stmt->execute();

        // リダイレクション今回はlocalhostのsortableに飛ぶようにしている
        // header('location: http://localhost:80/sortable/');
        // exit();
    } catch (PDOException $e) {
        // echo 'データベースにアクセス出来ません!'.$e->getMessage();
        echo $e->getMessage();
    }
}

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
        <div id="input_form">
            <form action="index.php" method="post">
                <input type="text" name="inputName" placeholder="新メンバー名を入力">
                <?php
                $sql = 'SELECT * FROM genders';
                $stmt = $dbh->query($sql);
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($result as $val) {
                  $checked = ($val['id'] == 1) ? ' checked="checked"' : ''; //男性にチェックを入れる
                  echo '  <input type="radio" name="inputSex" value="'.$val['id'].'"' . $checked . '>'.$val['gender'].PHP_EOL;
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
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script>
    <script>
    $(function(){
      $('.drag').draggable({       /* class="drag"が指定されている要素をdraggableに */
        containment:'#drag-area',  /* ドラッグできる範囲 */
        cursor:'move',             /* ドラッグ時のカーソル形状 */
        opacity:0.6,               /* ドラッグ中の透明度 */
        scroll:true,               /* ウィンドウ内をスクロールしたい */
        zIndex:10,                 /* ドラッグ中の重ね順を一番上に */
        /* ==========STOP処理====================================== */
        stop:function(event, ui){               /* ドラッグ終了時に起動 */
          var myNum  = $(this).data('num');     /* data-num="値" の値を取得 */
          var myLeft = (ui.offset.left - $('#drag-area').offset().left);    /* leftの座標　= 要素の座標 - #drag-areaの座標 */
          var myTop  = (ui.offset.top  - $('#drag-area').offset().top);     /* topの座標 　= 要素の座標 - #drag-areaの座標 */
          /* ==========AJAX通信================= */
        $.ajax({
            type:'POST',      /* typeパラメーター：POSTかGETか */
            url :'http://localhost:80/sortable/',  /* urlパラメーター：飛ばす先のファイル名（今回は自分に戻ってくる） */
            data: {           /* dataパラメーター：データをphpに渡す data:{ foo:'引数', bar:'引数' }　でPHP側は $_POST['foo'] で'引数'の値を受け取る */
              id  :myNum,     /* key:valueの関係、つまりidのというkeyとそれに入れる値valueはmyNumとなる */
              left:myLeft,
              top :myTop
            }
          }).done(function(){   /* ajaxの通信に成功した場合の処理 */
             console.log('成功');
          }).fail(function(XMLHttpRequest, textStatus, errorThrown){  /* ajaxの通信に失敗した場合エラー表示 */
             console.log(XMLHttpRequest.status);
             console.log(textStatus);
             console.log(errorThrown);
          });
          /* ==========/AJAX通信================= */
                console.log("左: " + myLeft);     /* x座標がとれている */
                console.log("上: " + myTop);      /* y座標がとれている */
            }
            /* ==========/STOP処理====================================== */
      });
    });
    </script>
</body>
</html>
