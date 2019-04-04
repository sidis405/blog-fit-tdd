<?php

namespace Tests;

use Acme\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function setUp() : void
    {
        parent::setUp();

        $this->withoutExceptionHandling();
    }

    public function signIn($user = null)
    {
        $this->actingAs($user ?? create(User::class));

        factory(Acme\Models\User::class)->states('pincopallino')->crate();
    }
}
