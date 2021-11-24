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


class MainControllerTest extends WebTestCase
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




}