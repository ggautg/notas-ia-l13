<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: sans-serif;
            color: #333;
            padding: 30px;
        }
        h1 {
            color: #1a1a2e;
            border-bottom: 2px solid #4a5fd9;
            padding-bottom: 10px;
        }
        .summary {
            color: #4a5fd9;
            font-style: italic;
            margin-bottom: 15px;
        }
        .tags span {
            background-color: #eef0fd;
            color: #4a5fd9;
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 12px;
            margin-right: 5px;
        }
        .content {
            margin-top: 20px;
            line-height: 1.6;
        }
        .date {
            color: #999;
            font-size: 12px;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <h1>{{ $note->title }}</h1>

    @if ($note->summary)
        <p class="summary">{{ $note->summary }}</p>
    @endif

    @if ($note->tags->isNotEmpty())
        <div class="tags">
            @foreach ($note->tags as $tag)
                <span>{{ $tag->name }}</span>
            @endforeach
        </div>
    @endif

    <p class="content">{{ $note->content }}</p>

    <p class="date">Creada el {{ $note->created_at->format('d/m/Y') }}</p>
</body>
</html>