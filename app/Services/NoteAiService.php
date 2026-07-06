<?php

namespace App\Services;

use App\Ai\Agents\Summarizer;
use Laravel\Ai\Embeddings;

class NoteAiService
{
    public function generateEmbedding(string $title, string $content): array
    {
        $embedding = Embeddings::for([$title.' '.$content])->generate();

        return $embedding->embeddings[0];
    }

    public function generateSummary(string $title, string $content): string
    {
        $summary = Summarizer::make()->prompt('Resumí esta nota: '.$title.' - '.$content);

        return (string) $summary;
    }
}