<?php

namespace App\Controller;

use App\Entity\Newsletter;
use App\Repository\AuteurRepository;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AuteurController extends AbstractController
{
    #[Route('/auteur/{id<\d+>}', name: 'app_auteur')]
    public function index($id, AuteurRepository $auteurRepo, EntityManagerInterface $em, Request $request, ArticleRepository $articleRepo): Response
    {
        $auteur = $auteurRepo->find($id);
        $articleAuteurs = $articleRepo->findAllAuteurArticle($auteur->getId());
        $newsletter = new Newsletter();

        $mailForm = $request->get('EMAIL');
        if ($mailForm != null || !empty($mailForm)) {
            $newsletter->setMail($mailForm);
            $em->persist($newsletter);
            $em->flush();
        }
        // dd($articleAuteurs);
        return $this->render('auteur/index.html.twig', [
            'controller_name' => $auteur->getNickname(),
            'articleAuteurs' => $articleAuteurs
        ]);
    }
}