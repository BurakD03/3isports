<?php

namespace App\Controller;

use App\Entity\Newsletter;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{
    private ArticleRepository $articleRepo;

    public function __construct(
        ArticleRepository $articleRepo
    ) {
        $this->articleRepo = $articleRepo;
    }
    #[Route('/article/{id<\d+>}', name: 'app_article')]
    public function index($id, Request $request, EntityManagerInterface $em, ArticleRepository $articleRepo): Response
    {
        $article = $this->articleRepo->find($id);
        $newsletter = new Newsletter();

        $mailForm = $request->get('EMAIL');
        if ($mailForm != null || !empty($mailForm)) {
            $newsletter->setMail($mailForm);
            $em->persist($newsletter);
            $em->flush();
        }
        return $this->render('article/index.html.twig', [
            'controller_name' => $article->getTitre(),
            'article' => $article,
            'articleAssocier' => $articleRepo->articleAssocier($article->getSousCategorie()->getCategorie()->getId())
        ]);
    }
}