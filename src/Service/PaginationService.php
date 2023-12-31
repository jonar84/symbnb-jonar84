<?php

namespace App\Service;

use Twig\Environment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class PaginationService {
    private $entityClass;
    private $limit = 10;
    private $currentPage = 1;
    private $manager;
    private $twig;
    private $route;

    public function __construct(EntityManagerInterface $manager, Environment $twig, RequestStack $request)
    {
        $this->route = $request->getCurrentRequest()->attributes->get('_route');
        $this->manager = $manager;
        $this->twig = $twig;
    }

    public function setRoute($route)
    {
        $this->route = $route;
        return $this->route;
    }

    public function getRoute()
    {
        return $this->route;
    }

    public function display()
    {
        $this->twig->display('admin/partials/pagination.html.twig', [
            'page' => $this->currentPage,
            'pages' => $this->getpages(),
            'route' => $this->route
        ]);
    }

    public function getPages()
    {
        if (empty($this->entityClass)) {
            throw new \Exception("Vous n'avez pas spécifié l'entité");
        }
        // 1) Connaitre le total des enregistrements de la table
        $repo = $this->manager->getRepository($this->entityClass);
        $total = count($repo->findAll());
        // 2) Faire la division, l'arrondir et le renvoyer
        $pages = ceil($total / $this->limit);

        return $pages;
    }
 
    public function getData()
    {
        if (empty($this->entityClass))
        {
            throw new \Exception("Vous n'avez pas spécifié l'entité");
        }
        // 1) Calculer l'offset 
        $offset = $this->currentPage * $this->limit - $this->limit;
        // 2) Demander au repository de trouver les elements
        $repo = $this->manager->getRepository($this->entityClass);
        $data = $repo->findBy([], [], $this->limit, $offset);

        // 3) Renvoyer les elements en question
        return $data;
    }

    public function setPage($page)
    {
        $this->currentPage = $page;

        return $this; 
    }

    public function getPage()
    {
        return $this->currentPage;
    }

    public function setLimit($limit)
    {
        $this->limit = $limit;
        return $this;
    }

    public function getLimit()
    {
        return $this->limit;
    }

    public function setEntityClass($entityClass) 
    {
        $this->entityClass = $entityClass;
        return $this;
    }

    public function getEntityClass($entityClass) 
    {
        return $this->entityClass;
    }
}