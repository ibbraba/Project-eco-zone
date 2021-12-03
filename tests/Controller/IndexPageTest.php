<?php


namespace App\Controller\Tests;




use App\DataFixtures\TestFixtures;
use App\DataFixtures\UserFixtures;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ObjectManager;
use http\Client\Response;
use Liip\TestFixturesBundle\Services\DatabaseTools;

use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/*
 * Here we test if the Maincontroller function are OK
 */
class IndexPageTest extends WebTestCase
{



    /**
     * @var AbstractDatabaseTool
     */
    protected $databaseTool
  ;

  private $testClient = null;


    public function setUp(): void
    {

        $this->testClient = static::createClient();
        $this->databaseTool = $this->testClient->getContainer()
            ->get(DatabaseToolCollection::class)->get();

    //    $this->testClient->getContainer()->get(DatabaseToolCollection::class)->get();

    }

    public function test_Main_Page()
    {
   /*     $client = static::createClient();

        $this->databaseTool = static::getContainer()
            ->get("doctrine.orm.entity_manager");*/



        $this->databaseTool->loadFixtures(["App\DataFixtures\TestFixtures"]);
//        $this->assertEquals(null, $this->databaseTool);




        $crawler = $this->testClient->request('GET', "/");
        $this->assertResponseStatusCodeSame(200);
    }

    //Test if no quote on main page
    // The page should still be loaded (Twig error by default)
    public function test_error_if_no_quote(){

        $this->databaseTool->loadAliceFixture([__DIR__ . '/IndexNoQuoteTest.yaml']);
        $crawler = $this->testClient->request('GET', "/");
        $this->assertResponseStatusCodeSame(200);

    }

    public function test_index_without_book_review(){
        $this->databaseTool->loadAliceFixture([__DIR__ . '/IndexNoBookReview.yaml']);
        $crawler = $this->testClient->request('GET', "/");
        $this->assertResponseStatusCodeSame(200);

    }

    public function test_index_if_no_articles(){
       // $this ->expectError();


        $this->databaseTool->loadFixtures();
        $crawler = $this->testClient->request('GET', "/");
        $this->assertResponseStatusCodeSame(200);

    }






}