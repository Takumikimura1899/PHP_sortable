<?php 

class AppController extends Connect
{
    // 座標を登録
    public function update_sortable($sql,$left,$top,$id) {
        $stmt = $this->pdo()->prepare($sql);
        $stmt->bindValue(':LEFT',$left,PDO::PARAM_INT);
        $stmt->bindValue(':TOP',$top,PDO::PARAM_INT);
        $stmt->bindValue(':NUMBER',$id,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    // 新規登録
    public function insert_sortable($sql,$name,$gender){
        $stmt = $this->pdo()->prepare($sql);
        $stmt->bindValue(':ONAMAE',$name,PDO::PARAM_STR);
        $stmt->bindValue(':GENDER',$gender,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }
}
