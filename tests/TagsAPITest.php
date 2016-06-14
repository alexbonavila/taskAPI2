<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class TagsAPITest extends TestCase
{
    use DatabaseMigrations;
    public function createUser()
    {
        $user = factory(App\User::class)->create();
        return $user;
    }
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testTagsUseJson()
    {
        $user = $this->createUser();
        $this->get('/tag?api_token=' . $user->api_token)->seeJson()->seeStatusCode(200);
    }
    /**
     * Test tags in database are listed by API
     *
     * @return void
     */
    public function testTagsInDatabaseAreListedByAPI()
    {
        $user = $this->createUser();
        $this->createFakeTags();
        $this->actingAs($user)->get('/tag')
            ->seeJsonStructure([
                '*' => [
                    'title'
                ]
            ])->seeStatusCode(200);
    }
    /**
     * Test tag Return 404 on tag not exsists
     *
     * @return void
     */
    public function testTagsReturn404OnTaskNotExsists()
    {
        $user = $this->createUser();
        $this->actingAs($user)->get('/tag/500')->seeJson()->seeStatusCode(404);
    }
    /**
     * Test tags in database is shown by API
     *
     * @return void
     */
    public function testTagsInDatabaseAreShownByAPI()
    {
        $user = $this->createUser();
        $tag = $this->createFakeTag();
        $this->actingAs($user)->get('/tag/' . $tag->id)->seeJsonContains(['title' => $tag->title])
            ->seeStatusCode(200);
    }
    /**
     * Create fake tag
     *
     * @return \App\Tag
     */
    private function createFakeTag() {
        $faker = Faker\Factory::create();
        $tag = new \App\Tag();
        $tag->title = $faker->word;
        $tag->save();
        return $tag;
    }
    /**
     * Create fake tags
     *
     * @param int $count
     * @return \App\Tag
     */
    private function createFakeTags($count = 10) {
        $this->withoutMiddleware();
        foreach (range(0,$count) as $number) {
            $this->createFakeTag();
        }
    }
    /**
     * Test tags can be posted and saved to database
     *
     * @return void
     */
    public function testTagsCanBePostedAndSavedIntoDatabase()
    {
        $user = $this->createUser();
        $data = ['title' => 'Foobar'];
        $this->actingAs($user)->post('/tag',$data)->seeInDatabase('tags',$data);
        $this->actingAs($user)->get('/tag')->seeJsonContains($data)->seeStatusCode(200);
    }
    /**
     * Test tags can be update and see changes on database
     *
     * @return void
     */
    public function testTagsCanBeUpdatedAndSeeChangesInDatabase()
    {
        $user = $this->createUser();
        $tag = $this->createFakeTag();
        $data = [ 'title' => 'Learn Laravel'];
        $this->actingAs($user)->put('/tag/' . $tag->id, $data)->seeInDatabase('tags',$data);
        $this->actingAs($user)->get('/tag')->seeJsonContains($data)->seeStatusCode(200);
    }
    /**
     * Test tagss can be deleted and not see on database
     *
     * @return void
     */
    public function testTagsCanBeDeletedAndNotSeenOnDatabase()
    {
        $user = $this->createUser();
        $tag = $this->createFakeTag();
        $data = [ 'title' => $tag->title];
        $this->actingAs($user)->delete('/tag/' . $tag->id)->notSeeInDatabase('tags',$data);
        $this->actingAs($user)->get('/tag')->dontSeeJson($data)->seeStatusCode(200);
    }
}