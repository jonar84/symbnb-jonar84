<?php

namespace App\Controller;

use App\Entity\Info;
use App\Form\InfoType;
use App\Repository\InfoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index(InfoRepository $inforepo): Response
    {
        return $this->render('blog/index.html.twig', [
            'infos' => $inforepo->findthreeLastinfo()
        ]);
    }

    /**
     * Permet d'ajouter des informations
     * @Route("/admin/addinfo", name="add_blog")
     * @IsGranted("ROLE_ADMIN")
     * 
     */
    public function addInfo(Request $request, EntityManagerInterface $manager)
    {
        $info = new Info();
        $form = $this->createForm(InfoType::class, $info);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $info->setUser($this->getUser());
            $manager->persist($info);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'info' a bien ete ajoutée. Merci!"
            );

            return $this->redirectToRoute("blog");
        }

        return $this->render('admin/blog/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
