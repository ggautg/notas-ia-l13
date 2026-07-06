<?php

namespace App\Http\Controllers;

use App\Ai\Agents\Summarizer;
use App\Models\Note;
use Illuminate\Http\Request;
use Laravel\Ai\Embeddings;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notes = Note::where('user_id', auth()->id())->latest()->paginate(5);

        return view('notes.index', ['notes' => $notes]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('notes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        $embedding = Embeddings::for([$validated['title'].' '.$validated['content']])
            ->generate();

        $validated['embedding'] = $embedding->embeddings[0];

        $summary = Summarizer::make()->prompt('Resumí esta nota: '.$validated['title'].' - '.$validated['content']);

        $validated['summary'] = (string) $summary;

        $validated['user_id'] = auth()->id();

        Note::create($validated);

        return redirect('/notes')->with('success', 'Nota creada correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $note = Note::where('user_id', auth()->id())->findOrFail($id);

        return view('notes.edit', ['note' => $note]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        $embedding = Embeddings::for([$validated['title'].' '.$validated['content']])
            ->generate();

        $validated['embedding'] = $embedding->embeddings[0];

        $summary = Summarizer::make()->prompt('Resumí esta nota: '.$validated['title'].' - '.$validated['content']);

        $validated['summary'] = (string) $summary;

        $note = Note::where('user_id', auth()->id())->findOrFail($id);

        $note->update($validated);

        return redirect('/notes')->with('success', 'Nota actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $note = Note::where('user_id', auth()->id())->findOrFail($id);

        $note->delete();

        return redirect('/notes')->with('success', 'Nota borrada correctamente');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        if (! $query) {
            return redirect('/notes');
        }

        $queryEmbedding = Embeddings::for([$query])->generate()->embeddings[0];

        $notes = Note::whereNotNull('embedding')->get();

        $notes = $notes->map(function ($note) use ($queryEmbedding) {
            $note->similarity = $this->cosineSimilarity($note->embedding, $queryEmbedding);

            return $note;
        })->sortByDesc('similarity')->values();

        return view('notes.index', ['notes' => $notes]);
    }

    private function cosineSimilarity(array $a, array $b): float
    {
        $dotProduct = 0;
        $normA = 0;
        $normB = 0;

        foreach ($a as $i => $value) {
            $dotProduct += $value * $b[$i];
            $normA += $value ** 2;
            $normB += $b[$i] ** 2;
        }

        return $dotProduct / (sqrt($normA) * sqrt($normB));
    }
}
