<?php

namespace App\Repository;
use App\Entity\Annonce;
use App\Entity\User;

class AnnonceRepository{
    public function findAll():array {
        $connection = Database::connect();
        $query = $connection->prepare('SELECT annonce.*, user.email FROM annonce INNER JOIN user ON userId=annonce.user_id');
        $query->execute();
        $list= [];
        foreach($query->fetchAll() as $line) {
            $user = new User();
            $user->setId($line['user_id']);
            $user->setEmail($line['email']);
            $annonce = new Annonce();
            $annonce->setId($line['userId']);
            $annonce->setTitle($line['title']);
            $annonce->setDescription($line['description']);
            $annonce->setPrice($line['price']);
            $annonce->setUser($user);
            $list[] = $annonce;
        }
        return $list;
    }

    public function findById(int $id):?Annonce {
        $connection = Database::connect();
        $query = $connection->prepare('SELECT annonce.*, user.email FROM annonce INNER JOIN user ON user.id=annonce.user_id WHERE annonce.id=:id');
        $query->bindValue(':id', $id);
        $query->execute();
        
        if($line = $query->fetch()) {
            $user = new User();
            $user->setId($line['user_id']);
            $user->setEmail($line['email']);
            $annonce = new Annonce();
            $annonce->setId($line['userId']);
            $annonce->setTitle($line['title']);
            $annonce->setDescription($line['description']);
            $annonce->setPrice($line['price']);
            $annonce->setUser($user);
            return $annonce;
        }
        return null;
    }

    public function persist(Annonce $annonce) {
        $connection = database::connect();
        $query = $connection->prepare('INSERT INTO annonce (title,description,price,user_id) VALUES(:title,:description,:price,:annonce_userId)');
        $query->bindValue(':title', $annonce->getTitle());
        $query->bindValue(':description', $annonce->getDescription());
        $query->bindValue(':price',$annonce->getPrice());
        $query->bindValue(':annonce_userId', $annonce->getUser()->getId());
        $query->execute();
        $annonce->setId($connection->lastInsertId());
    }
    
    public function remove(int $id) {
        $connection = Database::connect();
        $query = $connection->prepare('DELETE FROM annonce WHERE id=:id');
        $query->bindValue(':id', $id);
        $query->execute();
    }
               
}


