<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Tag;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
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

        $query->orderByDesc('pinned');

        match ($request->input('sort', 'recent')) {
            'oldest' => $query->oldest(),
            'az' => $query->orderBy('title'),
            default => $query->latest(),
        };

       $notes = $query->paginate(5)->withQueryString();

$totalNotes = Note::where('user_id', auth()->id())->count();
$topTags = Tag::whereHas('notes', function ($q) {
    $q->where('user_id', auth()->id());
})
    ->withCount(['notes' => function ($q) {
        $q->where('user_id', auth()->id());
    }])
    ->orderByDesc('notes_count')
    ->take(3)
    ->get();

return view('notes.index', ['notes' => $notes, 'totalNotes' => $totalNotes, 'topTags' => $topTags]);
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
            'tags' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'emoji' => 'nullable|string',
        ]);

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
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'tags' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'emoji' => 'nullable|string',
        ]);

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

        $notesQuery = Note::where('user_id', auth()->id())
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', '%'.$query.'%')
                    ->orWhere('content', 'like', '%'.$query.'%');
            });

        if ($request->filled('tag')) {
            $notesQuery->whereHas('tags', function ($q) use ($request) {
                $q->where('name', $request->input('tag'));
            });
        }

        $notes = $notesQuery->latest()->get();

        return view('notes.index', ['notes' => $notes]);
    }

    public function history(string $id)
    {
        $note = Note::where('user_id', auth()->id())->findOrFail($id);

        return view('notes.history', ['note' => $note]);
    }

    public function restore(string $id, string $versionId)
    {
        $note = Note::where('user_id', auth()->id())->findOrFail($id);
        $version = $note->versions()->findOrFail($versionId);

        $note->versions()->create([
            'title' => $note->title,
            'content' => $note->content,
        ]);

        $note->update([
            'title' => $version->title,
            'content' => $version->content,
        ]);

        return redirect('/notes')->with('success', 'Nota restaurada correctamente');
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

    public function pin(string $id)
    {
        $note = Note::where('user_id', auth()->id())->findOrFail($id);
        $note->update(['pinned' => ! $note->pinned]);

        $message = $note->pinned ? 'Nota fijada' : 'Nota desfijada';

        return redirect()->back()->with('success', $message);
    }
}
