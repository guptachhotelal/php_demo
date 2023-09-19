<?php

namespace Tests\Feature\Livewire;

use App\Livewire\CreatePoll;
use Livewire\Livewire;
use Tests\TestCase;

class CreatePollTest extends TestCase
{
    /** @test */
    public function create_poll_component_renders_successfully()
    {
        Livewire::test(CreatePoll::class)
            ->assertStatus(200);
    }

    public function create_poll_component_exists_on_the_page()
    {
       $this->get('/')->assertSeeLivewire(CreatePoll::class);
    }

    public function create_poll_can_set_title()
    {
        Livewire::test(CreatePoll::class)
            ->set('title', 'Poll Title')
            ->assertSet('title', 'Poll Title');
    }
}
