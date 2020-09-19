<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class AgregarCategoria extends Page
{
    public function url()
    {
        return '/admin/category/new';
    }

    public function assert(Browser $browser)
    {
        $browser->assertPathIs($this->url());
    }

    public function elements()
    {
        return [
            '@element' => '#selector',
        ];
    }
}
