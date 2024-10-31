<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(Request $request): Response
    {
        $newUser = new User();
        $form = $this->createForm(User::class, $newUser);
        $form->handleRequest($request);
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
}
