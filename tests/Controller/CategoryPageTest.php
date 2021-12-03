<?php


namespace App\Tests\Controller;



use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;


class CategoryPageTest extends WebTestCase
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
        $this->databaseTool = $this->testClient->getContainer()->get(DatabaseToolCollection::class)->get();
    }


    // Make sure the page is loaded
    public function test_category_page_ok(){

        $categories = ["/actualites", "/bourse", "/eco", "/societe", "/livres"];

        $this->databaseTool->loadAliceFixture([__DIR__."/categoryPageTest.yaml"]);



        foreach ($categories as $category){
            $this->testClient->request('GET', $category);
            $this->assertResponseStatusCodeSame(200);
        }

    }

    // Load the page with an error message if no category article
    public function test_category_with_no_article(){
        $categories = ["/actualites", "/bourse", "/eco", "/societe", "/livres"];

        $this->databaseTool->loadFixtures();
//        $this->assertEquals(null, $this->databaseTool);


        foreach ($categories as $category){
           $this->testClient->request('GET', $category);
            $this->assertResponseStatusCodeSame(200);
            $this->assertSelectorTextContains('p', "Aucun article trouvé dans cette catégorie");
        };




    }



    public function test_page_not_found(){
        $this->testClient->request('GET', "/helloworld");
        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }




}