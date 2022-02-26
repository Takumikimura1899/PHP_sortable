<?php 
require_once('../Controller/Connect.php');
require_once('../Controller/AppController.php');

if(!empty($_POST['inputName'])) {
    try{
        $sql = 'INSERT INTO sortable(name,gender_id) VALUES(:ONAMAE,:GENDER)';
        // prepare:値をデータベースに入れる準備をする
        // $stmt = $dbh->prepare($sql);
        // bindParam:指定された変数名にパラメータを結びつける
        // PDO::PARAM_STR:文字列データであることを指示。
        // $stmt->bindParam(':ONAMAE', $_POST['inputName'],PDO::PARAM_STR);
        // $stmt->bindParam(':GENDER', $_POST['inputGender'],PDO::PARAM_INT);
        // $stmt->execute();

        $obj= new AppController();
        $obj->insert_sortable($sql,$_POST['inputName'],$_POST['inputGender']);
        // リダイレクション今回はlocalhostのsortableに飛ぶようにしている
        header('location:' .$_SERVER["HTTP_REFERER"] );
        // exit();
    } catch (PDOException $e) {
        // echo 'データベースにアクセス出来ません!'.$e->getMessage();
        echo $e->getMessage();
    }
}
