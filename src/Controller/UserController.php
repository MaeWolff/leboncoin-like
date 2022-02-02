<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Post;

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


    // TODO: rename this path to /user/{id}/edit?
    /**
     * @Route("/profile/{id}", name="app_profile")
     * @return Response
     */
    public function profile(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EditUserFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash("success", "Profil mise à jour.");

            return $this->redirectToRoute("app_profile", ['id' => $user->getId()]);
        }

        return $this->render('pages/profile.html.twig', [
            'editUserForm' => $form->createView()
        ]);
    }


    /**
     * @Route("/user/{id}/vote", name="app_user_vote")
     * @return Response
     */
    public function rating(User $user, Request $request, EntityManagerInterface $entityManager): Response
    {
        $vote = $request->request->get('vote');

        if ($vote === "up") {
            $user->upVotes();
        } else {
            $user->downVotes();
        }

        $this->addFlash("info", "Merci d'avoir évaluer un utilisateur.");
        $entityManager->flush();

        // TODO: fix redirection to current post.
        return $this->redirectToRoute("app_home");
    }
}
