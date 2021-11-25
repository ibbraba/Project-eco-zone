<?php


namespace App\Tests\Controller;

use App\DataFixtures\TestFixtures;
use App\DataFixtures\UserFixtures;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ObjectManager;
use http\Client\Response;
use Liip\TestFixturesBundle\Services\DatabaseTools;

use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

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
        $this->databaseTool = $this->testClient->getContainer()
            ->get(DatabaseToolCollection::class)->get();
    }


    // Make sure the page is loaded
    public function test_category_page_ok(){

        $categories = ["/actualites", "/bourse", "/eco", "/societe", "/livres"];

        $this->databaseTool->loadFixtures(["App\DataFixtures\TestFixtures"]);
//        $this->assertEquals(null, $this->databaseTool);


        foreach ($categories as $category){
            $crawler = $this->testClient->request('GET', $category);
            $this->assertResponseStatusCodeSame(200);
        }

    }

    // Load the page with an error message if no category article
    public function test_category_with_no_article(){
        $categories = ["/actualites", "/bourse", "/eco", "/societe", "/livres"];

        $this->databaseTool->loadFixtures();
//        $this->assertEquals(null, $this->databaseTool);


        foreach ($categories as $category){
            $crawler = $this->testClient->request('GET', $category);
            $this->assertResponseStatusCodeSame(200);
            $this->assertSelectorTextContains('p', "Aucun article trouvé dans cette catégorie");
        };




    }



    public function test_page_not_found(){
        $crawler = $this->testClient->request('GET', "/helloworld");
        $this->assertResponseStatusCodeSame(\Symfony\Component\HttpFoundation\Response::HTTP_NOT_FOUND);
    }




}