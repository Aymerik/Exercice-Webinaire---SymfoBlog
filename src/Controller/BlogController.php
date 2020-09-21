<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use App\Form\CommentType;
use App\Form\PostType;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    /**
     * @Route("/{page}", name="home", requirements={"page": "\d+"})
     * @param PostRepository $postRepository
     * @param int $page
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(PostRepository $postRepository, $page = 1)
    {
        // Si on essaie d'afficher une page invalide, on redirige sur la première page
        if ($page < 1) {
            return $this->redirectToRoute('home');
        }

        $posts = $postRepository->findBy([], ['publishedAt' => 'DESC'], 5, ($page - 1) * 5);

        // Si on ne récupère aucun post, on redirige sur l'accueil
        if (count($posts) === 0 && $page !== 1) {
            return $this->redirectToRoute('home');
        }

        return $this->render('blog/index.html.twig', [
            'posts' => $posts,
            'page' => $page
        ]);
    }

    /**
     * @Route("/post/{id}", name="show_post", requirements={"id": "\d+"})
     * @param Post $post
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function showPost(Post $post, Request $request, EntityManagerInterface $entityManager) {
        $comment = new Comment();

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setPublishedAt(new \DateTime());
            $comment->setPost($post);
            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute("show_post", ['id' => $post->getId()]);
        }

        return $this->render('blog/post.html.twig', [
            'post' => $post,
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/post/new", name="create_post")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function createPost(Request $request, EntityManagerInterface $entityManager)
    {
        $post = new Post();

        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post->setPublishedAt(new \DateTime());
            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirectToRoute("show_post", ['id' => $post->getId()]);
        }

        return $this->render('blog/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/post/{id}/delete", name="delete_post", requirements={"id": "\d+"})
     * @param Post $post
     * @param EntityManagerInterface $entityManager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deletePost(Post $post, EntityManagerInterface $entityManager)
    {
        $entityManager->remove($post);
        $entityManager->flush();

        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/post/{id}/edit", name="edit_post", requirements={"id": "\d+"})
     */
    public function editPost(Post $post, Request $request, EntityManagerInterface $entityManager)
    {
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute("show_post", ['id' => $post->getId()]);
        }

        return $this->render('blog/create.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
