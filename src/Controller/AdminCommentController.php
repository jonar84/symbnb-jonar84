<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\AdminCommentType;
use App\Repository\CommentRepository;
use App\Service\PaginationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminCommentController extends AbstractController
{
    /**
     * Afficher la liste des commentaires
     * @Route("/admin/comments/{page<\d+>?1}", name="admin_comment_index")
     */
    public function index(PaginationService $pagination, $page, CommentRepository $repo): Response
    {
        $pagination->setEntityClass(Comment::class)
                   ->setPage($page);

        return $this->render('admin/comment/index.html.twig', [
            'pagination' => $pagination
        ]);
    }

    /**
     * Permet de modifier un commentaire
     * @Route("/admin/comments/{id}/edit", name="admin_comment_edit")
     */
    public function edit(Comment $comment, Request $request, EntityManagerInterface $manager) 
    {
        $form = $this->createForm(AdminCommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($comment);
            $manager->flush();

            $this->addFlash(
                'success',
                "Le commentaire a éte corrigé"
            );
        }
 
        return $this->render('admin/comment/edit.html.twig', [
            'comment' =>$comment,
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet de supprimer un commentaire
     * @Route("/admin/comments/{id}/delete", name="admin_comment_delete")
     */
    public function delete(Comment $comment, EntityManagerInterface $manager) 
    {
        $manager->remove($comment);
        $manager->flush();

        $this->addFlash(
            'success',
            "Le commentaire a éte supprimée"
        );

        return $this->redirectToRoute('admin_comment_index');
    }
}
