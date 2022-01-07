<?php


class Article {
    public function fetchAll(){
global $pdo;

$query = $pdo->prepare("SELECT * FROM artikkelit");
$query->execute();

return $query->fetch(PDO::FETCH_ASSOC);
     
    }
    public function fetch_data($article_id){
        global $pdo;
            
            $query = $pdo->prepare("SELECT * FROM artikkelit WHERE article_id= ?");
            $query->bindValue(1, $article_id);
    
            $query->execute();
            
            return $query->fetch(PDO::FETCH_ASSOC);
            
         
    }
}

?>