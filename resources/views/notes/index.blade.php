<!DOCTYPE html>
<html>
    <head>
        <title>Mis Notas</title>
    </head>
    <body>
        <h1>Mis Notas</h1>
        <a href="/notes/create">+ Nueva Nota</a>

        <ul>
            @foreach ($notes as $note )
                <li>
                    <strong>{{ $note->title }}</strong>
                    <p>{{ $note->content }}</p>
                </li>
            @endforeach
        </ul>
    </body>
</html>