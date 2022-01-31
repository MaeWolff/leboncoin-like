<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Form\EditUserFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class UserController extends AbstractController
{
    /**
     * @Route("/user/{id}", name="app_user")
     * @param string $id
     * @param UserRepository $postRepository
     * @return Response
     */
    public function getUserPage(string $id, UserRepository $userRepository): Response
    {
        $user = $userRepository->find($id);
        return $this->render('pages/user.html.twig', ["user" => $user]);
    }

    /**
     * @Route("/profile", name="app_profile")
     * @return Response
     */
    public function profile(Request $request, EntityManagerInterface $entityManager): Response
    {
        $loggedUser = $this->getUser();


        $form = $this->createForm(EditUserFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash("success", "Profil mise à jour");

            return $this->redirectToRoute("profile");
        }

        return $this->render('pages/profile.html.twig', [
            'editUserForm' => $form->createView()
        ]);
    }
}
