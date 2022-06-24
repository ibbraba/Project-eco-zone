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
     * TODO Write legl mentions for footer
     */
    public function index(ArticleRepository $articleRepository, QuoteRepository $quoteRepository): Response
    {

       // $newarticles = $articleRepository->findOneBy(null ,array('date'=> 'DESC'));



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
        $category = "Actualités";
        $article = $this->getDoctrine()->getRepository(Article::class);
        $list = $article->findAllbyCategory($category);
        $topArticle = $article->findOneBy(array('categorie' => $category), array("views" => "DESC"));
        $route="actualites";


        return $this->render('main/actu.html.twig', [
            'controller_name' => 'MainController',
            'list'=> $list,
            'toparticle' => $topArticle,
            'route' => $route,
            "categorie" => $category
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
        $topArticle = $article->findOneBy(array('categorie' => $category), array("views" => "DESC"));
        $route="bourse";

        return $this->render('main/bourse.html.twig', [
            'controller_name' => 'MainController',
            'toparticle' => $topArticle,
            'list'=> $list,
            "route"=> $route,
            "categorie" => $category
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
        $route="eco";

        return $this->render('main/eco.html.twig', [
            'controller_name' => 'MainController',
            'list'=> $list,
            'toparticle' => $topArticle,
            "route"=> $route,
            "categorie" => $category
        ]);
    }

    /**
     * @Route("/societe", name="societe")
     */
    public function societe(): Response
    {

        $route="societe";
        $category = "Entreprises";
        $article = $this->getDoctrine()->getRepository(Article::class);
        $list = $article->findAllbyCategory($category);
        $topArticle = $article->findOneBy(array('categorie' => $category), array("views" => "DESC"));

        return $this->render('main/societe.html.twig', [
            'controller_name' => 'MainController',
            'list'=> $list,
            'toparticle' => $topArticle,
            'route'=> $route,
            "categorie" => $category
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
        $route="livres";

        return $this->render('main/livres.html.twig', [
            'controller_name' => 'MainController',
            'list'=> $list,
            'toparticle' => $topArticle,
            "route"=> $route,
            "categorie" => $category
        ]);
    }

    /**
     * @Route("/mentions", name="mentions")
     */
    public function mentions():Response {
        return $this->render("main/mentions.html.twig");
    }

    /**
     * @Route("/politique-confidentialite", name="politique")
     */
    public function politique():Response {

    return $this->render("main/politique.html.twig");

    }
}
