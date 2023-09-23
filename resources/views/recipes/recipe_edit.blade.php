<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('レシピ編集') }}
        </h2>
    </x-slot>
    <body>
        <div class="contents">
            <form action="/recipes/{{ $recipe->id }}" method="POST" enctype="multipart/form-data">
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
                <p class="title_error" style="color:red">{{ $errors->first('recipe.title') }}</p><br>
                
                <!-- 調理時間の編集 -->
                <div class="cooking_time">
                    <h2>調理時間</h2>
                    <input type="number" name="recipe[cooking_time]" value="{{ $recipe->cooking_time }}"/>
                    <p class="cooking_time_error" style="color:red">{{ $errors->first('recipe.cooking_time') }}</p><br>
                </div>
                
                 <!-- カテゴリの編集 -->
                <div class='categories'>カテゴリ : 
                    @foreach ($categories as $category)
                        <!-- recipesからcategoriesにアクセスしてcategoryのidを持っているか識別 -->
                        @if ($recipe->categories->contains('id', $category->id))
                            <input class="dish_category_checkbox" type="checkbox" name="category[id{{ $loop->iteration }}]" value="{{ $category->id }}" id="{{ $category->id }}" checked/>
                        @else
                            <input class="dish_category_checkbox" type="checkbox" name="category[id{{ $loop->iteration }}]" value="{{ $category->id }}" id="{{ $category->id }}"/>
                        @endif
                            <label for="{{ $category->id }}">{{ $category->name }}</label>
                    @endforeach
                </div>
                
                <!-- 材料の編集 -->
                <h3 class='ingrediens'>材料リスト</h3>
                <input type="number" name="recipe[number]" value="{{ $recipe->number }}" placeholder="何人前？"/>人前
                <p class="ingredient_error" style="color:red">{{ $errors->first("ingredient.number") }}</p><br>
                @foreach ($recipe->ingredients as $ingredient)
                    <p class='ingredient'>
                        <label for="ingredient{{ $loop->iteration }}">材料{{ $loop->iteration }}：</label>
                        <input type="text" name="ingredient[name{{ $loop->iteration }}]"　id="ingredient{{ $loop->iteration }}" placeholder="材料を入力してください" value="{{ $ingredient->name }}"/>
                        <p class="ingredient_error" style="color:red">{{ $errors->first('ingredient.name2') }}</p>
                        {{ $ingredient->pivot->quantity }} 
                        
                        {{ $ingredient->pivot->unit->name }}
                    </p>
                @endforeach
                
                <!-- 調理手順の編集 -->
                <div class="procedures" id="procedure-container">
                    <h2>調理手順</h2>
                    @foreach ($recipe->procedures as $procedure)
                        <label for="procedure{{ $loop->iteration }}">手順{{ $loop->iteration }}：</label>
                        <textarea name="procedure[body{{ $loop->iteration }}]" class='procedures' id="procedure{{ $loop->iteration }}" placeholder="例）ケトルで沸かしたお湯を注ぎ、3分待つ。">{{ $procedure->body }}</textarea>
                        <p class="title_error" style="color:red">{{ $errors->first("recipe.number{$loop->iteration}") }}</p><br>
                    @endforeach
                </div>
                
                <input type="submit" value="保存">
            </form>
        </div>
    </body>
</x-app-layout>