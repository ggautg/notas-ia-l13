<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Tag;
use App\Services\NoteAiService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Laravel\Ai\Embeddings;
use Storage;
use Str;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Note::where('user_id', auth()->id());

        if ($request->filled('tag')) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('name', $request->input('tag'));
            });
        }

        $notes = $query->latest()->paginate(5);

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
    public function store(Request $request, NoteAiService $ai)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'tags' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $validated['embedding'] = $ai->generateEmbedding($validated['title'], $validated['content']);
        $validated['summary'] = $ai->generateSummary($validated['title'], $validated['content']);
        $validated['user_id'] = auth()->id();

        $tagsInput = $validated['tags'] ?? '';
        unset($validated['tags']);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('notes', 'public');
        } else {
            unset($validated['image']);
        }

        $note = Note::create($validated);

        $this->syncTags($note, $tagsInput);

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
    public function update(Request $request, string $id, NoteAiService $ai)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'tags' => 'nullable||string',
            'image' => 'nullable|image|max:2048',
        ]);

        $validated['embedding'] = $ai->generateEmbedding($validated['title'], $validated['content']);
        $validated['summary'] = $ai->generateSummary($validated['title'], $validated['content']);

        $tagsInput = $validated['tags'] ?? '';
        unset($validated['tags']);

        $note = Note::where('user_id', auth()->id())->findOrFail($id);

        $note->versions()->create([
            'title' => $note->title,
            'content' => $note->content,
        ]);

        if ($request->hasFile('image')) {
            if ($note->image) {
                Storage::disk('public')->delete($note->image);
            }

            $validated['image'] = $request->file('image')->store('notes', 'public');
        } else {
            unset($validated['image']);
        }

        $note->update($validated);

        $this->syncTags($note, $tagsInput);

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

    public function share(string $id)
    {
        $note = Note::where('user_id', auth()->id())->findOrFail($id);

        if (! $note->share_token) {
            $note->update(['share_token' => Str::random(32)]);
        }

        return redirect('/notes')->with('success', 'Link generado correctamente');
    }

    public function shared(string $token)
    {
        $note = Note::where('share_token', $token)->firstOrFail();

        return view('notes.shared', ['note' => $note]);
    }

    public function pdf(string $id)
    {
        $note = Note::where('user_id', auth()->id())->findOrFail($id);

        $pdf = Pdf::loadView('notes.pdf', ['note' => $note]);

        return $pdf->download('nota-'.$note->id.'.pdf');
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

    public function history(string $id)
{
    $note = Note::where('user_id', auth()->id())->findOrFail($id);

    return view('notes.history', ['note' => $note]);
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

    private function syncTags(Note $note, string $tagsInput): void
    {
        $tagNames = collect(explode(',', $tagsInput))
            ->map(fn ($name) => trim($name))
            ->filter();

        $tagIds = $tagNames->map(function ($name) {
            return Tag::firstOrCreate(['name' => $name])->id;
        });

        $note->tags()->sync($tagIds);
    }
}
