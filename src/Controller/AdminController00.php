<?php

namespace App\Controller;

use App\Entity\Item;
use App\Entity\User;
use App\Repository\ItemRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController00 extends AbstractController
{

    //AdminController est utilisé pour les fonctions d'administration

    //Ici, nous affichons les users et les items avec findAll()(Repository)
    #[Route('/admin', name: 'admin')]
    public function admin(EntityManagerInterface $entityManager): Response
    {
        $users = $entityManager->getRepository(User::class)->findAll();
        $items = $entityManager->getRepository(Item::class)->findAll();

        return $this->render('admin/index.html.twig', [
            'users' => $users,
            'items' => $items
        ]);
    }

    //Fonction de delete d'un user
    #[Route('/admin/delete/{id}', name: 'user_delete')]
    public function deleteUser(int $id, EntityManagerInterface $entityManager): Response
    {
        //On va chercher l'id du user sur lequel on clique
        $user = $entityManager->getRepository(User::class)->findOneBy(['id'=>$id]);

        //on le remove de la base de donnée
        $entityManager->remove($user);
        $entityManager->flush();

        //on reload la page
        return $this->redirectToRoute('admin', [], Response::HTTP_SEE_OTHER);
    }

    //Ici, on fait la même chose avec un item
    #[Route('/admin/delete/item/{id}', name: 'item_delete')]
    public function deleteItem(int $id, EntityManagerInterface $entityManager): Response
    {
        $item = $entityManager->getRepository(Item::class)->findOneBy(['id'=>$id]);
        $entityManager->remove($item);
        $entityManager->flush();
        return $this->redirectToRoute('admin', [], Response::HTTP_SEE_OTHER);
    }

    //Fonction pour ajouter de l'argent sur le compte de qqu (fonction peu utile mais marrante)
    #[Route('/admin/user_add_money/{id}', name: 'user_add_money')]
    public function userAddMoney(int $id, EntityManagerInterface $entityManager): Response
    {
        $add = $entityManager->getRepository(User::class)->findOneBy(['id'=>$id]);
        $money = $add->getMoney();
        $add->setMoney($money += 100);
        $entityManager->flush();
        return $this->redirectToRoute('admin', [], Response::HTTP_SEE_OTHER);
    }

    //Celle-ci fait l'inverse puisqu'ell enlève de l'argent
    #[Route('/admin/user_remove_money/{id}', name: 'user_remove_money')]
    public function userRemoveMoney(int $id, EntityManagerInterface $entityManager): Response
    {
        $user = $entityManager->getRepository(User::class)->findOneBy(['id'=>$id]);
        $money = $user->getMoney();
        $user->setMoney($money -= 100);
        $entityManager->flush();
        return $this->redirectToRoute('admin', [], Response::HTTP_SEE_OTHER);
    }

    //Cette fonction permet de promote un utilisateur vers admin
    #[Route('/admin/promote/{id}', name: 'promote')]
    public function promote(int $id, EntityManagerInterface $entityManager): Response
    {
        //On récupère l'utilisateur sur lequel on clique
        $user = $entityManager->getRepository(User::class)->findOneBy(['id'=>$id]);

        //on va chercher son role
        $role = $user->getRoles();

        //Si ce n'est pas un admin on lui donne
        if ($role != ['ROLE_ADMIN']){
            $roles = 'ROLE_ADMIN';
            $user->setRoles([$roles]);
        }

        $entityManager->flush();
        return $this->redirectToRoute('admin', [], Response::HTTP_SEE_OTHER);
    }

    //Cette fonction permet de demote un utilisateur vers user de la même manière que le promote car une array vide est un 'ROLE_USER'
    #[Route('/admin/demote/{id}', name: 'demote')]
    public function demote(int $id, EntityManagerInterface $entityManager): Response
    {
        $user = $entityManager->getRepository(User::class)->findOneBy(['id'=>$id]);
        $user->setRoles([]);
        $entityManager->flush();
        return $this->redirectToRoute('admin', [], Response::HTTP_SEE_OTHER);
    }

}
