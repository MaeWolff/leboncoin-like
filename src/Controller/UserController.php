<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Entity\User;

use App\Form\UserRegisterFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

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

    /**
     * @Route("/register}", name="register")
     * @return Response
     */
    public function register(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User();
        $form = $this->createForm(UserRegisterFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $passwordHasher->hashPassword($user, $user->getPassword());
            $user->setPassword($hash);

            // NOTE: initialize user votes to 0.
            $user->setVotes(0);


            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute("login");
        }

        return $this->render('pages/register.html.twig', [
            'registrationForm' => $form->createView()
        ]);
    }
}
