<?php

namespace App\Controller;

use App\Repository\PostRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    /**
     * @Route("/post/{id}", name="post")
     * @param string $id
     * @param PostRepository $postRepository
     * @return Response
     */
    public function postPage(string $id, PostRepository $postRepository) :Response
    {
        $post = $postRepository->find($id);
        return $this->render('pages/post.html.twig', ["post" => $post]);
    }
}
