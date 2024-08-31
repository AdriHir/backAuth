<?php

namespace App\Repository;
use App\Entity\Annonce;
use App\Entity\User;

class AnnonceRepository{


    public function persist(Annonce $annonce) {
        $connection = database::connect();
        $query = $connection->prepare('INSERT INTO annonce (title,description,price,user_id) VALUES(:title,:descritpion,:price,:annonce_userId)');
        $query->bindValue(':title', $annonce->getTitle());
        $query->bindValue(':description', $annonce->getDescription());
        $query->bindValue(':price',$annonce->getPrice());
        $query->bindValue(':annonce_userId', $annonce->getUser()->getId());
        $query->execute();
        $annonce->setId($connection->lastInsertId());
    }


}
