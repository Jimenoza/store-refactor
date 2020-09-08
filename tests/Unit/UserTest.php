<?php

namespace Tests\Unit;

use Tests\TestCase;
use tiendaVirtual\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use DB;

class UserTest extends TestCase
{
    use DatabaseTransactions;
    protected $user;
    protected $admin;

    public function setUp() {
      parent::setUp();
      $this->user = factory(User::class)->create(['admin' => '0']);
      $this->admin = factory(User::class)->create(['admin' => '1']);
    }

    /** @test */
    public function testExample()
    {
        $this->assertTrue(true);
    }
}
