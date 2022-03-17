<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    //MainController permettant d'afficher la page main lorsqu'on est sur 127.0.0.1:8000/
    #[Route('/', name: 'main')]
    public function index(UserRepository $oui): Response
    {
        return $this->render('main/index.html.twig', [
            'user' => $this->getUser(),
        ]);
    }

}