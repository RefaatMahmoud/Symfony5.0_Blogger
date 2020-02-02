<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Service\FileUploader;
use App\Service\PDF;
use Symfony\Bridge\Twig\Extension\AssetExtension;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/post", name="post.")
 */
class PostController extends AbstractController
{

    /**
     * @var FileUploader
     */
    private $file_uploader;

    public function __construct(FileUploader $file_uploader)
    {
        $this->file_uploader = $file_uploader;
    }

    /**
     * @Route("", name="index")
     */
    public function index()
    {
        $posts = $this->getDoctrine()->getRepository(Post::class)->findAll();
        $posts_count = $this->getDoctrine()->getRepository(Post::class)->countPosts();
        return $this->render('posts/index.html.twig', [
            'posts'       => $posts,
            'posts_count' => $posts_count
        ]);
    }

    /**
     * @Route("/create", name="create")
     */
    public function create(Request $request)
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $this->submitPostForm($post, $form);
            $this->addFlash('success', 'Post Added Successfully');
            return $this->redirect($this->generateUrl('post.index'));
        }

        return $this->render('posts/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/show/{id}", name="show")
     */
    public function show(Post $post)
    {
        return $this->render('posts/show.html.twig', [
            'post' => $post
        ]);
    }

    /**
     * @Route("/edit/{id}", name="edit")
     */
    public function edit(Request $request, Post $post)
    {
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $this->submitPostForm($post, $form);
            $this->addFlash('success', 'Post Updated Successfully');
            return $this->redirect($this->generateUrl('post.index'));
        }
        return $this->render('posts/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("delete/{id}", name="delete")
     */
    public function delete(Post $post)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($post);
        $em->flush();
        $this->addFlash('success', 'Post Deleted Successfully');
        // return $this->redirect($this->generateUrl('post.index'));
        return $this->redirectToRoute('post.index');
    }

    /**
     * @Route("/print/{id}", name="print")
     */
    public function print(Post $post, PDF $pdf)
    {
        $html = $this->renderView('posts/pdf.html.twig', [
            'post' => $post
        ]);
        return $pdf->getPrint($html);
    }

    private function submitPostForm(Post $post, FormInterface $form): void
    {
        $file = $form['img']->getData();
        if ($file) {
            $file_name = $this->file_uploader->upload($file);
            $post->setImg($file_name);
        }
        $em = $this->getDoctrine()->getManager();
        $em->persist($post);
        $em->flush();
    }
}
