<?php

namespace App\Controller;

use App\Repository\PostRepository;

use App\Entity\Post;
use App\Form\CreatePostFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    /**
     * @Route("/post/{id}", name="post")
     * @param string $id
     * @param PostRepository $postRepository
     * @return Response
     */
    public function getPostPage(string $id, PostRepository $postRepository): Response
    {
        $post = $postRepository->find($id);
        return $this->render('pages/post.html.twig', ["post" => $post]);
    }


    /**
     * @Route("new-post", name="add_post", methods={"GET","POST"})
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
            return $this->redirectToRoute("home");
        }

        return $this->render('pages/new-post.html.twig', [
            "addPostForm" => $form->createView(),
        ]);
    }
}
