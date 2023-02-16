<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Article;
use Illuminate\Foundation\Testing\WithFaker;
use App\Http\Controllers\API\ArticleController;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ArticleTest extends TestCase
{
    use RefreshDatabase;


    /** @test */
    public function get_article()
    {
        // arrange
        Article::factory()->count(10)->create();

        // act
        $articles =  (new ArticleController)->index();
        $json = json_decode(json_encode($articles, true));


        // asserts
        $this->assertEquals(10, count($json->original->articles));
    }

    /** @test */
    public function show_article()
    {
        // arrange
        $article = Article::factory()->create();

        // act
        $response = (new ArticleController)->show($article->slug);
        $json = json_decode(json_encode($response, true));

        // asserts
        $this->assertEquals($article->id, $json->original->article->id);
    }

    /** @test */
    public function is_wrong_slug_pass_on_show()
    {
        // arrange
        $article = Article::factory()->create();

        // act
        $response = (new ArticleController)->show($article->id);

        // asserts
        $this->assertEquals(404, $response->status());
    }


    /** @test */
    public function delete_article()
    {
        // arrange
        $article = Article::factory()->create();

        // act
        $delete = (new ArticleController)->delete($article->slug);

        // asserts
        $response = (new ArticleController)->show($article->slug);
        $this->assertEquals(404, $response->status());
    }
}
