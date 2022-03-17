<?php

namespace App\Security;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;

class AccessDeniedHandler extends AbstractController implements AccessDeniedHandlerInterface
{

    //redirection en cas d'un access denied + surprise
    public function handle(Request $request, AccessDeniedException $accessDeniedException): ?Response
    {
        $user=$this->getUser();
        if ($user) return $this->redirect('https://ia804606.us.archive.org/27/items/rick-rolled-short-version/Rick%20Rolled%20%28Short%20Version%29.mp4');
        return $this->redirectToRoute('app_login');

    }
}
