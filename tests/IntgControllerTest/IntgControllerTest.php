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
     *
     * TODO Acces if ROLE_ADMIN
     * TODO  No acces if not ROLE_ADMIN
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


    /*
     * Return login page if not logged in
     */
    public function test_backend_without_credentials(){

        $crawler = $this->testClient->request('GET', '/intgestion/');
        $this->assertResponseRedirects('/ezone/login');
    }

    /*
     * Acces authorized if logged in
     */
    public function test_backend_with_good_credentials(){
        $this->databaseTool->loadAliceFixture([__DIR__.'/UserFixturesTest.yaml']);
        $crawler = $this->testClient->request("GET", "/ezone/login");
        $crawler->selectButton("Se connecter")->form([
            "username"=> "user1",
            "password"=> "00000"
        ]);

        $this->assertResponseStatusCodeSame(200);
      //  $this->assertResponseRedirects('intgestion');

    }

    /*
     * Acces unauthorized with bad credentials
     */
    public function test_backend_access_unauthorized_with_bad_credentials()
    {


        $this->databaseTool->loadAliceFixture([__DIR__ . '/UserFixturesTest.yaml']);
        $crawler = $this->testClient->request("GET", "/ezone/login");
        $form = $crawler->selectButton("Se connecter")->form([
            "username" => "user1",
            "password" => "12345" //Wrong password
        ]);
        $this->testClient->submit($form);

        $this->assertResponseRedirects('/ezone/login');
        $this->testClient->followRedirect();
        $this->assertSelectorTextContains("div", "Invalid credentials");
    }

    /*
     * Acces unauthorized with role user
     */
    public function test_backend_access_unauthorized_without_admin_role(){


            $this->databaseTool->loadAliceFixture([__DIR__.'/UserFixturesTest.yaml']);
            $crawler = $this->testClient->request("GET", "/ezone/login");
            $form =  $crawler->selectButton("Se connecter")->form([
                "username"=> "user2",
                "password"=> "00000"
            ]);
            $this->testClient->submit($form);

            $this->assertResponseRedirects('/ezone/login');
            $this->testClient->followRedirect();
            $this->assertSelectorTextContains("div","Invalid credentials");

    }


    //TODO Article created deleted, and edited flash (create var=true in controller and render)
    //TODO Make sure an article is created or deleted by counting number of articles



}