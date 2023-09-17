<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>Recipe Management</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>
    <body>
        <h1 class="title">編集画面</h1>
        <div class="contents">
            <form action="/recipes/{{ $recipe->id }}" method="POST">
                @csrf
                @method('PUT')
                
                <!-- 料理写真の編集 -->
                <img src="{{ asset($recipe->image) }}", alt='料理写真'>
                <div class="image">
                    <h2>料理写真</h2>
                    <input type="file" name="recipe[image]" value='{{ $recipe->image }}'/>
                </div>
                
                <!-- タイトルの編集 -->
                <h2>タイトル</h2>
                <input class="title" type='text' name='recipe[title]' value="{{ $recipe->title }}"/>
                
                 <!-- カテゴリの編集 -->
                <p class='categories'>カテゴリ : 
                    @foreach ($categories as $category)
                        
                        <!-- recipesからcategoriesにアクセスしてcategoryのidを持っているか識別 -->
                        @if ($recipe->categories->contains('id', $category->id))
                            <input class="dish_category_checkbox" type="checkbox" name="category{{ $loop->iteration }}" value="{{ $category->id }}" id="{{ $category->id }}" checked/>
                        @else
                            <input class="dish_category_checkbox" type="checkbox" name="category{{ $loop->iteration }}" value="{{ $category->id }}" id="{{ $category->id }}"/>
                        @endif
                            <label for="{{ $category->id }}">{{ $category->name }}</label>
                    @endforeach
                </p>
                
                <!-- 調理時間の編集 -->
                <div class="cooking_time">
                    <h2>調理時間</h2>
                    <input type="number" name="recipe[cooking_time]" value="{{ $recipe->cooking_time }}"/>
                </div>
                
                <!-- 材料の編集 -->
                <h3 class='ingrediens'>材料リスト</h3>
                <input type="number" name="recipe[number]" value="{{ $recipe->number }}" placeholder="何人前？"/>人前
                <!--@foreach ($recipe->ingredients as $ingredient)-->
                <!--    <p class='ingredient'>-->
                <!--        {{ $ingredient->name }}　{{ $ingredient->pivot->quantity }}-->
                <!--        @if ($ingredient->pivot->unit)-->
                <!--            {{ $ingredient->units->name }}-->
                <!--        @else-->
                <!--            [単位未設定]-->
                <!--        @endif-->
                <!--    </p>-->
                <!--@endforeach-->
                
                <!-- 調理手順の入力 -->
                <div class="procedures" id="procedure-container">
                    <h2>調理手順</h2>
                    @foreach ($recipe->procedures as $procedure)
                        <label for="procedure{{ $loop->iteration }}">手順{{ $loop->iteration }}：</label>
                        <textarea name="procedures[body{{ $loop->iteration }}]" class='procedures' id="procedure{{ $loop->iteration }}" placeholder="例）ケトルで沸かしたお湯を注ぎ、3分待つ。">{{ $procedure->body }}</textarea><br>
                    @endforeach
                </div>
                
                <input type="submit" value="保存">
            </form>
        </div>
    </body>
</html>