<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('レシピ編集') }}
        </h2>
    </x-slot>
    <div class="contents">
        <form action="{{ route('recipe_update', ['recipe'=>$recipe->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            
                            <!-- タイトルの編集 -->
                            <div class="title">
                                <div class="font-semibold">タイトル</div>
                                <input type='text' name='recipe[title]' placeholder="レシピのタイトルを入力してください。" value="{{ old('recipe.title',$recipe->title) }}"/>
                                <p class="title_error" style="color:red">{{ $errors->first('recipe.title') }}</p><br>
                            </div>
                            
                            <!-- 料理写真の編集 -->
                            <div class="image">
                                @if ($recipe->image != '')
                                    <img src="https://rihwablog.com/KitchenNote/{{ $recipe->image }}">
                                @else
                                    <img src="https://rihwablog.com/KitchenNote/noimage.png", alt='料理写真' width="50%">
                                @endif
                                <div class="font-semibold">料理写真</div>
                                <input type="file" name="recipe[image]"/>
                            </div>
                            
                            <!-- 調理時間の編集 -->
                            <div class="cooking_time">
                                <div class="font-semibold pt-6">調理時間</div>
                                <div class="flex">
                                    <div class="time">
                                        <input type="number" name="recipe[cooking_time]" placeholder="数字" value="{{ old('recipe.cooking_time',$recipe->cooking_time) }}"/>
                                        <p class="cooking_time_error" style="color:red">{{ $errors->first('recipe.cooking_time') }}</p>
                                    </div>
                                    <div class="px-4">
                                        <select name="recipe[cooking_time_unit]" id="cooking_time_unit">
                                            <option value="">単位</option>
                                            <option value="1" @if ((int)old("recipe.cooking_time_unit", $recipe->cooking_time_unit) === 1) selected @endif>秒</option>
                                            <option value="2" @if ((int)old("recipe.cooking_time_unit", $recipe->cooking_time_unit) === 2) selected @endif>分</option>
                                            <option value="3" @if ((int)old("recipe.cooking_time_unit", $recipe->cooking_time_unit) === 3) selected @endif>時間</option>
                                            <option value="4" @if ((int)old("recipe.cooking_time_unit", $recipe->cooking_time_unit) === 4) selected @endif>日</option>
                                            <option value="5" @if ((int)old("recipe.cooking_time_unit", $recipe->cooking_time_unit) === 5) selected @endif>カ月</option>
                                            <option value="6" @if ((int)old("recipe.cooking_time_unit", $recipe->cooking_time_unit) === 6) selected @endif>年</option>
                                        </select><br>
                                        <p class="cooking_time_unit_error" style="color:red">{{ $errors->first('recipe.cooking_time_unit') }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            
                             <!-- カテゴリの編集 -->
                            <div class='categories'>
                                <div class="font-semibold pt-6">
                                    カテゴリ : 
                                </div>
                                <div class="px-4">
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
                            </div>
                            
                            <!-- 人数を編集 -->
                            <div class='number'>
                                <div class="font-semibold pt-6">何人前？</div>
                                <input type="number" name="recipe[number]" placeholder="人数" value="{{ old('recipe.number', $recipe->number) }}"/>人前
                                <p class="title_error" style="color:red">{{ $errors->first('recipe.number') }}</p><br>
                            </div>
                            
                            <!-- 材料の編集 -->
                            <div class="ingredients" id="ingredient-container" data-ingredientcategories='@json($ingredient_categories)' data-units='@json($units)'>
                                <div class="text-2xl font-black">材料</div>
                                @empty (old('ingredient') && old('ingredient_recipe'))
                                    @foreach ($recipe->ingredients as $ingredient)
                                        <div class="ingredient-item px-4 rounded-lg border border-gray-300" id="ingredient-item{{ $loop->iteration }}">
                                            <div class="flex pt-4">
                                                <h3 class="ingredient_title font-semibold pt-2">材料{{ $loop->iteration }}</h3>
                                                <div class="px-2">
                                                    <button type="button" class="ingredient-delete-button my-btn" data-id={{ $loop->iteration }}>削除</button>
                                                </div>
                                            </div>
                                            <div class="px-4 pb-4">
                                                <div class="ingredient_category py-1 px-8">
                                                    <label for="ingredient_category{{ $loop->iteration }}">カテゴリを選択：</label>
                                                    <select name="ingredient[{{ $loop->iteration }}][ingredient_category_id]" id="select_ingredient_category{{ $loop->iteration }}">
                                                        <option value="">カテゴリを選んでください</option>
                                                        @foreach ($ingredient_categories as $ingredient_category)
                                                            <option value="{{ $ingredient_category->id }}" @if ($ingredient->ingredient_category_id === $ingredient_category->id) selected @endif>{{ $ingredient_category->category }}</option>
                                                        @endforeach
                                                    </select><br>
                                                    <p class="ingredient_category_error" style="color:red">{{ $errors->first("ingredient.{$loop->iteration}.ingredient_category_id") }}</p>
                                                </div>
                                                <div class="ingredient_name py-1 px-8">
                                                    <label for="ingredient_name{{ $loop->iteration }}">材料名：</label>
                                                    <input type="text" name="ingredient[{{ $loop->iteration }}][name]" id="input_ingredient_name{{ $loop->iteration }}" placeholder="材料を入力してください" value="{{ $ingredient->name }}"/>
                                                    <p class="ingredient_error" style="color:red">{{ $errors->first("ingredient.{$loop->iteration}.name") }}</p>
                                                </div>
                                                <div class="flex  py-1 px-8">
                                                    <div class="ingredient_qantity">
                                                        <label for="ingredient_quantity{{ $loop->iteration }}">量：</label>
                                                        <input type="number" name="ingredient_recipe[{{ $loop->iteration }}][quantity]" id="input_ingredient_quantity{{ $loop->iteration }}" placeholder="必要な量を入力してください" value="{{ $ingredient->pivot->quantity }}" min="0.01" step="0.01" max="99999999"/>
                                                        <p class="ingredient_quantity_error" style="color:red">{{ $errors->first("ingredient_recipe.{$loop->iteration}.quantity") }}</p>
                                                    </div>
                                                    <div class="ingredient_unit pl-2">
                                                        <select name="ingredient_recipe[{{ $loop->iteration }}][unit_id]" id="select_ingredient_unit{{ $loop->iteration }}">
                                                            <option value="">単位を選んでください</option>
                                                            @foreach ($units as $unit)
                                                                <option value="{{ $unit->id }}" @if ($ingredient->pivot->unit_id === $unit->id) selected @endif>{{ $unit->name }}</option>
                                                            @endforeach
                                                        </select><br>
                                                        <p class="unit_error" style="color:red">{{ $errors->first("ingredient_recipe.{$loop->iteration}.unit_id") }}</p>
                                                    </div>
                                                </div>
                                            </div>
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
                                        <div class="ingredient-item px-4 rounded-lg border border-gray-300" id="ingredient-item{{ $key }}">
                                            <div class="flex pt-4">
                                                <h3 class="ingredient_title">材料{{ $key }}</h3>
                                                <div class="px-2">
                                                    <button type="button" class="ingredient-delete-button my-btn" data-id={{ $key }}>削除</button>
                                                </div>
                                            </div>
                                            <div class="px-4 pb-4">
                                                <div class="ingredient_category py-1 px-8">
                                                    <label for="ingredient_category{{ $key }}">カテゴリを選択：</label>
                                                    <select name="ingredient[{{ $key }}][ingredient_category_id]" id="select_ingredient_category{{ $key }}">
                                                        <option value="">カテゴリを選んでください</option>
                                                        @foreach ($ingredient_categories as $ingredient_category)
                                                            <option value="{{ $ingredient_category->id }}" @if ((int)old("ingredient.{$key}.ingredient_category_id") === $ingredient_category->id) selected @endif>{{ $ingredient_category->category }}</option>
                                                        @endforeach
                                                    </select><br>
                                                    <p class="ingredient_category_error" style="color:red">{{ $errors->first("ingredient.{$key}.ingredient_category_id") }}</p>
                                                </div>
                                                <div class="ingredient_name py-1 px-8">
                                                    <label for="ingredient_name{{ $key }}">材料名：</label>
                                                    <input type="text" name="ingredient[{{ $key }}][name]" id="input_ingredient_name{{ $key }}" placeholder="材料を入力してください" value="{{ old("ingredient.{$key}.name") }}"/>
                                                    <p class="ingredient_error" style="color:red">{{ $errors->first("ingredient.{$key}.name") }}</p>
                                                </div>
                                                <div class="flex py-1 px-8">
                                                    <div class="ingredient_qantity">
                                                        <label for="ingredient_quantity{{ $key }}">量：</label>
                                                        <input type="number" name="ingredient_recipe[{{ $key }}][quantity]" id="input_ingredient_quantity{{ $key }}" placeholder="必要な量を入力してください" value="{{ old("ingredient_recipe.{$key}.quantity") }}" min="0.01" step="0.01" max="99999999"/>
                                                        <p class="ingredient_quantity_error" style="color:red">{{ $errors->first("ingredient_recipe.{$key}.quantity") }}</p>
                                                    </div>
                                                    <div class="ingredient_unit pl-2">
                                                        <label for="ingredient_unit{{ $key }}">単位を選択：</label>
                                                        <select name="ingredient_recipe[{{ $key }}][unit_id]" id="select_ingredient_unit{{ $key }}">
                                                            <option value="">　単位を選んでください</option>
                                                            @foreach ($units as $unit)
                                                                <option value="{{ $unit->id }}" @if ((int)old("ingredient_recipe.{$key}.unit_id") === $unit->id) selected @endif>{{ $unit->name }}</option>
                                                            @endforeach
                                                        </select><br>
                                                        <p class="unit_error" style="color:red">{{ $errors->first("ingredient_recipe.{$key}.unit_id") }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endempty
                            </div>
                            
                            <div class="py-3">
                                <button class="my-btn" type="button" id="add-ingredient">材料を追加</button><br>
                            </div>
                            
                            <!-- 調理手順の編集 -->
                            <div class="procedures" id="procedure-container">
                                <div class="text-2xl font-black pt-6">調理手順</div>
                                @empty (old('procedure'))
                                    @foreach ($recipe->procedures as $procedure)
                                        <div class="procedure-item px-4 rounded-lg border border-gray-300" id="procedure-item{{ $loop->iteration }}">
                                            <div class="flex py-2">
                                                <h3 class="procedure{{ $loop->iteration }} font-semibold">手順{{ $loop->iteration }}：</h3>
                                                <div class="px-2">
                                                    <button type="button" class="procedure-delete-button my-btn" data-id={{ $loop->iteration }}>削除</button>
                                                </div>
                                            </div>
                                            <div class="textarea">
                                                <textarea name="procedure[{{ $loop->iteration }}][body]" rows="4" class='procedures w-full' id="form{{ $loop->iteration }}" placeholder="例）ケトルで沸かしたお湯を注ぎ、3分待つ。">{{ $procedure->body }}</textarea>
                                            </div>
                                            <p class="procedure_error" style="color:red">{{ $errors->first("procedure.{$loop->iteration}.body") }}</p>
                                        </div>
                                    @endforeach
                                @else
                                    @foreach (old('procedure') as $key => $value)
                                        <div class="procedure-item px-4 rounded-lg border border-gray-300" id="procedure-item{{ $key }}">
                                            <div class="px-2">
                                                <h3 class="procedure{{ $key }} font-semibold">手順{{ $key }}：</h3>
                                                <div class="px-2">
                                                    <button type="button" class="procedure-delete-button my-btn" data-id={{ $key }}>削除</button>
                                                </div>
                                            </div>
                                            <div class="textarea">
                                                <textarea name="procedure[{{ $key }}][body]" rows="4" class='procedures w-full' id="form{{ $key }}" placeholder="例）ケトルで沸かしたお湯を注ぎ、3分待つ。">{{ old("procedure.{$key}.body") }}</textarea>
                                            </div>
                                            <p class="procedure_error" style="color:red">{{ $errors->first("procedure.{$key}.body") }}</p>
                                        </div>
                                    @endforeach
                                @endempty
                            </div>
                            
                            <!-- テキストエリアを追加するボタン -->
                            <div class="py-3">
                                <button class="my-btn" type="button" id="add-procedure">手順を追加</button><br>
                            </div>
                            
                            <!-- 更新ボタン -->
                            <div class="py-3 mx-auto text-center">
                                <input class="my-store-btn" type="submit" value="更新">
                            </div>
                            
                            <!-- 戻るボタン -->
                            <div class='footer'>
                                <button type="button" class="my-btn"><a href="{{ route('recipe_show', ['recipe'=>$recipe->id]) }}">戻る</a></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        
    </div>
</x-app-layout>