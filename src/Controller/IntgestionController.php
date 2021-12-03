<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Quote;
use App\Form\QuoteType;
use App\Repository\ArticleRepository;
use App\Form\ArticleType;
use App\Repository\QuoteRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;
use Twig\Error\Error;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


/**
 * @Route("/intgestion")
 * Require ROLE_ADMIN for *every* controller method in this class.
 * @IsGranted("ROLE_ADMIN")
  */



class IntgestionController extends AbstractController
{


    /**
     * @Route("/", name="intgestion")
     */

    public function index(ArticleRepository $article, QuoteRepository $quoteRepository, Request $request, PaginatorInterface $paginator): Response
    {

        // TODO Use bundle for pagination of articles
        $quoteList = $quoteRepository->findAll();
        $list = $article->findAll();
        $quote = new Quote();
        $form = $this->createForm(QuoteType::class, $quote);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $quote->setCreatedAt(new \DateTimeImmutable());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($quote);
            $entityManager->flush();

            return $this->redirectToRoute('intgestion', [], Response::HTTP_SEE_OTHER);
        }


        /* if (!$list){
             throw $this->createNotFoundException("Pas d'articles.");
         }*/


        return $this->render('intgestion/index.html.twig', [
            'controller_name' => 'IntgestionController',
            'list' => $list,
            'form' => $form->createView(),
            'quotelist' => $quoteList
        ]);
    }

    /**
     * @Route("/new", name="article_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        $article->setDate(new \DateTime());
        if ($form->isSubmitted() && $form->isValid()) {
            dd($article);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('intgestion', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('article/new.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }


    /**
     * @Route("/{id}/edit", name="article_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Article $article): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('intgestion', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('article/edit.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }


    /**
     * @Route("/{id}/delete", name="article_delete", methods={"POST"})
     */
    public function delete(Request $request, Article $article): Response
    {

        if ($this->isCsrfTokenValid('delete' . $article->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($article);
            $entityManager->flush();
        }

        return $this->redirectToRoute('intgestion', [], Response::HTTP_SEE_OTHER);
    }

}