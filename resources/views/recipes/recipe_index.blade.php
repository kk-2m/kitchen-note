<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>Recipe Management</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>
    <body>
        <h1>レシピ一覧</h1>
        <div class='recipes'>
            <a href='/posts/create'>create</a>
            @foreach ($recipes as $recipe)
                <div class='recipe'>
                    <h2 class='title'>
                        <a href="/recipes/{{ $recipe->id }}">{{ $recipe->title }}</a>
                    </h2>
                    <p class='body'>材料リスト</p>
                </div>
            @endforeach
        </div>
        <div class='paginate'>
            {{ $recipes->links() }}
        </div>
    </body>
</html>