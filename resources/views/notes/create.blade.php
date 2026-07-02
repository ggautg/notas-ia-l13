<!DOCTYPE html>
<html>

<head>
    <title>Nueva Nota</title>
</head>

<body>
    <h1>Nueva Nota</h1>

    <form action="/notes" method="post">
        @csrf
        <div>
            <label for="title">Título</label><br>
            <input type="text" name="title" id="title">
        </div>
        <div>
            <label for="content">Contenido</label><br>
            <textarea name="content" id="content" rows="5"></textarea>
        </div>

        <button type="submit">Guardar Nota</button>
    </form>
    <a href="/notes">← Volver a la lista</a>
</body>
</html>