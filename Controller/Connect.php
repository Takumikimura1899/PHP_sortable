<?php 
// データベースに接続するクラス
class Connect{
    // プロパティ(定数)の宣言
    const DB_NAME = 'cri_sortable';
    const HOST = 'localhost';
    const UTF = 'utf8';
    const USER = 'root';
    const PASS = 'root';

    // データベースに接続するメソッド(関数)
    public function pdo(){
        $dsn = "mysql:host=".self::HOST.";dbname=".self::DB_NAME. "; charset=".self::UTF;
        $user = self::USER;
        $pass = self::PASS;
        try{
            $pdo = new PDO($dsn, $user, $pass);
        }catch(Exception $e) {
            echo 'エラー'.$e->getMessage;
            die();
        } 
        return $pdo;
    }
}

// SELECT文の時に使用するクラス
class SelectData extends Connect
{
    // プロパティ(変数)の宣言
    private $sql;

    // データベースい接続してテーブルデータを取得するメソッド(関数)
    public function select($sql) {
        $items = $this->pdo()->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        return $items;
    }
}
