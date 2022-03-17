<?php

namespace App\Controller;

use App\Entity\Item;
use App\Entity\Owns;
use App\Entity\User;
use App\Repository\ItemRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PrinterController extends AbstractController
{
    #[Route('/items', name: 'items')]
    public function index(ItemRepository $itemRepository, EntityManagerInterface $entityManager): Response
    {
        //recupération du username de l'utilisateur courrant
        $username = $this->getUser()->getUserIdentifier();

        //récupération des items
        $items = $itemRepository->findAll();

        //récupération de l'entité user par l'username de l'utilisateur courrant
        $user = $entityManager->getRepository(User::class)->findOneBy(['username'=>$username]);
        return $this->render('printer/index.html.twig', [
            'items' => $items,
            'user' => $user,
        ]);
    }

    #[Route('/items/buy/{itemId}', name: 'buy_item')]
    public function buy_item(int $itemId, EntityManagerInterface $entityManager): Response
    {
        //récupération de l'item sélectionné avec l'id récupéré en paramètre de la fonction
        $item = $entityManager->getRepository(Item::class)->findOneBy(['id'=>$itemId]);

        //prix de cet item
        $item_price = $item->getPrice();

        //onregarde le user qui souhaite acheter
        $user = $entityManager->getRepository(User::class)->findOneBy(['username' => $this->getUser()->getUserIdentifier()]);

        //on regarde l'argent qu'a le user pour ne pas aller dans le négatif puis on enlève l'argent pour acheter l'item
        $money = $user->getMoney();
        if ($money >= $item_price) {
            $user->setMoney($money - $item_price);
            $exists = false;

            //ici on cherche à entrer dans l'entité Owns l'id de l'item, celui du user ainsi que le nombre acheté
            //Ainsi, on pourra savoir qu'est ce qui appartient à qui et en quelle quantité
            foreach ($entityManager->getRepository(Owns::class)->findAll() as $owns) {
                if ($owns->getUser() == $user and $owns->getItem() == $item) {
                    $count = $owns->getCount();
                    $owns->setCount($count + 1);
                    $exists = true;
                    $entityManager->persist($owns);
                }
            }
            if (!$exists) {
                $owns = new Owns();
                $owns->setItem($item);
                $owns->setUser($user);
                $owns->setCount(1);
                $entityManager->persist($owns);
            }

            $entityManager->persist($user);
            $entityManager->flush();
        }
        return $this->redirectToRoute('items', [], Response::HTTP_SEE_OTHER);
    }

}
