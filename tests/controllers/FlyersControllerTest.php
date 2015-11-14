<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Session;



class FlyersControllerTest extends TestCase
{

    /** @test */
    public function it_shows_the_form_to_create_a_new_flyer()
    {
        $this->visit('flyers_uploads/create');
    }
} 