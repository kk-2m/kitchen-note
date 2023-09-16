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
        <img src="{{ asset($recipe->image) }}", alt='料理写真'>
        <h2 class='title'>
            {{ $recipe->title }}
        </h2>
        <div class='contents'>
            <p class='cooking_time'>調理時間 : {{ $recipe->cooking_time }}{{ $recipe->cooking_time_unit }}</p>
            <p class='categories'>カテゴリ : 
                @foreach ($recipe->categories as $category)
                    {{ $category->name }}
                @endforeach
            </p>
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