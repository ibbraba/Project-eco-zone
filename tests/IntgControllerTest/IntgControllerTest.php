<?php


namespace App\Tests\IntgControllerTest;

use App\DataFixtures\TestFixtures;
use App\DataFixtures\UserFixtures;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ObjectManager;
use http\Client\Request;
use http\Client\Response;
use Liip\TestFixturesBundle\Services\DatabaseTools;

use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class IntgControllerTest extends WebTestCase
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

    //Return error code if not logged in
/*    public function test_backend_without_credentials(){

        $crawler = $this->testClient->request('GET', '/intgestion');
        $this->assertResponseRedirects("/intgestion");

    }*/






}