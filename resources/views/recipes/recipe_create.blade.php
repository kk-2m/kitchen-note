<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('レシピ作成') }}
        </h2>
    </x-slot>
    <!--　/recipes/storeにフォームのデータが渡され、web.phpで指定したRecipeControllerのstoreメソッドが実行される　-->
    <form action="{{ route('recipe_store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <!-- 料理写真の入力 -->
        <div class="image">
            <h2>料理写真</h2>
            <input type="file" name="recipe[image]"/>
        </div>
        
        <!-- タイトルの入力 -->
        <div class="title">
            <h2>タイトル</h2>
            <input type="text" name="recipe[title]" placeholder="レシピのタイトルを入力してください。" value="{{ old('recipe.title') }}"/>
            <p class="title_error" style="color:red">{{ $errors->first('recipe.title') }}</p><br>
        </div>
        
        <!-- 調理時間の入力 -->
        <div class="cooking_time">
            <h2>調理時間</h2>
            <input type="number" name="recipe[cooking_time]" placeholder="調理時間を入力してください" value="{{ old('recipe.cooking_time') }}" min="0"/>
            <p class="cooking_time_error" style="color:red">{{ $errors->first('recipe.cooking_time') }}</p><br>
            <select name="recipe[cooking_time_unit]" id="cooking_time_unit">
                <option value="">単位</option>
                <option value="1">秒</option>
                <option value="2">分</option>
                <option value="3">時間</option>
                <option value="4">日</option>
                <option value="5">カ月</option>
                <option value="6">年</option>
            </select><br>
        </div>
        
        <!-- カテゴリの入力 -->
        <div class='categories'>カテゴリ :
            @foreach ($categories as $category)
                <input class="dish_category_checkbox" type="checkbox" name="category[{{ $loop->iteration }}]" value="{{ $category->id }}" id="{{ $category->id }}"/>
                <label for="{{ $category->id }}">{{ $category->name }}</label>
            @endforeach
        </div>
        
        <!-- 人数を入力 -->
        <div class='number'>
            <h4>何人前？</h4>
            <input type="number" name="recipe[number]" placeholder="人数を入力してください" value="{{ old('recipe.number') }}" min="0" max="100"/>人前
            <p class="title_error" style="color:red">{{ $errors->first('recipe.number') }}</p><br>
        </div>
        
        <!-- 材料の入力 -->
        <div class="ingredients" id="ingredient-container">
            <h2>材料</h2>
            <label for="ingredient1">材料1：</label>
            <input type="text" name="ingredient[1][name]" id="ingredient1" placeholder="材料を入力してください" value="{{ old('ingredient.1.name') }}"/>
            <p class="ingredient_error" style="color:red">{{ $errors->first('ingredient.1.name') }}</p>
            <label for="ingredient_quantity1">　量：</label>
            <input type="number" name="ingredient_recipe[1][quantity]" id="ingredient_quantity1" placeholder="必要な量を入力してください" value="{{ old('ingredient_recipe.1.quantity') }}" min="0"/>
            <p class="ingredient_quantity_error" style="color:red">{{ $errors->first('ingredient_recipe.1.quantity') }}</p>
            <label for="unit1">　単位を選択：</label>
            <select name="ingredient_recipe[1][unit_id]" id="unit1">
                <option value="">単位を選んでください</option>
                @foreach ($units as $unit)
                    <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                @endforeach
            </select><br>
            <p class="unit_error" style="color:red">{{ $errors->first('ingredient_recipe.1.unit_id') }}</p>
            
            <label for="ingredient_category1">　カテゴリを選択：</label>
            <select name="ingredient[1][ingredient_category_id]" id="ingredient_category1">
                <option value="">カテゴリを選んでください</option>
                @foreach ($ingredient_categories as $ingredient_category)
                    <option value="{{ $ingredient_category->id }}">{{ $ingredient_category->category }}</option>
                @endforeach
            </select><br>
            <p class="ingredient_category_error" style="color:red">{{ $errors->first('ingredient.1.ingredient_category_id') }}</p>
            
             <label for="ingredient2">材料2：</label>
            <input type="text" name="ingredient[2][name]"　id="ingredient2" placeholder="材料を入力してください" value="{{ old('ingredient.2.name') }}"/>
            <p class="ingredient_error" style="color:red">{{ $errors->first('ingredient.2.name') }}</p>
            <label for="ingredient_quantity2">　量：</label>
            <input type="text" name="ingredient_recipe[2][quantity]" id="ingredient_quantity2" placeholder="必要な量を入力してください" value="{{ old('ingredient_recipe.2.quantity') }}"/>
            <p class="ingredient_quantity_error" style="color:red">{{ $errors->first('ingredient_recipe.2.quantity') }}</p>
            <label for="unit2">　単位を選択：</label>
            <select name="ingredient_recipe[2][unit_id]" id="unit2">
                <option value="">　単位を選んでください</option>
                @foreach ($units as $unit)
                    <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                @endforeach
            </select><br>
            <p class="unit_error" style="color:red">{{ $errors->first('ingredient_recipe.2.unit_id') }}</p>

            <label for="ingredient_category2">　カテゴリを選択：</label>
            <select name="ingredient[2][ingredient_category_id]" id="ingredient_category2">
                <option value="">カテゴリを選んでください</option>
                @foreach ($ingredient_categories as $ingredient_category)
                    <option value="{{ $ingredient_category->id }}">{{ $ingredient_category->category }}</option>
                @endforeach
            </select><br>
            <p class="ingredient_category_error" style="color:red">{{ $errors->first('ingredient.2.ingredient_category_id') }}</p>
            <button type="button" id="add-ingredient">入力欄を増やす</button><br>
        </div>
        
        <!-- 調理手順の入力 -->
        <div class="procedures" id="procedure-container">
            <h2>調理手順</h2>
            <label for="procedure1">手順1：</label>
            <textarea name="procedure[1][body]" rows="4" cols="40" class='procedures' id="procedure1" placeholder="例）ケトルで沸かしたお湯を注ぎ、3分待つ。">{{ old('procedure.1.body') }}</textarea><br>
            <p class="procedure_error" style="color:red">{{ $errors->first('procedure.1.body') }}</p>
            
            <label for="procedure2">手順2：</label>
            <textarea name="procedure[2][body]" rows="4" cols="40" class='procedures' id="procedure2" placeholder="例）ケトルで沸かしたお湯を注ぎ、3分待つ。">{{ old('procedure.2.body') }}</textarea>
            <p class="procedure_error" style="color:red">{{ $errors->first('procedure.2.body') }}</p>
        </div>
        
        <!-- テキストエリアを追加するボタン -->
        <!--<button type="button" id="add-procedure">手順を追加</button><br>-->
        
        <!-- 送信ボタン -->
        <input type="submit" value="保存"/>
    </form>
    <div class="footer">
        <a href="/recipes">戻る</a>
    </div>
</x-app-layout>