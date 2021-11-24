<?php

namespace App\Tests;

use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\Article;

class AppTest extends WebTestCase {

    protected Article $article;

    protected function setUp(): void
    {
        parent::setUp(); //

        $this->article = new Article();
    }


    public function testBase () {

        $this->assertEquals(2, 1+1);
    }



    // Test views count adding up
    //TODO Test controller
  /*  public function test_views_count (){

        $client = static::createClient();
        $oldviews = $this->article->getViews();
        $id = $this->article->getId();

        if ($oldviews === null){$oldviews = 0;}
        $url = "/article/10";

        $this->assertEquals(0, $oldviews );
        //Make a request to access article
        $crawler = $client->request('GET', $url );
        $this->assertResponseIsSuccessful();
        //$newViews =  $this->article->getViews();

     //   $this->assertEquals($oldviews +1, $newViews);
    }
*/



}