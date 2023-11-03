<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('献立作成') }}
        </h2>
    </x-slot>
    
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
    
                    <!--　/menus/storeにフォームのデータが渡され、web.phpで指定したRecipeControllerのstoreメソッドが実行される　-->
                    <form action="{{ route('menu_store') }}" method="POST">
                        @csrf
                        
                        <!-- 食材の名前の入力 -->
                        <div class="text-2xl font-black pb-4">献立</div>
                        @empty (old('menu'))
                            <div class="menu-item px-4 rounded-lg border border-gray-300" id="ingredient-item">
                                <div class="px-8 py-6">
                                    <div class="menu-recipe px-8">
                                        <label class="font-semibold pt-6" for="recipe">レシピ：</label>
                                        <select name="menu[recipe_id]" id="recipe">
                                            <option value="">レシピを選んでください</option>
                                            @foreach ($recipes as $recipe)
                                                <option value="{{ $recipe->id }}" @if ((int)$recipeId === $recipe->id) selected @endif>{{ $recipe->title }}</option>
                                            @endforeach
                                        </select><br>
                                        <p class="recipe_error" style="color:red">{{ $errors->first('menu.recipe_id') }}</p>
                                    </div>
                                    
                                    <div class='number pt-6 px-8'>
                                        <label for="number" class="font-semibold pt-6">人数：</label>
                                        <input type="number" name="menu[number]" id="number" placeholder="例)5" value="{{ old('menu.number') }}" min="1" max="200">人前</input>
                                        <p class="number_error" style="color:red">{{ $errors->first('menu.number') }}</p>
                                    </div>
                                    
                                    
                                    <!-- 献立の日を入力 -->
                                    <div class='date pt-6 px-8'>
                                        <label for="date" class="font-semibold pt-6">日付：</label>
                                        <input type="date" name="menu[date]" id="date" value="{{ old('menu.date') }}" min="{{ \Carbon\Carbon::now()->toDateString() }}"/>
                                        <p class="date_error" style="color:red">{{ $errors->first('menu.date') }}</p>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="menu-item px-4 rounded-lg border border-gray-300" id="ingredient-item">
                                <div class="px-8 py-6">
                                    <div class="menu-recipe px-8">
                                        <label class="font-semibold pt-6" for="recipe">レシピ：</label>
                                        <select name="menu[recipe_id]" id="recipe">
                                            <option value="">レシピを選んでください</option>
                                            @foreach ($recipes as $recipe)
                                                <option value="{{ $recipe->id }}" @if ((int)$recipeId === $recipe->id) selected @elseif ((int)old("menu.recipe_id") == $recipe->id) selected @endif>{{ $recipe->title }}</option>
                                            @endforeach
                                        </select><br>
                                        <p class="recipe_error" style="color:red">{{ $errors->first('menu.recipe_id') }}</p>
                                    </div>
                                    
                                    <div class='number pt-6 px-8'>
                                        <label for="number" class="font-semibold pt-6">人数：</label>
                                        <input type="number" name="menu[number]" id="number" placeholder="例)5" value="{{ old('menu.number') }}" min="1" max="200">人前</input>
                                        <p class="number_error" style="color:red">{{ $errors->first('menu.number') }}</p>
                                    </div>
                                    
                                    
                                    <!-- 献立の日を入力 -->
                                    <div class='date pt-6 px-8'>
                                        <label for="date" class="font-semibold pt-6">日付：</label>
                                        <input type="date" name="menu[date]" id="date" value="{{ old('menu.date') }}" min="{{ \Carbon\Carbon::now()->toDateString() }}"/>
                                        <p class="date_error" style="color:red">{{ $errors->first('menu.date') }}</p>
                                    </div>
                                </div>
                            </div>
                        @endempty
                        
                        <!-- 送信ボタン -->
                        <div class="py-3 mx-auto text-center">
                            <input class="my-store-btn" type="submit" value="作成"/>
                        </div>
                    </form>
                    
                    <div class="footer">
                        <button type="button" class="my-btn" onclick="history.back()">戻る</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</x-app-layout>