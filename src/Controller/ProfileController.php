<?php

namespace App\Controller;

use App\Entity\Item;
use App\Entity\Owns;
use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'profile')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        //ici, nous récupéront l'utilisateur courant ainsi que les liaisons vers les items qu'il possède
        $user = $entityManager->getRepository(User::class)->findOneBy(['username' => $this->getUser()->getUserIdentifier()]);
        $owns = $entityManager->getRepository(Owns::class)->findBy(['user' => $user]);

        //On render les variables afin de les utiliser dans la view
        return $this->render('profile/index.html.twig', [
            'user' => $user,
            'owns' => $owns,
        ]);
    }
}
