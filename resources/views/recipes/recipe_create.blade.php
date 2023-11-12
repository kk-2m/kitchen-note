<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('レシピ作成') }}
        </h2>
    </x-slot>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!--　/recipes/storeにフォームのデータが渡され、web.phpで指定したRecipeControllerのstoreメソッドが実行される　-->
                    <form action="{{ route('recipe_store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- タイトルの入力 -->
                        <div class="title">
                            <div class="font-semibold">タイトル</div>
                            <input type="text" name="recipe[title]" placeholder="レシピのタイトルを入力" value="{{ old('recipe.title') }}"/>
                            <p class="title_error" style="color:red">{{ $errors->first('recipe.title') }}</p><br>
                        </div>
                        
                        <!-- 料理写真の入力 -->
                        <div class="image">
                            <div class="font-semibold">料理写真</div>
                            <input type="file" name="recipe[image]"/>
                        </div>
                        
                        <!-- 調理時間の入力 -->
                        <div class="cooking_time">
                            <div class="font-semibold pt-6">調理時間</div>
                            <div class="flex">
                                <div class="time">
                                    <input type="number" name="recipe[cooking_time]" placeholder="数字" value="{{ old('recipe.cooking_time') }}" min="1"/>
                                    <p class="cooking_time_error" style="color:red">{{ $errors->first('recipe.cooking_time') }}</p>
                                </div>
                                <div class="px-4">
                                    <select name="recipe[cooking_time_unit]" id="cooking_time_unit">
                                        <option value="">単位</option>
                                        <option value="1" @if ((int)old("recipe.cooking_time_unit") === 1) selected @endif>秒</option>
                                        <option value="2" @if ((int)old("recipe.cooking_time_unit") === 2) selected @endif>分</option>
                                        <option value="3" @if ((int)old("recipe.cooking_time_unit") === 3) selected @endif>時間</option>
                                        <option value="4" @if ((int)old("recipe.cooking_time_unit") === 4) selected @endif>日</option>
                                        <option value="5" @if ((int)old("recipe.cooking_time_unit") === 5) selected @endif>カ月</option>
                                        <option value="6" @if ((int)old("recipe.cooking_time_unit") === 6) selected @endif>年</option>
                                    </select><br>
                                    <p class="cooking_time_unit_error" style="color:red">{{ $errors->first('recipe.cooking_time_unit') }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- カテゴリの入力 -->
                        <div class='categories'>
                            <div class="font-semibold pt-6">
                                カテゴリ :
                            </div>
                            <div class="px-4">
                                @foreach ($categories as $category)
                                    <input class="dish_category_checkbox" type="checkbox" name="category[{{ $loop->iteration }}]" value="{{ $category->id }}" id="{{ $category->id }}" @if ((int)old("category.{$loop->iteration}") === $category->id) checked @endif/>
                                    <label for="{{ $category->id }}">{{ $category->name }}</label>
                                @endforeach
                            </div>
                        </div>
                        
                        <!-- 人数を入力 -->
                        <div class='number'>
                            <div class="font-semibold pt-6">何人前？</div>
                            <input type="number" name="recipe[number]" placeholder="人数" value="{{ old('recipe.number') }}" min="1" max="100"/>人前
                            <p class="number_error" style="color:red">{{ $errors->first('recipe.number') }}</p><br>
                        </div>
                        
                        <!-- 材料の入力 -->
                        <div class="ingredients" id="ingredient-container" data-ingredientcategories='@json($ingredient_categories)' data-units='@json($units)'>
                            <div class="text-2xl font-black">材料</div>
                            @empty (old('ingredient') && old('ingredient_recipe'))
                                <div class="ingredient-item px-4 rounded-lg border border-gray-300" id="ingredient-item1">
                                    <div class="flex pt-4">
                                        <h3 class="ingredient_title font-semibold pt-2">材料1</h3>
                                        <div class="px-2">
                                            <button type="button" class="ingredient-delete-button my-btn" data-id="1">削除</button>
                                        </div>
                                    </div>
                                    <div class="px-4 pb-4">
                                        <div class="ingredient_category py-1 px-8">
                                            <label for="ingredient_category1">カテゴリを選択：</label>
                                            <select name="ingredient[1][ingredient_category_id]" id="select_ingredient_category1">
                                                <option value="">カテゴリを選んでください</option>
                                                @foreach ($ingredient_categories as $ingredient_category)
                                                    <option value="{{ $ingredient_category->id }}">{{ $ingredient_category->category }}</option>
                                                @endforeach
                                            </select><br>
                                            <p class="ingredient_category_error" style="color:red">{{ $errors->first('ingredient.1.ingredient_category_id') }}</p>
                                        </div>
                                        <div class="ingredient_name py-1 px-8">
                                            <label for="ingredient_name1">材料名：</label>
                                            <input type="text" name="ingredient[1][name]" id="input_ingredient_name1" placeholder="材料を入力" value="{{ old('ingredient.1.name') }}"/>
                                            <p class="ingredient_error" style="color:red">{{ $errors->first('ingredient.1.name') }}</p>
                                        </div>
                                        <div class="flex py-1 px-8">
                                            <div class="ingredient_qantity">
                                                <label for="ingredient_quantity1">量：</label>
                                                <input type="number" name="ingredient_recipe[1][quantity]" id="input_ingredient_quantity1" placeholder="値を入力" value="{{ old('ingredient_recipe.1.quantity') }}" min="0.01" step="0.01" max="99999999"/>
                                                <p class="ingredient_quantity_error" style="color:red">{{ $errors->first('ingredient_recipe.1.quantity') }}</p>
                                            </div>
                                            <div class="ingredient_unit pl-2">
                                                <select name="ingredient_recipe[1][unit_id]" id="select_ingredient_unit1">
                                                    <option value="">単位を選んでください</option>
                                                    @foreach ($units as $unit)
                                                        <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                                    @endforeach
                                                </select><br>
                                                <p class="unit_error" style="color:red">{{ $errors->first('ingredient_recipe.1.unit_id') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="ingredient-item px-4 rounded-lg border border-gray-300" id="ingredient-item2">
                                    <div class="flex pt-4">
                                        <h3 class="ingredient_title font-semibold pt-2">材料2</h3>
                                        <div class="px-2">
                                            <button type="button" class="ingredient-delete-button my-btn" data-id="2">削除</button>
                                        </div>
                                    </div>
                                    <div class="px-4 pb-4">
                                        <div class="ingredient_category py-1 px-8">
                                            <label for="ingredient_category2">カテゴリを選択：</label>
                                            <select name="ingredient[2][ingredient_category_id]" id="select_ingredient_category2">
                                                <option value="">カテゴリを選んでください</option>
                                                @foreach ($ingredient_categories as $ingredient_category)
                                                    <option value="{{ $ingredient_category->id }}">{{ $ingredient_category->category }}</option>
                                                @endforeach
                                            </select><br>
                                            <p class="ingredient_category_error" style="color:red">{{ $errors->first('ingredient.2.ingredient_category_id') }}</p>
                                        </div>
                                        <div class="ingredient_name py-1 px-8">
                                            <label for="ingredient_name2">材料名：</label>
                                            <input type="text" name="ingredient[2][name]" id="input_ingredient_name2" placeholder="材料を入力" value="{{ old('ingredient.2.name') }}"/>
                                            <p class="ingredient_error" style="color:red">{{ $errors->first('ingredient.2.name') }}</p>
                                        </div>
                                        <div class="flex py-1 px-8">
                                            <div class="ingredient_qantity">
                                                <label for="ingredient_quantity2">量：</label>
                                                <input type="number" name="ingredient_recipe[2][quantity]" id="input_ingredient_quantity2" placeholder="値を入力" value="{{ old('ingredient_recipe.2.quantity') }}" min="0.01" step="0.01" max="99999999"/>
                                                <p class="ingredient_quantity_error" style="color:red">{{ $errors->first('ingredient_recipe.2.quantity') }}</p>
                                            </div>
                                            <div class="ingredient_unit pl-2">
                                                <select name="ingredient_recipe[2][unit_id]" id="select_ingredient_unit2">
                                                    <option value="">単位を選んでください</option>
                                                    @foreach ($units as $unit)
                                                        <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                                    @endforeach
                                                </select><br>
                                                <p class="unit_error" style="color:red">{{ $errors->first('ingredient_recipe.2.unit_id') }}</p>
                                            </div>    
                                        </div>
                                    </div>
                                </div>
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
                                            <h3 class="ingredient_title font-semibold pt-2">材料{{ $key }}</h3>
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
                                                <input type="text" name="ingredient[{{ $key }}][name]" id="input_ingredient_name{{ $key }}" placeholder="材料を入力" value="{{ old("ingredient.{$key}.name") }}"/>
                                                <p class="ingredient_error" style="color:red">{{ $errors->first("ingredient.{$key}.name") }}</p>
                                            </div>
                                            <div class="flex py-1 px-8">
                                                <div class="ingredient_qantity">
                                                    <label for="ingredient_quantity{{ $key }}">量：</label>
                                                    <input type="number" name="ingredient_recipe[{{ $key }}][quantity]" id="input_ingredient_quantity{{ $key }}" placeholder="値を入力" value="{{ old("ingredient_recipe.{$key}.quantity") }}" min="0.01" step="0.01" max="99999999"/>
                                                    <p class="ingredient_quantity_error" style="color:red">{{ $errors->first("ingredient_recipe.{$key}.quantity") }}</p>
                                                </div>
                                                <div class="ingredient_unit pl-2">
                                                    <select name="ingredient_recipe[{{ $key }}][unit_id]" id="select_ingredient_unit{{ $key }}">
                                                        <option value="">単位を選んでください</option>
                                                        @foreach ($units as $unit)
                                                            <option value="{{ $unit->id }}" @if ((int)old("ingredient_recipe.{$key}.unit_id") == $unit->id) selected @endif>{{ $unit->name }}</option>
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
                        
                        <!-- 調理手順の入力 -->
                        <div class="procedures" id="procedure-container">
                            <div class="text-2xl font-black pt-6">調理手順</div>
                            @empty (old('procedure'))
                                <div class="procedure-item px-4 rounded-lg border border-gray-300" id="procedure-item1">
                                    <div class="flex py-2">
                                        <h3 class="procedure1 font-semibold">手順1</h3>
                                        <div class="px-2">
                                            <button type="button" class="procedure-delete-button my-btn" data-id="1">削除</button>
                                        </div>
                                    </div>
                                    <div class="textarea">
                                        <textarea name="procedure[1][body]" rows="4" class='procedures w-full' id="form1" placeholder="例）ケトルで沸かしたお湯を注ぎ、3分待つ。">{{ old('procedure.1.body') }}</textarea><br>
                                    </div>
                                    <p class="procedure_error" style="color:red">{{ $errors->first('procedure.1.body') }}</p>
                                </div>
                                
                                <div class="procedure-item px-4 rounded-lg border border-gray-300" id="procedure-item2">
                                    <div class="flex py-2">
                                        <h3 class="procedure2 font-semibold">手順2</h3>
                                        <div class="px-2">
                                            <button type="button" class="procedure-delete-button my-btn" data-id=2>削除</button>
                                        </div>
                                    </div>
                                    <div class="textarea">
                                        <textarea name="procedure[2][body]" rows="4" cols="80" class='procedures w-full' id="form2" placeholder="例）ケトルで沸かしたお湯を注ぎ、3分待つ。">{{ old('procedure.2.body') }}</textarea>
                                    </div>
                                    <p class="procedure_error" style="color:red">{{ $errors->first('procedure.2.body') }}</p>
                                </div>
                            @else
                                @foreach (old('procedure') as $key => $value)
                                    <div class="procedure-item  px-4 rounded-lg border border-gray-300" id="procedure-item{{ $key }}">
                                        <div class="flex py-2">
                                            <h3 for="procedure{{ $key }}">手順{{ $key }}：</h3>
                                            <div class="px-2">
                                                <button type="button" class="procedure-delete-button my-btn" data-id={{ $key }}>削除</button>
                                            </div>
                                        </div>
                                        <div class="textarea ">
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
                        
                        <!-- 送信ボタン -->
                        <div class="py-3 mx-auto text-center">
                            <input class="my-store-btn" type="submit" value="作成"/>
                        </div>
                    </form>
                    
                    <!-- 戻るボタン -->
                    <div class="footer">
                        <button type="button" class="my-btn"><a href="{{ route('recipe_index') }}">戻る</a></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>