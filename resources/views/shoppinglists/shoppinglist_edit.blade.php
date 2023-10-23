<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('在庫情報編集') }}
        </h2>
    </x-slot>
    
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!--　/recipes/storeにフォームのデータが渡され、web.phpで指定したRecipeControllerのstoreメソッドが実行される　-->
                    <form action="/stocks/{{ $stock->id }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <!-- 食材の名前の入力 -->
                        <div class="text-2xl font-black pb-4">食材</div>
                        @empty (old('ingredient') && old('stock'))
                            <div class="sotck-item px-4 rounded-lg border border-gray-300" id="ingredient-item1">
                                <div class="px-8 py-6">
                                    <div class="stock_category px-8">
                                        <label for="category" class="font-semibold">カテゴリを選択：</label>
                                        <select name="ingredient[ingredient_category_id]" id="category">
                                            <option value="">カテゴリを選んでください</option>
                                            @foreach ($ingredient_categories as $ingredient_category)
                                                <option value="{{ $ingredient_category->id }}" @if ($stock->ingredient->ingredient_category_id === $ingredient_category->id) selected @endif>{{ $ingredient_category->category }}</option>
                                            @endforeach
                                        </select><br>
                                        <p class="ingredient_category_error" style="color:red">{{ $errors->first('ingredient.ingredient_category_id') }}</p>
                                    </div>
                                    <div class="stock_name pt-6 px-8">
                                        <label for="name" class="font-semibold text-gray-400">材料名：</label>
                                        <input type="text" class="bold-gray-200 text-gray-400" name="ingredient[name]" id="name" value="{{ old('ingredient.name', $stock->ingredient->name) }}" readonly/>
                                    </div>
                                    
                                    <!-- 個数を入力 -->
                                    <div class='flex pt-6 px-8'>
                                        <div class="stock_quantity">
                                            <label for="quantity" class="font-semibold">量：</label>
                                            <input type="number" name="stock[quantity]" id="quantity" placeholder="値を入力" value="{{ old('stock.quantity', $stock->quantity) }}" min="0" step="0.01" max="99999999"/>
                                            <p class="quantity_error" style="color:red">{{ $errors->first('stock.quantity') }}</p>
                                        </div>
                                        <div class="unit pl-2">
                                            <select name="stock[unit_id]" id="unit">
                                                <option value="">単位を選んでください</option>
                                                @foreach ($units as $unit)
                                                    <option value="{{ $unit->id }}" @if ($stock->unit_id === $unit->id) selected @endif>{{ $unit->name }}</option>
                                                @endforeach
                                            </select>
                                            <p class="unit_error" style="color:red">{{ $errors->first('stock.unit_id') }}</p>
                                        </div>
                                    </div>
                                    
                                    <!-- 賞味・消費期限を入力 -->
                                    <div class='stock_expiration pt-6 px-8'>
                                        <label for="expiration" class="font-semibold">賞味・消費期限</label>
                                        <input type="date" name="stock[expiration_at]" id="expiration" value="{{ old('stock.expiration_at', $stock->expiration_at) }}"/>
                                        <p class="expiration_error" style="color:red">{{ $errors->first('stock.expiration_at') }}</p>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="ingredient-item px-4 rounded-lg border border-gray-300" id="ingredient-item1">
                                <div class="px-8 py-6">
                                    <div class="stock_category px-8">
                                        <label for="category" class="font-semibold">カテゴリを選択：</label>
                                        <select name="ingredient[ingredient_category_id]" id="category">
                                            <option value="">カテゴリを選んでください</option>
                                            @foreach ($ingredient_categories as $ingredient_category)
                                                <option value="{{ $ingredient_category->id }}" @if ((int)old("ingredient.ingredient_category_id") === $ingredient_category->id) selected @endif>{{ $ingredient_category->category }}</option>
                                            @endforeach
                                        </select><br>
                                        <p class="ingredient_category_error" style="color:red">{{ $errors->first('ingredient.ingredient_category_id') }}</p>
                                    </div>
                                    <div class="stock_name pt-6 px-8">
                                        <label for="name" class="font-semibold text-gray-400">材料名：</label>
                                        <input type="text" class="bold-gray-200 text-gray-400" name="ingredient[name]" id="name" value="{{ old('ingredient.name', $stock->ingredient->name) }}" readonly/>
                                    </div>
                                    
                                    <!-- 個数を入力 -->
                                    <div class="flex pt-6 px-8">
                                        <div class="stock_quantity">
                                            <label for="quantity" class="font-semibold">量：</label>
                                            <input type="number" name="stock[quantity]" id="quantity" placeholder="値を入力" value="{{ old('stock.quantity') }}" min="1" step="0.01" max="99999999"/>
                                            <p class="quantity_error pr-3" style="color:red">{{ $errors->first('stock.quantity') }}</p>
                                        </div>
                                        <div class="unit pl-2">
                                            <select name="stock[unit_id]" id="unit">
                                                <option value="">単位を選んでください</option>
                                                @foreach ($units as $unit)
                                                    <option value="{{ $unit->id }}" @if ((int)old("stock.unit_id") == $unit->id) selected @endif>{{ $unit->name }}</option>
                                                @endforeach
                                            </select>
                                            <p class="unit_error pr-3" style="color:red">{{ $errors->first('stock.unit_id') }}</p>
                                        </div>
                                    </div>
                                    
                                    <!-- 賞味・消費期限を入力 -->
                                    <div class='stock_expiration pt-6 px-8'>
                                        <label for="expiration" class="font-semibold">賞味・消費期限</label>
                                        <input type="date" name="stock[expiration_at]" id="expiration" value="{{ old('stock.expiration_at') }}"/>
                                        <p class="expiration_error" style="color:red">{{ $errors->first('stock.expiration_at') }}</p>
                                    </div>
                                </div>
                            </div>
                        @endempty

                        <!-- 送信ボタン -->
                        <div class="py-3 mx-auto text-center">
                            <input class="my-store-btn" type="submit" value="保存"/>
                        </div>
                    </form>
                    
                    <div class="footer">
                        <button type="button" class="my-btn"><a href="/stocks">戻る</a></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>