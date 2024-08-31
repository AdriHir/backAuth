<?php

namespace App\Controller;
use App\Entity\Annonce;
use App\Entity\User;
use App\Repository\AnnonceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api')]
class AnnonceController extends AbstractController {

    public function __construct(private AnnonceRepository $repo) {}


    #[Route('/annonce',methods:'POST')]

    public function register(
        #[MapRequestPayload] User $user,
        #[MapRequestPayload] Annonce $annonce){
            $annonce->setUser($user->getId());            
            $this->repo->persist($annonce);
            //On renvoie une réponse de succés
            return $this->json($user, 201);

    }
        
}

