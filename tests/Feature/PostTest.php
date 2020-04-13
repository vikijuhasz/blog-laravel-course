<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\BlogPost;
use App\Comment;

class PostTest extends TestCase
 {
    use RefreshDatabase;
    
    public function testNoBlogPostsWhenNothingInDatabase()
    {
       $response = $this->get('/posts');
       $response->assertSeeText('No blog posts yet');
    }
    
    public function testSee1BlogPostWhenThereIs1WithNoComments()
    {
        // Arrange part, we are preparing something we would like to test
        $this->createDummyBlogPost();
        
        // Act, fetching the list of blogposts        
        $response = $this->get('/posts');
        
        // Assert, verifying that we can see the title of this blog post on the page        
        $response->assertSeeText('New Title');
        $response->assertSeeText('No comments yet');
        
        // check if blog_posts table has this record
        $this->assertDatabaseHas('blog_posts', [
            'title' => 'New Title'
        ]);
    }
    
    public function testSee1BlogPostWithComments()
    {
        $user = $this->user();
        
        $post = $this->createDummyBlogPost();
        
        factory(Comment::class, 4)->create([
            'commentable_id' => $post->id,
            'commentable_type' => 'App\BlogPost',
            'user_id' => $user->id
         ]);
        
        $response = $this->get('/posts');
        $response->assertSeeText('4 comments');
    }        

    // TESTING STORE ACTION 
    public function testStoreValid()
    {
        // Arrange
        $params = [
            'title' => 'Valid title',
            'content' => 'At least 10 characters'
        ];
        
        // we call the end point that saves this blog post, we are using post(), because this action is using the post verb. We are stimulating an http request that would be made in the browser, like we would be submitting a form. 
        $this->actingAs($this->user())
            ->post('/posts', $params)
            ->assertStatus(302)         // we are calling posts, if it is valid, it makes a redirect, so we check fgor the status, 302 = successful redirect
            ->assertSessionHas('status');   // we check if the flash message was added to the session
        
        $this->assertEquals(session('status'), 'Blog post was created!');
// we verify if the message is what we expected it to be, we can read the sesion variable by calling session() 
    }
    
    // TESTING FOR FAILURE
    public function testStoreFail()
    {
        $params = [
            'title' => 'x',
            'content' => 'x'
        ];
        
        $this->actingAs($this->user())
            ->post('/posts', $params)
            ->assertStatus(302)
            ->assertSessionHas('errors');
        
        $messages = session('errors')->getMessages();
        // dd($messages->getMessages());  /* In the ViewErrorBag class there is a __call method, which allows you to call any dynamic methods that are not defined, not part of this class. So if we call a method not defined in this class it will be called on the defaultBag. And since the defaultBag is of the type MessageBag. We will use the getMessages() of the MessageBag class. Instead of fetching the individual bags, because we have only one, we want to call getMessages, which will be called on the MessageBag object. ????????? */
        
        $this->assertEquals($messages['title'][0], 'The title must be at least 5 characters.');
        $this->assertEquals($messages['content'][0], 'The content must be at least 10 characters.');
    }
    
    public function testUpdateValid()
    {
        $user = $this->user();
        $post = $this->createDummyBlogPost($user->id);
        
        $this->assertDatabaseHas('blog_posts', $post->toArray());
        
        $params = [
            'title' => 'updated title',
            'content' => 'updated content'
        ];
        
        $this->actingAs($user)
            ->put("/posts/{$post->id}", $params)
            ->assertStatus(302)
            ->assertSessionHas('status');
        
        $this->assertEquals(session('status'), 'Blog post was updated!');
        // after we have verified that the above endpoint went through properly, we need to check that the original blog post we created cannot be found, which would mean that it was modified. 
        $this->assertDatabaseMissing('blog_posts', $post->toArray());
        // check if the modified blog post exists
        $this->assertDatabaseHas('blog_posts', [
            'title' => 'updated title'
        ]);
    } 

    public function testDelete()
    {
        $user = $this->user();
        $post = $this->createDummyBlogPost($user->id);        
        $this->assertDatabaseHas('blog_posts', $post->toArray());
        
        $this->actingAs($user)
            ->delete("/posts/{$post->id}")
            ->assertStatus(302)
            ->assertSessionHas('status');
        
        $this->assertEquals(session('status'), 'Blog post was deleted!');        
        // $this->assertDatabaseMissing('blog_posts', $post->toArray());  
        $this->assertSoftDeleted('blog_posts', $post->toArray());
    }
    
    private function createDummyBlogPost($userId = null): BlogPost            // : BlogPost = returns a BlogPost object            
    {
//        $post = new BlogPost();
//        $post->title = 'Title';
//        $post->content = 'Content of blog post';
//        $post->save();
        
//        return $post;
        
        return factory(BlogPost::class)->state('new-title')->create([
              'user_id' => $userId ?? $this->user()->id  
        ]);
    }
}
