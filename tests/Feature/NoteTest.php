<?php

use App\Ai\Agents\Summarizer;
use App\Models\Note;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Ai\Embeddings;
uses(RefreshDatabase::class);

test('se puede crear una nota', function () {
    Embeddings::fake();
    Summarizer::fake();

    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/notes', [
        'title' => 'Nota de prueba',
        'content' => 'Este es el contenido de prueba',
    ]);

    $response->assertRedirect('/notes');

    $this->assertDatabaseHas('notes', [
        'title' => 'Nota de prueba',
        'content' => 'Este es el contenido de prueba',
        'user_id' => $user->id,
    ]);
});

test('no se puede crear una nota sin título', function () {
    Embeddings::fake();
    Summarizer::fake();

    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/notes', [
        'title' => '',
        'content' => 'Contenido sin título',
    ]);

    $response->assertSessionHasErrors('title');

    $this->assertDatabaseMissing('notes', [
        'content' => 'Contenido sin título',
    ]);
});

test('se puede editar una nota', function () {
    Embeddings::fake();
    Summarizer::fake();

    $user = User::factory()->create();

    $note = Note::factory()->create([
        'user_id' => $user->id,
        'title' => 'Título original',
        'content' => 'Contenido original',
    ]);

    $response = $this->actingAs($user)->put("/notes/{$note->id}", [
        'title' => 'Título editado',
        'content' => 'Contenido editado',
    ]);

    $response->assertRedirect('/notes');

    $this->assertDatabaseHas('notes', [
        'id' => $note->id,
        'title' => 'Título editado',
        'content' => 'Contenido editado',
    ]);
});

test('se puede borrar una nota', function () {
    $user = User::factory()->create();

    $note = Note::factory()->create(['user_id' => $user->id]);

    $response = $this->actingAs($user)->delete("/notes/{$note->id}");

    $response->assertRedirect('/notes');

    $this->assertDatabaseMissing('notes', [
        'id' => $note->id,
    ]);
});

test('un usuario no puede editar la nota de otro usuario', function () {
    $userA = User::factory()->create();
    $userB = User::factory()->create();

    $note = Note::factory()->create(['user_id' => $userA->id]);

    $response = $this->actingAs($userB)->put("/notes/{$note->id}", [
        'title' => 'Intento de edición ajena',
        'content' => 'No debería funcionar',
    ]);

    $response->assertStatus(404);

    $this->assertDatabaseMissing('notes', [
        'id' => $note->id,
        'title' => 'Intento de edición ajena',
    ]);
});