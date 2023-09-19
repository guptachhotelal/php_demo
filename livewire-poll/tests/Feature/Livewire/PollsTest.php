<?php

namespace Tests\Feature\Livewire;

use App\Livewire\Polls;
use Livewire\Livewire;
use Tests\TestCase;

class PollsTest extends TestCase
{
    /** @test */
    public function polls_component_renders_successfully()
    {
        Livewire::test(Polls::class)
            ->assertStatus(200);
    }

    public function polls_component_exists_on_the_page()
    {
       $this->get('/')->assertSeeLivewire(Polls::class);
    }
}
