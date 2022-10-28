<?php

namespace App\Controller;

use App\Entity\Newsletter;
use App\Repository\ArticleRepository;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategorieController extends AbstractController
{
    #[Route('/categorie/{id<\d+>}', name: 'app_categorie')]
    public function index($id, Request $request, CategorieRepository $categRepo, EntityManagerInterface $em, ArticleRepository $articleRepo): Response
    {
        $categorie = $categRepo->find($id);
        // dd($articleRepo->findAllArticleCategorie($categorie->getId()));
        $newsletter = new Newsletter();

        $mailForm = $request->get('EMAIL');
        if ($mailForm != null || !empty($mailForm)) {
            $newsletter->setMail($mailForm);
            $em->persist($newsletter);
            $em->flush();
        }
        return $this->render('categorie/index.html.twig', [
            'controller_name' => $categorie->getLibelleCategorie(),
            'articleCategorie' => $articleRepo->findAllArticleCategorie($categorie->getId()),
        ]);
    }
}