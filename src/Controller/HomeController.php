<?php

namespace App\Controller;

use App\Repository\CategoriesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategoriesRepositoryRepository;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(CategoriesRepository $categoriesRepository): Response
    {
//        dd($categoriesRepository->findAll());
        return $this->render('base.html.twig', [
            'controller_name' => 'HomeController',
            'cat' => $categoriesRepository->findAll()
        ]);
    }
}
