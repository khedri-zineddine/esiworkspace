<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DatabaseTest extends TestCase
{
    use RefreshDatabase;
    /**
     * assurer que l'admin et exsist dans la base de donnee
     *
     * @return void
     */
    public function adminHas()
    {
        $this->assertDatabaseHas('utilisateur',[
            'email'=>'space_admin@esi.dz'
        ]);

    }
    
}
