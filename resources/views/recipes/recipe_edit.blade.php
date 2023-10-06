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
                    <option value="1" @if ((int)old("recipe.cooking_time_unit", $recipe->cooking_time_unit) === 1) selected @endif>秒</option>
                    <option value="2" @if ((int)old("recipe.cooking_time_unit", $recipe->cooking_time_unit) === 2) selected @endif>分</option>
                    <option value="3" @if ((int)old("recipe.cooking_time_unit", $recipe->cooking_time_unit) === 3) selected @endif>時間</option>
                    <option value="4" @if ((int)old("recipe.cooking_time_unit", $recipe->cooking_time_unit) === 4) selected @endif>日</option>
                    <option value="5" @if ((int)old("recipe.cooking_time_unit", $recipe->cooking_time_unit) === 5) selected @endif>カ月</option>
                    <option value="6" @if ((int)old("recipe.cooking_time_unit", $recipe->cooking_time_unit) === 6) selected @endif>年</option>
                </select><br>
            </div>
            
             <!-- カテゴリの編集 -->
            <div class='categories'>カテゴリ : 
                @empty (old('category'))
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
                @else
                    @foreach ($categories as $category)
                        <!-- recipesからcategoriesにアクセスしてcategoryのidを持っているか識別 -->
                        <input type="hidden" name="category[{{ $loop->iteration }}]"/>
                        @if ((int)old("category.{$loop->iteration}") === $category->id)
                            <input class="dish_category_checkbox" type="checkbox" name="category[{{ $loop->iteration }}]" value="{{ $category->id }}" id="{{ $category->id }}" checked/>
                        @else
                            <input class="dish_category_checkbox" type="checkbox" name="category[{{ $loop->iteration }}]" value="{{ $category->id }}" id="{{ $category->id }}"/>
                        @endif
                            <label for="{{ $category->id }}">{{ $category->name }}</label>
                    @endforeach
                @endempty
            </div>
            
            <!-- 人数を編集 -->
            <div class='number'>
                <h4>何人前？</h4>
                <input type="number" name="recipe[number]" placeholder="人数を入力してください" value="{{ old('recipe.number', $recipe->number) }}"/>人前
                <p class="title_error" style="color:red">{{ $errors->first('recipe.number') }}</p><br>
            </div>
            
            <!-- 材料の編集 -->
            <div class="ingredients" id="ingredient-container" data-ingredientcategories='@json($ingredient_categories)' data-units='@json($units)'>
                <h2>材料</h2>
                @empty (old('ingredient') && old('ingredient_recipe'))
                    @foreach ($recipe->ingredients as $ingredient)
                        <div class="ingredient-item" id="ingredient-item{{ $loop->iteration }}">
                            <h3 class="ingredient_title">材料{{ $loop->iteration }}</h3>
                            <div class="ingredient_category">
                                <label for="ingredient_category{{ $loop->iteration }}">　カテゴリを選択：</label>
                                <select name="ingredient[{{ $loop->iteration }}][ingredient_category_id]" id="select_ingredient_category{{ $loop->iteration }}">
                                    <option value="">カテゴリを選んでください</option>
                                    @foreach ($ingredient_categories as $ingredient_category)
                                        <option value="{{ $ingredient_category->id }}" @if ($ingredient->ingredient_category_id === $ingredient_category->id) selected @endif>{{ $ingredient_category->category }}</option>
                                    @endforeach
                                </select><br>
                                <p class="ingredient_category_error" style="color:red">{{ $errors->first("ingredient.{$loop->iteration}.ingredient_category_id") }}</p>
                            </div>
                            <div class="ingredient_name">
                                <label for="ingredient_name{{ $loop->iteration }}">　材料名：</label>
                                <input type="text" name="ingredient[{{ $loop->iteration }}][name]" id="input_ingredient_name{{ $loop->iteration }}" placeholder="材料を入力してください" value="{{ $ingredient->name }}"/>
                                <p class="ingredient_error" style="color:red">{{ $errors->first("ingredient.{$loop->iteration}.name") }}</p>
                            </div>
                            <div class="ingredient_qantity">
                                <label for="ingredient_quantity{{ $loop->iteration }}">　量：</label>
                                <input type="text" name="ingredient_recipe[{{ $loop->iteration }}][quantity]" id="input_ingredient_quantity{{ $loop->iteration }}" placeholder="必要な量を入力してください" value="{{ $ingredient->pivot->quantity }}" min="1" max="99999999"/>
                                <p class="ingredient_quantity_error" style="color:red">{{ $errors->first("ingredient_recipe.{$loop->iteration}.quantity") }}</p>
                            </div>
                            <div class="ingredient_unit">
                                <label for="ingredient_unit{{ $loop->iteration }}">　単位を選択：</label>
                                <select name="ingredient_recipe[{{ $loop->iteration }}][unit_id]" id="select_ingredient_unit{{ $loop->iteration }}">
                                    <option value="">単位を選んでください</option>
                                    @foreach ($units as $unit)
                                        <option value="{{ $unit->id }}" @if ($ingredient->pivot->unit_id === $unit->id) selected @endif>{{ $unit->name }}</option>
                                    @endforeach
                                </select><br>
                                <p class="unit_error" style="color:red">{{ $errors->first("ingredient_recipe.{$loop->iteration}.unit_id") }}</p>
                            </div>
                            <button type="button" class="ingredient-delete-button" data-id={{ $loop->iteration }}>削除</button>
                        </div>
                    @endforeach
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
                                        <option value="{{ $unit->id }}" @if ((int)old("ingredient_recipe.{$key}.unit_id") === $unit->id) selected @endif>{{ $unit->name }}</option>
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
            
            <!-- 調理手順の編集 -->
            <div class="procedures" id="procedure-container">
                <h2>調理手順</h2>
                @empty (old('procedure'))
                    @foreach ($recipe->procedures as $procedure)
                        <div class="procedure-item" id="procedure{{ $loop->iteration }}">
                            <div class="textarea">
                                <label for="procedure{{ $loop->iteration }}">手順{{ $loop->iteration }}：</label>
                                <textarea name="procedure[{{ $loop->iteration }}][body]" rows="4" cols="40" class='procedures' id="form{{ $loop->iteration }}" placeholder="例）ケトルで沸かしたお湯を注ぎ、3分待つ。">{{ $procedure->body }}</textarea>
                            </div>
                        </div>
                        <p class="procedure_error" style="color:red">{{ $errors->first("procedure.{$loop->iteration}.body") }}</p>
                        <button type="button" class="procedure-delete-button" data-id={{ $loop->iteration }}>削除</button>
                    @endforeach
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
            
            <input type="submit" value="更新">
        </form>
        <div class='footer'>
            <a href="/recipes/{{ $recipe->id }}">戻る</a>
        </div>
    </div>
</x-app-layout>