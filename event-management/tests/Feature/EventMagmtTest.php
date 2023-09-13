<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

use function PHPUnit\Framework\assertJson;

class EventMagmtTest extends TestCase
{
    public function test_app(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSeeText('Hello');
    }

    public function test_list_all_events()
    {
        $response = $this->getJson('/api/events');
        $response->assertStatus(200);
        $response->assertJsonIsObject();
    }

    public function test_one_event_by_id()
    {
        $response = $this->getJson('/api/events/200');
        $response->assertStatus(200);
        $response->assertJsonIsObject();
    }

    public function test_list_attendee_for_event_id()
    {
        $response = $this->getJson('/api/events/200/attendees');
        $response->assertStatus(200);
        $response->assertJsonIsObject();
    }

    public function test_list_attendee_for_event_id_by_attendee_id()
    {
        $response = $this->getJson('/api/events/200/attendees/1938');
        $response->assertStatus(200);
        $response->assertJsonIsObject();
    }
}
