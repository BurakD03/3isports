<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    #[Route('/test', name: 'app_test')]
    public function index(): Response
    {
        $url="https://dwh.lequipe.fr/api/edito/rss?path=/Football/";
        $crawler = new Crawler(file_get_contents($url));
        $crawler->filter('item > title')->each(function (Crawler $node, $i) {
            return $node->text();
        });
        $data = [];
        $data = $crawler->filter('item > title')->each(function (Crawler $node, $i) {
            return $node->text();
        });
        $data = $crawler->filter('item > link')->each(function (Crawler $node, $i) {
            return $node->text();
        });
        $data = $crawler->filter('item > description')->each(function (Crawler $node, $i) {
            return $node->text();
        });
        $data = $crawler->filter('item > enclosure')->each(function (Crawler $node, $i) {
            // var_dump($node->attr('url'));
            return $node->text();
        });
        // $data = $crawler->filterXPath('//item/enclosure[contains(@url,"https")]')->evaluate('substring-after(@url, "")');
        // var_dump($images);
        // var_dump($title);
        var_dump($data);
        
        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }
}
