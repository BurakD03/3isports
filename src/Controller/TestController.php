<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\DomCrawler\Crawler;

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
        $data = $crawler->filter('enclosure')->each(function (Crawler $node, $i) {
            // var_dump($node->attr('url'));
            // var_dump($node->text());
            return $node->attr('url');
        });
        $test = [];
        $test = $crawler->filter('item')->each(function (Crawler $node, $i) {
            $test['titre'] = $node->filter('title')->text();
            // $test['description'] = $node->filter('description')->text('Default text content', false);
            // var_dump($node->filterXPath('//item/description')->text('Default text content', false));
            $test['description'] = $this->after('>', $node->filter('description')->text());
            // $test['description'] = $this->forward('App\Controller\TestController::between', [
            //     'string' => $node->filter('description')->text(),
            //     ''
            // ];
            $test['auteur'] = $node->filterXPath('//dc:creator')->text();
            $test['category'] = $node->filter('category')->text();
            $test['datePublication'] = $node->filter('pubDate')->text();
            $test['link'] = $node->filter('guid')->text();
            return $test;
        });
        // var_dump($test);
        // $data = $crawler->filterXPath('//item/enclosure[contains(@url,"https")]')->evaluate('substring-after(@url, "")');
        // var_dump($images);
        // var_dump($title);
        // var_dump($data);

        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
            'data'            => $data,
            'test'            => $test
        ]);
    }

    public function before($string, $inthat)
    {
        return substr($inthat, 0, strpos($inthat, $string));
    }

    public function after($string, $inthat)
    {
        if (!is_bool(strpos($inthat, $string))) {
            return substr($inthat, strpos($inthat, $string)+strlen($string));
        }
    }

    public function between($string, $that, $inthat)
    {
        return $this->before($that, $this->after($string, $inthat));
    }
}