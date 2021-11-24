<?php


namespace App\Tests;


use Doctrine\Common\Cache\Psr6\InvalidArgument;
use MongoDB\BSON\Timestamp;
use Monolog\DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use App\Entity\Article;
use Symfony\Component\Validator\Constraints\DateTime;

class ArticleTest extends TestCase
{
    private Article $article;

    protected function setUp(): void
    {
        parent::setUp(); //
        $this->article = new Article();
    }

    public function testGetContent() {
        $value = "ibbra en test";
        $response = $this->article->setContent($value);
        self::assertInstanceOf(Article::class, $response);
    }

    public function testGetCategory() {
        $value = "Economie";
        $response = $this->article->setCategorie($value);
        self::assertInstanceOf(Article::class, $response);
    }


    /*
     * Check assert is from Article instance and is string
     */
    public function testGetImage() {
        //
        $value = "photo.jpg";

        $response = $this->article->setImgbg($value);
        self::assertInstanceOf(Article::class, $response);
        self::assertIsString($value);
    }


    /**
     * @expectedException InvalidArgumentException
     * check error if assert is not string
     */
    public function test_img_not_string(){

        $this->expectError();
        $value = new DateTimeImmutable();
        $response = $this->article->setImgbg($value);
    }

    /*
     * Check error if empty article content
     */
    public function test_error_if_empty_content() {

        $this->expectError();

        $value = null;

       $response =  $this->article->setContent($value);

    }
    /*
     * Return an error if title isNot String
     */
    public function test_error_if_invalid_title(){
        $this->expectError();
        $value = new Article();
        $response = $this->article->setTitre(new Timestamp());


    }

    /*
     * Return an error if content isNot String
     */
    public function test_error_if_invalid_content(){
        $this->expectError();
        $value = new DateTimeImmutable();
        $response = $this->article->setContent($value);

    }


    /*
     * Test Error if no title
     */
    public function test_error_if_empty_title() {
        //Check error if empty article content
        $this->expectError();
        $value = null;
        $response =  $this->article->setTitre($value);

    }


    //Test if  datetime publication is today's date (timezone bdd constraints)
/*
    public function test_valid_date(){
        $value = new \DateTime();

        $response = $this->article->setDate($value);
        $today = new DateTime();

        $this->assertSame($today ,$value);


    }*/






}