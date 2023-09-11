<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>Recipe Management</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>
    <body>
        <h1>レシピ詳細</h1>
        <h2 class='title'>
            {{ $recipe->title }}
        </h2>
        <div class='contents'>
            <h3 class='ingredients'>材料リスト</h3>
            <p class='ingredient'>材料1</p></p>
            <h3 class='cooking_procedures'>作り方</h3>
            @foreach ($procedures as $procedure)
                <p class='cooking_procedure'>{{ $procedure->body }}</p>
            @endforeach
        </div>
        <div class='footer'>
            <a href="/recipes">戻る</a>
        </div>
    </body>
</html>