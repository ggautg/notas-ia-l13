<?php

use App\Models\Note;
use Laravel\Ai\Embeddings;
use Livewire\Component;
use Livewire\Volt\Component as VoltComponent;

new class extends Component
{
    public string $query = '';

    public function getNotesProperty()
    {
        if (strlen($this->query) < 3) {
            return collect();
        }

        $queryEmbedding = Embeddings::for([$this->query])->generate()->embeddings[0];

        return Note::where('user_id', auth()->id())
            ->whereNotNull('embedding')
            ->get()
            ->map(function ($note) use ($queryEmbedding) {
                $note->similarity = $this->cosineSimilarity($note->embedding, $queryEmbedding);
                return $note;
            })
            ->sortByDesc('similarity')
            ->take(5)
            ->values();
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
?>

<div>
    <input
        type="text"
        wire:model.live.debounce.400ms="query"
        placeholder="Buscar por significado..."
        class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-lg px-3 py-2 text-sm"
    >

    @if (strlen($query) >= 3)
        <ul class="mt-4 space-y-3">
            @forelse ($this->notes as $note)
                <li class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4 shadow-sm">
                    <strong class="text-gray-900 dark:text-white">{{ $note->title }}</strong>
                    <p class="text-gray-600 dark:text-gray-300 text-sm mt-1">{{ $note->content }}</p>
                    <small class="text-gray-400">Coincidencia: {{ round($note->similarity * 100) }}%</small>
                </li>
            @empty
                <p class="text-gray-400 text-sm">Sin resultados</p>
            @endforelse
        </ul>
    @endif
</div>