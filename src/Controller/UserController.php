<?php

namespace App\Controller;

use App\Repository\UserRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
   /**
     * @Route("/user/{id}", name="user")
     * @param string $id
     * @param UserRepository $postRepository
     * @return Response
     */
    public function getUserPage(string $id, UserRepository $userRepository): Response
    {
        $user = $userRepository->find($id);
        return $this->render('pages/user.html.twig', ["user" => $user]);
    }
}
