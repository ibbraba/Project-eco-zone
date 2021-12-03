<?php


namespace App\Tests\ArticleForm;


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


/*    public function test_unique_article_title(){
        $client = $this->testClient->request('GET', '/intgestion/new');
       $crawler = $this->testClient->submitForm("Save",
           [
            "article[titre]" => "test titre",
            "article[content]" => "test contenu",
            "article[preview]" => "test preview",
            "article[imgbg]" => "phototest.jpg"]);


     //  $this->testClient->followRedirect();
       // $this->assertResponseStatusCodeSame(200);
       // $this->assertSelectorTextContains("div", "Votre article a bien été enregistré !");
    }*/






}