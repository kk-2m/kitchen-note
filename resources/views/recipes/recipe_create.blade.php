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
            <input type="number" name="recipe[cooking_time]" placeholder="調理時間を入力してください" value="{{ old('recipe.cooking_time') }}" min="1"/>
            <p class="cooking_time_error" style="color:red">{{ $errors->first('recipe.cooking_time') }}</p><br>
            <select name="recipe[cooking_time_unit]" id="cooking_time_unit">
                <option value="">単位</option>
                <option value="1" @if ((int)old("recipe.cooking_time_unit") === 1) selected @endif>秒</option>
                <option value="2" @if ((int)old("recipe.cooking_time_unit") === 2) selected @endif>分</option>
                <option value="3" @if ((int)old("recipe.cooking_time_unit") === 3) selected @endif>時間</option>
                <option value="4" @if ((int)old("recipe.cooking_time_unit") === 4) selected @endif>日</option>
                <option value="5" @if ((int)old("recipe.cooking_time_unit") === 5) selected @endif>カ月</option>
                <option value="6" @if ((int)old("recipe.cooking_time_unit") === 6) selected @endif>年</option>
            </select><br>
        </div>
        
        <!-- カテゴリの入力 -->
        <div class='categories'>カテゴリ :
            @foreach ($categories as $category)
                <input class="dish_category_checkbox" type="checkbox" name="category[{{ $loop->iteration }}]" value="{{ $category->id }}" id="{{ $category->id }}" @if ((int)old("category.{$loop->iteration}") === $category->id) checked @endif/>
                <label for="{{ $category->id }}">{{ $category->name }}</label>
            @endforeach
        </div>
        
        <!-- 人数を入力 -->
        <div class='number'>
            <h4>何人前？</h4>
            <input type="number" name="recipe[number]" placeholder="人数を入力してください" value="{{ old('recipe.number') }}" min="1" max="100"/>人前
            <p class="title_error" style="color:red">{{ $errors->first('recipe.number') }}</p><br>
        </div>
        
        <!-- 材料の入力 -->
        <div class="ingredients" id="ingredient-container" data-ingredientcategories='@json($ingredient_categories)' data-units='@json($units)'>
            <h2>材料</h2>
            @empty (old('ingredient') && old('ingredient_recipe'))
                <div class="ingredient-item" id="ingredient-item1">
                    <h3 class="ingredient_title">材料1</h3>
                    <div class="ingredient_category">
                        <label for="ingredient_category1">　カテゴリを選択：</label>
                        <select name="ingredient[1][ingredient_category_id]" id="select_ingredient_category1">
                            <option value="">カテゴリを選んでください</option>
                            @foreach ($ingredient_categories as $ingredient_category)
                                <option value="{{ $ingredient_category->id }}">{{ $ingredient_category->category }}</option>
                            @endforeach
                        </select><br>
                        <p class="ingredient_category_error" style="color:red">{{ $errors->first('ingredient.1.ingredient_category_id') }}</p>
                    </div>
                    <div class="ingredient_name">
                        <label for="ingredient_name1">　材料名：</label>
                        <input type="text" name="ingredient[1][name]" id="input_ingredient_name1" placeholder="材料を入力してください" value="{{ old('ingredient.1.name') }}"/>
                        <p class="ingredient_error" style="color:red">{{ $errors->first('ingredient.1.name') }}</p>
                    </div>
                    <div class="ingredient_qantity">
                        <label for="ingredient_quantity1">　量：</label>
                        <input type="number" name="ingredient_recipe[1][quantity]" id="input_ingredient_quantity1" placeholder="必要な量を入力してください" value="{{ old('ingredient_recipe.1.quantity') }}" min="1" max="99999999"/>
                        <p class="ingredient_quantity_error" style="color:red">{{ $errors->first('ingredient_recipe.1.quantity') }}</p>
                    </div>
                    <div class="ingredient_unit">
                        <label for="ingredient_unit1">　単位を選択：</label>
                        <select name="ingredient_recipe[1][unit_id]" id="select_ingredient_unit1">
                            <option value="">単位を選んでください</option>
                            @foreach ($units as $unit)
                                <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                            @endforeach
                        </select><br>
                        <p class="unit_error" style="color:red">{{ $errors->first('ingredient_recipe.1.unit_id') }}</p>
                    </div>
                    <button type="button" class="ingredient-delete-button" data-id="1">削除</button>
                </div>
                
                <div class="ingredient-item" id="ingredient-item2">
                    <h3 class="ingredient_title">材料2</h3>
                    <div class="ingredient_category">
                        <label for="ingredient_category2">　カテゴリを選択：</label>
                        <select name="ingredient[2][ingredient_category_id]" id="select_ingredient_category2">
                            <option value="">カテゴリを選んでください</option>
                            @foreach ($ingredient_categories as $ingredient_category)
                                <option value="{{ $ingredient_category->id }}">{{ $ingredient_category->category }}</option>
                            @endforeach
                        </select><br>
                        <p class="ingredient_category_error" style="color:red">{{ $errors->first('ingredient.2.ingredient_category_id') }}</p>
                    </div>
                    <div class="ingredient_name">
                        <label for="ingredient_name2">　材料名：</label>
                        <input type="text" name="ingredient[2][name]" id="input_ingredient_name2" placeholder="材料を入力してください" value="{{ old('ingredient.2.name') }}"/>
                        <p class="ingredient_error" style="color:red">{{ $errors->first('ingredient.2.name') }}</p>
                    </div>
                    <div class="ingredient_qantity">
                        <label for="ingredient_quantity2">　量：</label>
                        <input type="text" name="ingredient_recipe[2][quantity]" id="input_ingredient_quantity2" placeholder="必要な量を入力してください" value="{{ old('ingredient_recipe.2.quantity') }}" min="1" max="99999999"/>
                        <p class="ingredient_quantity_error" style="color:red">{{ $errors->first('ingredient_recipe.2.quantity') }}</p>
                    </div>
                    <div class="ingredient_unit">
                        <label for="ingredient_unit2">　単位を選択：</label>
                        <select name="ingredient_recipe[2][unit_id]" id="select_ingredient_unit2">
                            <option value="">　単位を選んでください</option>
                            @foreach ($units as $unit)
                                <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                            @endforeach
                        </select><br>
                        <p class="unit_error" style="color:red">{{ $errors->first('ingredient_recipe.2.unit_id') }}</p>
                    </div>
                    <button type="button" class="ingredient-delete-button" data-id="2">削除</button>
                </div>
            @else
                @php
                    // ingredientが空ならingredient_recipe, そうでないならingredient
                    // foreachで回す回数を決めたいだけなので、エラーが取得できればなんでもいい
                    // そのため、両方がエラーの可能性考えない
                    $Error = empty(old('ingredient')) ? old('ingredient_recipe') : old('ingredient');
                @endphp
                @foreach ($Error as $key => $value)
                    <div class="ingredient-item" id="ingredient-item{{ $key }}">
                        <h3 class="ingredient_title">材料{{ $key }}</h3>
                        <div class="ingredient_category">
                            <label for="ingredient_category{{ $key }}">　カテゴリを選択：</label>
                            <select name="ingredient[{{ $key }}][ingredient_category_id]" id="select_ingredient_category{{ $key }}">
                                <option value="">カテゴリを選んでください</option>
                                @foreach ($ingredient_categories as $ingredient_category)
                                    <option value="{{ $ingredient_category->id }}" @if ((int)old("ingredient.{$key}.ingredient_category_id") === $ingredient_category->id) selected @endif>{{ $ingredient_category->category }}</option>
                                @endforeach
                            </select><br>
                            <p class="ingredient_category_error" style="color:red">{{ $errors->first("ingredient.{$key}.ingredient_category_id") }}</p>
                        </div>
                        <div class="ingredient_name">
                            <label for="ingredient_name{{ $key }}">　材料名：</label>
                            <input type="text" name="ingredient[{{ $key }}][name]" id="input_ingredient_name{{ $key }}" placeholder="材料を入力してください" value="{{ old("ingredient.{$key}.name") }}"/>
                            <p class="ingredient_error" style="color:red">{{ $errors->first("ingredient.{$key}.name") }}</p>
                        </div>
                        <div class="ingredient_qantity">
                            <label for="ingredient_quantity{{ $key }}">　量：</label>
                            <input type="text" name="ingredient_recipe[{{ $key }}][quantity]" id="input_ingredient_quantity{{ $key }}" placeholder="必要な量を入力してください" value="{{ old("ingredient_recipe.{$key}.quantity") }}" min="1" max="99999999"/>
                            <p class="ingredient_quantity_error" style="color:red">{{ $errors->first("ingredient_recipe.{$key}.quantity") }}</p>
                        </div>
                        <div class="ingredient_unit">
                            <label for="ingredient_unit{{ $key }}">　単位を選択：</label>
                            <select name="ingredient_recipe[{{ $key }}][unit_id]" id="select_ingredient_unit{{ $key }}">
                                <option value="">　単位を選んでください</option>
                                @foreach ($units as $unit)
                                    <option value="{{ $unit->id }}" @if ((int)old("ingredient_recipe.{$key}.unit_id") == $unit->id) selected @endif>{{ $unit->name }}</option>
                                @endforeach
                            </select><br>
                            <p class="unit_error" style="color:red">{{ $errors->first("ingredient_recipe.{$key}.unit_id") }}</p>
                        </div>
                        <button type="button" class="ingredient-delete-button" data-id={{ $key }}>削除</button>
                    </div>
                @endforeach
            @endempty
        </div>
        
        <button type="button" id="add-ingredient">入力欄を増やす</button><br>
        
        <!-- 調理手順の入力 -->
        <div class="procedures" id="procedure-container">
            <h2>調理手順</h2>
            @empty (old('procedure'))
                <div class="procedure-item" id="procedure1">
                    <div class="textarea">
                        <label for="procedure1">手順1：</label>
                        <textarea name="procedure[1][body]" rows="4" cols="40" class='procedures' id="form1" placeholder="例）ケトルで沸かしたお湯を注ぎ、3分待つ。">{{ old('procedure.1.body') }}</textarea><br>
                    </div>
                    <p class="procedure_error" style="color:red">{{ $errors->first('procedure.1.body') }}</p>
                    <button type="button" class="procedure-delete-button" data-id="1">削除</button>
                </div>
                
                <div class="procedure-item" id="procedure2">
                    <div class="textarea">
                        <label for="procedure2">手順2：</label>
                        <textarea name="procedure[2][body]" rows="4" cols="40" class='procedures' id="form2" placeholder="例）ケトルで沸かしたお湯を注ぎ、3分待つ。">{{ old('procedure.2.body') }}</textarea>
                    </div>
                    <p class="procedure_error" style="color:red">{{ $errors->first('procedure.2.body') }}</p>
                    <button type="button" class="procedure-delete-button" data-id="2">削除</button>
                </div>
            @else
                @foreach (old('procedure') as $key => $value)
                    <div class="procedure-item" id="procedure{{ $key }}">
                        <div class="textarea">
                            <label for="procedure{{ $key }}">手順{{ $key }}：</label>
                            <textarea name="procedure[{{ $key }}][body]" rows="4" cols="40" class='procedures' id="form{{ $key }}" placeholder="例）ケトルで沸かしたお湯を注ぎ、3分待つ。">{{ old("procedure.{$key}.body") }}</textarea>
                        </div>
                        <p class="procedure_error" style="color:red">{{ $errors->first("procedure.{$key}.body") }}</p>
                        <button type="button" class="procedure-delete-button" data-id={{ $key }}>削除</button>
                    </div>
                @endforeach
            @endempty
        </div>
        
        <!-- テキストエリアを追加するボタン -->
        <button type="button" id="add-procedure">手順を追加</button><br>
        
        <!-- 送信ボタン -->
        <input type="submit" value="保存"/>
    </form>
    <div class="footer">
        <a href="/recipes">戻る</a>
    </div>
</x-app-layout>