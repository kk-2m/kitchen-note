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
        <div class='contents'>
            <img src="{{ asset($recipe->image) }}", alt='料理写真'>
            <h2 class='title'>{{ $recipe->title }}</h2>

            <p class='cooking_time'>調理時間 : {{ $recipe->cooking_time }}
                @if ( $recipe->cooking_time_unit  == 1) 秒
                @elseif ( $recipe->cooking_time_unit  == 2) 分
                @elseif ( $recipe->cooking_time_unit  == 3) 時間
                @elseif ( $recipe->cooking_time_unit  == 4) 日
                @elseif ( $recipe->cooking_time_unit  == 5) ヶ月
                @elseif ( $recipe->cooking_time_unit  == 6) 年
                @endif
            </p>

            <p class='categories'>カテゴリ : 
                @foreach ($recipe->categories as $category)
                    {{ $category->name }}
                @endforeach
            </p>

            <h3 class='ingrediens'>材料リスト({{ $recipe->number }}人前)</h3>
                @foreach ($recipe->ingredients as $ingredient)
                    <p class='ingredient'>
                        {{ $ingredient->name }}　{{ $ingredient->pivot->quantity }}
                        @if ($ingredient->pivot->unit)
                            {{ $ingredient->units->name }}
                        @else
                            [単位未設定]
                        @endif
                    </p>
                @endforeach

            <h3 class='cooking_procedures'>作り方</h3>
            @foreach ($procedures as $procedure)
                <p class='cooking_procedure'>{{ $procedure->body }}</p>
            @endforeach
        </div>
        <div class="edit"><a href="/recipes/{{ $recipe->id }}/edit">edit</a></div>
        <div class='footer'>
            <a href="/recipes">戻る</a>
        </div>
    </body>
</html>