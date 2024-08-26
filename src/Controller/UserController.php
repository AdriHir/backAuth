<?php

namespace App\Controller;
use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;

#[Route('/api')]
class UserController extends AbstractController {

    public function __construct(private UserRepository $repo) {}


    #[Route('/register',methods:'POST')]

    public function register(
        #[MapRequestPayload] User $user,
        UserPasswordHasherInterface $hasher){
            //On vérifie s'il y a déjà un user avec ce meme email
            if($this->repo->findByEmail($user->getEmail()) != null){
                //Si oui, on arrête là, et on envoie une erreur
                return $this->json('User already exists', 400);
            }
            //On hash le mot de passe en utilisant l'algorithme défini dans le security.yaml
            $hashedPassword = $hasher->hashPassword($user, $user->getPassword());
            //On assigne au user le mot de passe hashé pour le stocker
            $user->setMdp($hashedPassword);
            //On assigne un role par défaut à notre user
            $user->setRole('ROLE_USER');
            //On fait persister le user dans la bdd
            $this->repo->persist($user);
            //On renvoie une réponse de succés
            return $this->json($user, 201);

    }
    #[Route('/login', methods:'POST')]
    public function login(
        #[MapRequestPayload] User $user,
        UserPasswordHasherInterface $hasher,
        JWTTokenManagerInterface $token
    ) {
        $stored = $this->repo->findByEmail($user->getEmail());
    
   
        if (!$hasher->isPasswordValid($stored,$user->getMdp())) {
            return $this->json('Mot de passe incorrect', 401);
        }
    
        $token = $token->create($user);
    
        return $this->json(['token' => $token]);
    }
   


         
}

