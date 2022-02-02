<?php

namespace App\Controller;

use App\Repository\PostRepository;

use App\Entity\Post;
use App\Entity\Question;
use App\Form\CreatePostFormType;
use App\Form\AddQuestionFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    /**
     * @Route("/post/{id}", name="app_post", methods={"GET","POST"})
     * @param string $id
     * @param PostRepository $postRepository
     * @return Response
     */
    public function getPostPage(string $id, Request $request, PostRepository $postRepository, EntityManagerInterface $entityManager): Response
    {
        $question = new Question();
        $post = $postRepository->find($id);

        $form = $this->createForm(AddQuestionFormType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $question = $form->getData();
            $question->setAuthor($this->getUser());

            $post->addQuestion($question);

            $entityManager->persist($question);
            $entityManager->flush();
        }


        return $this->render('pages/post/index.html.twig', [
            "addQuestionForm" => $form->createView(),
            "post" => $post
        ]);
    }


    /**
     * @Route("add-post", name="app_add_post", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function addPost(Request $request, EntityManagerInterface $entityManager): Response
    {
        $post = new Post();

        $form = $this->createForm(CreatePostFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();

            $post->setAuthor($this->getUser());
            $post->setCreatedAt(new \DateTime);

            $entityManager->persist($post);
            $entityManager->flush();
            return $this->redirectToRoute("app_home");
        }

        $this->addFlash('success', 'Votre annonce a bien été publiée !');

        return $this->render('pages/post/add.html.twig', [
            "addPostForm" => $form->createView(),
        ]);
    }

    /**
     * @Route("/post/{id}/edit", name="app_edit_post")
     */
    public function editPost(Request $request, EntityManagerInterface $entityManager, Post $post): Response
    {
        $form = $this->createForm(CreatePostFormType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();

            $entityManager->persist($post);
            $entityManager->flush();

            $this->addFlash("success", "Annonce mise à jour.");

            return $this->redirectToRoute("app_post", ['id' => $post->getId()]);
        }

        return $this->render('pages/post/edit.html.twig', [
            'editPostForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/delete/{id}", name="app_delete_post")
     */
    public function deletePost(EntityManagerInterface $entityManager, PostRepository $postRepository, Post $post): Response
    {
        $post = $postRepository->find($post->getId());
        $entityManager->remove($post);
        $entityManager->flush();

        $this->addFlash('success', 'Votre annonce a bien été supprimée !');

        return $this->redirectToRoute('app_home');
    }
}
