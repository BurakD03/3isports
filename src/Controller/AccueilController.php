<?php

namespace App\Controller;

use App\Repository\AccueilRepository;
use App\Repository\ArticleRepository;
use App\Repository\CategorieRepository;
use Symfony\Component\DomCrawler\Crawler;
use App\Repository\SousCategorieRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class AccueilController extends AbstractController
{
    #[Route('/', name: 'app_page_accueil')]
    public function index(CategorieRepository $categRepo, ArticleRepository $articleRepo, Request $request, AccueilRepository $accueilRepo): Response
    {
        $gridArticle= $accueilRepo->gridArticles();
        $categorie = $categRepo->findAll();
        $categorieLifestyle = $categRepo->findBy(['libelleCategorie'=> 'Life Style']);
        // ARTICLE LIFE STYLE
        $categorieCuisines = $categRepo->findBy(['libelleCategorie'=> 'Cuisines']);
        $articlesCuisines = $articleRepo->findByCategorie($categorieCuisines[0]->getId());
        // ARTICLE TECH
        $categorieTech = $categRepo->findBy(['libelleCategorie'=> 'Tech']);
        $articlesTech= $articleRepo->findByCategorie4($categorieTech[0]->getId());
        // ARTICLE SANTE
        $categorieSante = $categRepo->findBy(['libelleCategorie'=> 'Santé']);
        $articlesSante= $articleRepo->findByCategorie4($categorieSante[0]->getId());
        // ARTICLE JEUX
        $categorieJeux = $categRepo->findBy(['libelleCategorie'=> 'Jeux vidéo']);
        $articlesJeux= $articleRepo->findByCategorie4($categorieJeux[0]->getId());
        $filtreCategorie = $request->get('categ');
        if ($filtreCategorie === null) {
            $filtreCategorie = $categorie[0]->getId();
        }
        $category = $categRepo->find($filtreCategorie);
        $articlesParCategorie = $articleRepo->findByCategorie($category->getId());
        $DernierArticles = $articleRepo->last6Article();
        $articleLifestyle = $articleRepo->articleLifestyle($categorieLifestyle[0]->getId());
        // dd($articleLifestyle);
        if ($request->get('ajax')) {
            return  new JsonResponse([
                'content' => $this->renderView('page_accueil/__blockNews.html.twig', [
                    'controller_name' => 'PageAccueilController',
                    'categories'     => $categorie,
                    'newsCategories' => $articlesParCategorie,
                ])
            ]);
        }

        return $this->render('page_accueil/index.html.twig', [
            'controller_name' => 'PageAccueilController',
            'categories'     => $categorie,
            'newsCategories' => $articlesParCategorie,
            'newsCuisines'=> $articlesCuisines,
            'newsTech' => $articlesTech,
            'newsSante' => $articlesSante,
            'newsJeux' => $articlesJeux,
            'recentArticles' => $DernierArticles,
            'articleLifestyle' => $articleLifestyle,
            'gridArticle'    => $gridArticle,
            'last6ArticleCateg' => $articleRepo->last6ArticleEachCategorie(),
        ]);
    }
}