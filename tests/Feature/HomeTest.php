<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomeTest extends TestCase
{
    public function testHomePageIsWorkingCorrectly()
    {
        $response = $this->get('/');        // opening the main page
        
        $response->assertSeeText('Welcome to Laravel!');     // verifying whether we can be see the text in the response we get back 
        $response->assertSeeText('This is the content of the main page.');       
    }
    
    public function testContactPageIsWorkingCorrectly()
    {
        $response = $this->get('/contact');        
        
        $response->assertSeeText('Contact');     
        $response->assertSeeText('Hello this is contact!');      
    }
}
