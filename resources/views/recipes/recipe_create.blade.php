<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>Recipe Management</title>
    </head>
    <body>
        <h1>レシピ作成</h1>
        <form action="/recipes/store" method="POST" enctype="multipart/form-data">
            @csrf
            <!-- タイトルの入力 -->
            <div class="title">
                <h2>タイトル</h2>
                <input type="text" name="recipes[title]" placeholder="レシピのタイトルを入力してください。"/><br>
                @foreach ($categories as $category)
                    <input class="dish category checkbox" type="checkbox" name=categories value="{{ $category->id }}" id="{{ $category->id }}"/>
                    <label for="{{ $category->id }}">{{ $category->name }}</label>
                @endforeach
            </div>
            
            <!-- 人数を入力 -->
            <input type="number" name="recipes[number]" placeholder="何人前？"/>
            
            <!-- 調理時間の入力 -->
            <div class="cooking_time">
                <h2>調理時間</h2>
                <input type="number" name="recipes[cooking_time]" placeholder="調理時間を入力してください"/>
            <!--    <select name="recipes[cooking_time_unit]" id="cooking_time_unit">-->
            <!--        <option value="">単位</option>-->
            <!--        <option value="1">秒</option>-->
            <!--        <option value="2">分</option>-->
            <!--        <option value="3">時間</option>-->
            <!--        <option value="4">日</option>-->
            <!--        <option value="5">カ月</option>-->
            <!--        <option value="6">年</option>-->
            <!--    </select><br>-->
            </div>
            
            <!-- 料理画像の入力 -->
            <div class="image">
                <h2>料理画像</h2>
                <input type="file" name="recipes[image]"/>
            </div>
            
            <!-- 材料の入力 -->
            <!--<div class="ingredients">-->
            <!--    <h2>材料</h2>-->
            <!--    <input type="text" name="ingredients[name1]" placeholder="材料を入力してください"/>-->
            <!--    <label for="category">カテゴリを選択：</label>-->
            <!--    <select name="category" id="category">-->
            <!--        <option value="">カテゴリを選んでください</option>-->
            <!--        @foreach ($ingredient_categories as $ingredient_category)-->
            <!--            <option value="{{ $ingredient_category->id }}">{{ $ingredient_category->category }}</option>-->
            <!--        @endforeach-->
            <!--    </select><br>-->
            <!--    <input type="text" name="ingredients[name2]" placeholder="材料を入力してください"/>-->
            <!--    <label for="category">カテゴリを選択：</label>-->
            <!--    <select name="category" id="category">-->
            <!--        <option value="">カテゴリを選んでください</option>-->
            <!--        @foreach ($ingredient_categories as $ingredient_category)-->
            <!--            <option value="{{ $ingredient_category->id }}">{{ $ingredient_category->category }}</option>-->
            <!--        @endforeach-->
            <!--    </select><br>-->
            <!--</div>-->
            
            <!-- 調理手順の入力 -->
            <div class="procedures" id="procedure-container">
                <h2>調理手順</h2>
                <label for="category1">手順1：</label>
                <textarea name="procedures[body1]" class='procedures' id="category1" placeholder="例）ケトルで沸かしたお湯を注ぎ、3分待つ。"></textarea><br>
                <label for="category2">手順2：</label>
                <textarea name="procedures[body2]" class='procedures' id="category2" placeholder="例）ケトルで沸かしたお湯を注ぎ、3分待つ。"></textarea>
            </div>
            
            <!-- テキストエリアを追加するボタン -->
            <!--<button type="button" id="add-procedure">手順を追加</button><br>-->
            
            <!-- 送信ボタン -->
            <input type="submit" value="store"/>
        </form>
        <div class="footer">
            <a href="/recipes">戻る</a>
        </div>
        <!-- JavaScriptを読み込む -->
        <!--<script src="{{ asset('/js/add_procedure.js') }}"></script>-->
    </body>
</html>