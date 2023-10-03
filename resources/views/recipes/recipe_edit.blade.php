<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('レシピ編集') }}
        </h2>
    </x-slot>
    <div class="contents">
        <form action="/recipes/{{ $recipe->id }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <!-- 料理写真の編集 -->
            <div class="image">
                @if ($recipe->image != '')
                    <img src="{{ asset($recipe->image) }}">
                @else
                    <img src="{{ \Storage::url('dish_image/noimage.png') }}", alt='料理写真' width="50%">
                @endif
                <h2>料理写真</h2>
                <input type="file" name="recipe[image]"/>
            </div>
            
            <!-- タイトルの編集 -->
            <div class="title">
                <h2>タイトル</h2>
                <input type='text' name='recipe[title]' placeholder="レシピのタイトルを入力してください。" value="{{ old('recipe.title',$recipe->title) }}"/>
                <p class="title_error" style="color:red">{{ $errors->first('recipe.title') }}</p><br>
            </div>
            
            <!-- 調理時間の編集 -->
            <div class="cooking_time">
                <h2>調理時間</h2>
                <input type="number" name="recipe[cooking_time]" placeholder="調理時間を入力してください" value="{{ old('recipe.cooking_time',$recipe->cooking_time) }}"/>
                <p class="cooking_time_error" style="color:red">{{ $errors->first('recipe.cooking_time') }}</p><br>
                <select name="recipe[cooking_time_unit]" id="cooking_time_unit">
                    <option value="">単位</option>
                    <option value="1" @if ($recipe->cooking_time_unit === 1) selected @endif>秒</option>
                    <option value="2" @if ($recipe->cooking_time_unit === 2) selected @endif>分</option>
                    <option value="3" @if ($recipe->cooking_time_unit === 3) selected @endif>時間</option>
                    <option value="4" @if ($recipe->cooking_time_unit === 4) selected @endif>日</option>
                    <option value="5" @if ($recipe->cooking_time_unit === 5) selected @endif>カ月</option>
                    <option value="6" @if ($recipe->cooking_time_unit === 6) selected @endif>年</option>
                </select><br>
            </div>
            
             <!-- カテゴリの編集 -->
            <div class='categories'>カテゴリ : 
                @foreach ($categories as $category)
                    <!-- recipesからcategoriesにアクセスしてcategoryのidを持っているか識別 -->
                    <input type="hidden" name="category[{{ $loop->iteration }}]"/>
                    @if ($recipe->categories->contains('id', $category->id))
                        <input class="dish_category_checkbox" type="checkbox" name="category[{{ $loop->iteration }}]" value="{{ $category->id }}" id="{{ $category->id }}" checked/>
                    @else
                        <input class="dish_category_checkbox" type="checkbox" name="category[{{ $loop->iteration }}]" value="{{ $category->id }}" id="{{ $category->id }}"/>
                    @endif
                        <label for="{{ $category->id }}">{{ $category->name }}</label>
                @endforeach
            </div>
            
            <!-- 人数を編集 -->
            <div class='number'>
                <h4>何人前？</h4>
                <input type="number" name="recipe[number]" placeholder="人数を入力してください" value="{{ old('recipe.number', $recipe->number) }}"/>人前
                <p class="title_error" style="color:red">{{ $errors->first('recipe.number') }}</p><br>
            </div>
            
            <!-- 材料の編集 -->
            <div class="ingrediens" id="ingredient-container">
                <h3>材料</h2>
            </div>
            @foreach ($recipe->ingredients as $ingredient)
                <label for="ingredient{{ $loop->iteration }}">材料{{ $loop->iteration }}：</label>
                <input type="text" name="ingredient[{{ $loop->iteration }}][name]"　id="ingredient{{ $loop->iteration }}" placeholder="材料を入力してください" value="{{ old("ingredient.{$loop->iteration}.name", $ingredient->name) }}"/>
                <p class="ingredient_error" style="color:red">{{ $errors->first("ingredient.{$loop->iteration}.name") }}</p>
                <label for="ingredient_quantity{{ $loop->iteration }}">　量：</label>
                <input type="text" name="ingredient_recipe[{{ $loop->iteration }}][quantity]" id="ingredient_quantity{{ $loop->iteration }}" placeholder="必要な量を入力してください" value="{{ old("ingredient_recipe.{$loop->iteration}.quantity",$ingredient->pivot->quantity) }}"/>
                <p class="ingredient_quantity_error" style="color:red">{{ $errors->first("ingredient_recipe.{$loop->iteration}.quantity") }}</p>
                <label for="unit{{ $loop->iteration }}">　単位を選択：</label>
                <select name="ingredient_recipe[{{ $loop->iteration }}][unit_id]" id="unit{{ $loop->iteration }}">
                    <option value="">単位を選んでください</option>
                    @foreach ($units as $unit)
                        <option value="{{ $unit->id }}" @if ($ingredient->pivot->unit_id === $unit->id) selected @endif>{{ $unit->name }}</option>
                    @endforeach
                </select><br>
                <p class="unit_error" style="color:red">{{ $errors->first("ingredient_recipe.{$loop->iteration}.unit_id") }}</p>
                
                <label for="ingredient_category{{ $loop->iteration }}">　カテゴリを選択：</label>
                <select name="ingredient[{{ $loop->iteration }}][ingredient_category_id]" id="ingredient_category{{ $loop->iteration }}">
                    <option value="">カテゴリを選んでください</option>
                    @foreach ($ingredient_categories as $ingredient_category)
                        <option value="{{ $ingredient_category->id }}" @if ($ingredient->ingredient_category_id === $ingredient_category->id) selected @endif>{{ $ingredient_category->category }}</option>
                    @endforeach
                </select><br>
                <p class="ingredient_category_error" style="color:red">{{ $errors->first("ingredient.{$loop->iteration}.ingredient_category_id") }}</p>
            @endforeach
            
            <!-- 調理手順の編集 -->
            <div class="procedures" id="procedure-container">
                <h2>調理手順</h2>
                @foreach ($recipe->procedures as $procedure)
                    <label for="procedure{{ $loop->iteration }}">手順{{ $loop->iteration }}：</label>
                    <textarea name="procedure[{{ $loop->iteration }}][body]" rows="4" cols="40" class='procedures' id="procedure{{ $loop->iteration }}" placeholder="例）ケトルで沸かしたお湯を注ぎ、3分待つ。">{{ old("procedure.{$loop->iteration}.body", $procedure->body) }}</textarea>
                    <p class="title_error" style="color:red">{{ $errors->first("procedure.{$loop->iteration}.body") }}</p>
                @endforeach
            </div>
            
            <input type="submit" value="更新">
        </form>
        <div class='footer'>
            <a href="/recipes/{{ $recipe->id }}">戻る</a>
        </div>
    </div>
</x-app-layout>