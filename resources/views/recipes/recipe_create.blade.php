<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>Recipe Management</title>
    </head>
    <body>
        <h1>レシピ作成</h1>
        <form action="/recipes/store" method="POST">
            @csrf
            <div class="title">
                <h2>タイトル</h2>
                <input type="text" name="recipes[title]" placeholder="レシピのタイトルを入力してください。"/>
            </div>
            <div class="property">
                <h2>調理時間</h2>
                <input type="number" name="recipes[cooking_time]" placeholder="調理時間を入力してください"/>
                <input type="text" name="recipes[cooking_time_unit]" placeholder="s, m, h, d"/>
            </div>
            <div class="image">
                <h2>料理画像</h2>
                <input type="text" name="recipes[image]" placeholder="料理画像のパス"/>
            </div>
            <div class="ingredients">
                <h2>材料</h2>
                <input type="text" name="ingredients[name1]" placeholder="材料を入力してください"/>
                <input type="text" name="ingredients[name2]" placeholder="材料を入力してください"/>
            </div>
            <div class="body">
                <h2>調理手順</h2>
                <textarea name="procedures[body1]" placeholder="例）ケトルで沸かしたお湯を注ぎ、3分待つ。"></textarea><br>
                <textarea name="procedures[body2]" placeholder="例）ケトルで沸かしたお湯を注ぎ、3分待つ。"></textarea>
            </div>
            <input type="submit" value="store"/>
        </form>
        <div class="footer">
            <a href="/recipes">戻る</a>
        </div>
    </body>
</html>