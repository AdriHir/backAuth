<?php

namespace App\Repository;
use App\Entity\User;

class UserRepository {


    public function persist(User $user) {
        $connection = database::connect();
        $query = $connection->prepare('INSERT INTO user (email,mdp,role) VALUES(:email,:mdp,:role)');
        $query->bindValue(':email', $user->getEmail());
        $query->bindValue(':mdp', $user->getMdp());
        $query->bindValue(':role', $user->getRole());
        $query->execute();
        $user->setId($connection->lastInsertId());
    }
    public function findByEmail(string $email): ?User {
        $connection = database::connect();
        $query = $connection->prepare('SELECT * FROM user WHERE email=:email');
        $query->bindValue(':email', $email);
        $query->execute();

        if($line = $query->fetch()) {
            $user = new User();
            $user->setRole($line['role']);
            $user->setEmail($line['email']);
            $user->setMdp($line['mdp']);
            $user->setId($line['userId']);
            return $user;
        }
        return null;
    }

}
