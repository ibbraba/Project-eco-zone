<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Repository\QuoteRepository;
use http\Env\Request;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index(ArticleRepository $articleRepository, QuoteRepository $quoteRepository): Response
    {

        //$newarticles = $articleRepository->findOneBy(array('date'=> 'ASC'));


        //TODO Change method to findOneBy and disable loop in twig
        $lastBookReview = $articleRepository->findOneBy(array('categorie'=>'livres'), array('date'=> 'DESC'));
        $newarticles = $articleRepository->findNewArticles();

        $mainarticle = $articleRepository->find(9);

        $quote = $quoteRepository->findOneBy(array('id' => 1));

        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
            'newarticles' => $newarticles,
            'mainarticle' => $mainarticle,

            'book' => $lastBookReview,
            'quote' => $quote

        ]);
    }

    /**
     * @Route("/actualites", name="actualites")
     */
    public function actu(): Response
    {

        //TODO Make sure the trending article is not part of the list of articles


        $category = "Actualités";
        $article = $this->getDoctrine()->getRepository(Article::class);
        $list = $article->findAllbyCategory($category);
        $topArticle = $article->findOneBy(array('categorie' => $category), array("views" => "DESC"));



        return $this->render('main/actu.html.twig', [
            'controller_name' => 'MainController',
            'list'=> $list,
            'toparticle' => $topArticle,
        ]);
    }

    /**
     * @Route("/bourse", name="bourse")
     */
    public function bourse(): Response
    {
        //TODO Create a search bar to find an article
        $category = "Bourse";
        $article = $this->getDoctrine()->getRepository(Article::class);
        $list = $article->findAllbyCategory($category);

        //TODO Retrieve the most view article from each category to the top of the page with blue BG
        $topArticle = $article->findOneBy(array('categorie' => $category), array("views" => "DESC"));


        return $this->render('main/bourse.html.twig', [
            'controller_name' => 'MainController',
            'toparticle' => $topArticle,
            'list'=> $list
        ]);
    }


    /**
     * @Route("/eco", name="eco")
     */
    public function eco(): Response
    {

        $category = "Economie";
        $article = $this->getDoctrine()->getRepository(Article::class);
        $list = $article->findAllbyCategory($category);
        $topArticle = $article->findOneBy(array('categorie' => $category), array("views" => "DESC"));


        return $this->render('main/eco.html.twig', [
            'controller_name' => 'MainController',
            'list'=> $list,
            'toparticle' => $topArticle,
        ]);
    }

    /**
     * @Route("/societe", name="societe")
     */
    public function societe(): Response
    {

        $category = "Entreprises";
        $article = $this->getDoctrine()->getRepository(Article::class);
        $list = $article->findAllbyCategory($category);
        $topArticle = $article->findOneBy(array('categorie' => $category), array("views" => "DESC"));


        return $this->render('main/societe.html.twig', [
            'controller_name' => 'MainController',
            'list'=> $list,
            'toparticle' => $topArticle,
        ]);
    }



    /**
     * @Route("/livres", name="livres")
     */
    public function books(): Response
    {

        $category = "Livres";
        $article = $this->getDoctrine()->getRepository(Article::class);
        $list = $article->findAllbyCategory($category);
        $topArticle = $article->findOneBy(array('categorie' => $category), array("views" => "DESC"));


        return $this->render('main/livres.html.twig', [
            'controller_name' => 'MainController',
            'list'=> $list,
            'toparticle' => $topArticle,
        ]);
    }

}
