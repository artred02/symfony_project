<?php

namespace App\Controller;

use App\Entity\Item;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ItemFormType;

class ItemFormController extends AbstractController
{

    //ItemFormController est permet d'ajouter un item en base de donnée
    #[Route('/item/form', name: 'item_form')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        //On crée un nouvel item dans une variable
        $item = new Item();

        //On fait un createForm pour l'item
        $form = $this->createForm(ItemFormType::class, $item);
        $form->handleRequest($request);


        //Vérification pour savoir si le form est envoyé et validé
        if ($form->isSubmitted() && $form->isValid()){
            //On le persist
            $entityManager->persist($item);
            $entityManager->flush();

            //redirection vers les items
            return $this->redirect($this->generateUrl('items'));
        }

        //un render vers la view où l'on va l'utiliser
        return $this->render('item_form/index.html.twig', [
            'form' => $form->createView()
        ]);

    }

}

