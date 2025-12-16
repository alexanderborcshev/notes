<?php

namespace Tests\Feature;

use App\Infrastructure\Notes\Eloquent\Note;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NoteTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_list_notes(): void
    {
        $notes = Note::factory()->count(3)->create();

        $response = $this->getJson(route('notes.index'));

        $response->assertStatus(200)
            ->assertJsonCount(3)
            ->assertJsonStructure([
                [
                    'id',
                    'title',
                    'description',
                ],
            ]);

        foreach ($notes as $note) {
            $response->assertJsonFragment([
                'id'      => $note->id,
                'title'   => $note->title,
                'description' => $note->description,
            ]);
        }
    }

    public function test_it_returns_validation_errors_on_store(): void
    {
        $response = $this->postJson(route('notes.store'));

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['title', 'description']);
    }

    public function test_it_can_store_a_note(): void
    {
        $payload = [
            'title'   => 'Test Note',
            'description' => 'This is a test note description.',
        ];

        $response = $this->postJson(route('notes.store'), $payload);

        $response->assertStatus(200)
            ->assertJsonFragment($payload);

        $this->assertDatabaseHas('notes', $payload);
    }

    public function test_it_returns_validation_errors_on_update(): void
    {
        $note = Note::factory()->create();

        $response = $this->putJson(route('notes.update', ['id' => $note->id]));

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['title', 'description']);
    }

    public function test_it_can_update_a_note(): void
    {
        $note = Note::factory()->create();

        $payload = [
            'title'   => 'Updated title',
            'description' => 'Updated description.',
        ];

        $response = $this->putJson(route('notes.update', ['id' => $note->id]), $payload);

        $response->assertStatus(200)
            ->assertJsonFragment($payload);

        $this->assertDatabaseHas('notes', [
            'id'      => $note->id,
            'title'   => $payload['title'],
            'description' => $payload['description'],
        ]);
    }

    public function test_it_returns_404_when_destroying_non_existing_note(): void
    {
        $response = $this->deleteJson(route('notes.destroy', ['id' => 999]));
        $response->assertStatus(404);
    }

    public function test_it_can_destroy_a_note(): void
    {
        $note = Note::factory()->create();

        $response = $this->deleteJson(route('notes.destroy', ['id' => $note->id]));

        $response->assertStatus(204);

        $this->assertDatabaseMissing('notes', ['id' => $note->id]);
    }
}
