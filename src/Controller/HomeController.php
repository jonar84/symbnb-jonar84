<?php

namespace App\Controller;

use App\Repository\AdRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController{

    /**
     * @Route("/", name="homepage")
     */
    public function home(AdRepository $adRepo, UserRepository $userRepo) {
        $prenom = ["Lior", "Josephine", "Abou"];
        return $this->render(
            'home.html.twig', [
                'ads' => $adRepo->findBestAds(3),
                'users' => $userRepo->findBestUsers(3)    
            ]
        );
    }
}
