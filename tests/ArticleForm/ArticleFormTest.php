<?php


namespace App\Tests\ArticleForm;


use App\Repository\ArticleRepository;
use App\Repository\UserRepository;
use Faker\Provider\DateTime;
use http\Client\Response;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Doctrine\Common\Persistence\ObjectManager;
use \Doctrine\DBAL\Driver\Middleware;


/*
 * Here we test all functions related to the ArticleController to be sure to manage well our articles
 */
class ArticleFormTest extends WebTestCase
{

    /**
     *TODO Test unique title -> to put in file ArticleForm
     * TODO File test for ArticleForm
     * @var AbstractDatabaseTool
     */
    protected $databaseTool
    ;

    private $testClient = null;

    protected function setUp(): void
    {
        $this->testClient = static::createClient();

        $userRepository = static::getContainer()->get(UserRepository::class);

        $this->databaseTool = $this->testClient->getContainer()
            ->get(DatabaseToolCollection::class)->get();
        $this->databaseTool->loadAliceFixture([__DIR__."/AdminUserFixturesTest.yaml"]);
        // retrieve the test user

        $testUser = $userRepository->findOneBy([
            "username" => "user1"
        ]);

        $this->assertNotNull($testUser);
        // simulate $testUser being logged in
        $this->testClient->loginUser($testUser);

    }

    /*
     * Test access to authorized page with role admin
     */
    public function test_is_authentication_ok (){
        // test e.g. the profile page
        $this->testClient->request('GET', '/intgestion/new');
        $this->assertResponseStatusCodeSame(200);
        $this->assertSelectorTextContains('h1', 'Create new Article');
    }


   public function test_flush_new_article(){
        $crawler = $this->testClient->request('GET', '/intgestion/new');
        $form = $crawler->selectButton("Save")->form([
            "article[titre]" => "test titre",
            "article[content]" => "test contenu",
            "article[preview]" => "test preview",
            "article[imgbg]" => "phototest.jpg"]);

       $this->testClient->submit($form);
       $this->testClient->followRedirect();
       $this->assertSelectorTextContains("div", "Votre article a bien été enregistré !");
    }

    public function test_success_edit_article(){

        $this->databaseTool->loadAliceFixture([__DIR__."/ArticleFormTest.yaml"], true);
      $crawler =  $this->testClient->request("GET", "/intgestion/1/edit");
        $this->assertResponseStatusCodeSame(200);
       $form= $crawler->selectButton("Update")->form([
           'article[titre]' => 'edit titre'
       ]);

       $this->testClient->submit($form);
       $this->testClient->followRedirect();
      // $this->assertSelectorTextContains("div", "Votre Article a bien été modifié ! ")
       ;



    }


   //TODO test success delete article
    public function test_success_delete_article(){
        $this->databaseTool->loadAliceFixture([__DIR__."/ArticleFormTest.yaml"], true);
        $crawler =  $this->testClient->request("GET", "/intgestion");

        $form = $crawler->filter('form[name=delete1]')->form();
        $this->testClient->submit($form);
        $this->testClient->followRedirect();
        $this->assertResponseStatusCodeSame(200);
         $this->assertSelectorTextContains("div", "Votre Article a bien été supprimé ! ")
        ;
    }




}