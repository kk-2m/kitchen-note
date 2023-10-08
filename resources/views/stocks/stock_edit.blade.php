<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('在庫情報登録') }}
        </h2>
    </x-slot>
    <!--　/recipes/storeにフォームのデータが渡され、web.phpで指定したRecipeControllerのstoreメソッドが実行される　-->
    <form action="/stocks/{{ $stock->id }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <!-- 食材の名前の入力 -->
        <div class="name">
            <h2><label for="ingredient">{{ $stock->ingredient->name }}</label></h2>
            <input type="hidden" name="ingredient[name]" id="ingredient" placeholder="材料を入力してください" value="{{ old('ingredient.name', $stock->ingredient->name) }}"/>
            <label for="ingredient_category">　カテゴリを選択：</label>
            <select name="ingredient[ingredient_category_id]" id="ingredient_category">
                <option value="">カテゴリを選んでください</option>
                @foreach ($ingredient_categories as $ingredient_category)
                    <option value="{{ $ingredient_category->id }}" @if ($stock->ingredient->ingredient_category_id === $ingredient_category->id) selected @endif>{{ $ingredient_category->category }}</option>
                @endforeach
            </select><br>
            {{-- <p class="ingredient_category_error" style="color:red">{{ $errors->first('ingredient.ingredient_category_id') }}</p> --}}
        </div>
        
        <!-- 個数を入力 -->
        <div class='number'>
            <h4><label for="quantity">個数</label></h4>
            <input type="number" name="stock[quantity]" id="quantity" placeholder="個数を入力してください" value="{{ old('stock.quantity', $stock->quantity) }}" min="0" step="0.01"/>
            {{-- <p class="title_error" style="color:red">{{ $errors->first('recipe.number') }}</p><br> --}}
             <label for="unit">　単位を選択：</label>
            <select name="stock[unit_id]" id="unit">
                <option value="">単位を選んでください</option>
                @foreach ($units as $unit)
                    <option value="{{ $unit->id }}" @if ($stock->unit_id === $unit->id) selected @endif>{{ $unit->name }}</option>
                @endforeach
            </select><br>
        </div>
        
        
        <!-- 賞味・消費期限を入力 -->
        <div class='date'>
            <h4><label for="expiration">賞味・消費期限</label></h4>
            <input type="date" name="stock[expiration_at]" id="expiration" value="{{ old('stock.expiration_at', $stock->expiration_at) }}"/>
            {{-- <p class="title_error" style="color:red">{{ $errors->first('recipe.number') }}</p><br> --}}
        </div>
        
        <!-- 送信ボタン -->
        <input type="submit" value="更新"/>
    </form>
    <div class="footer">
        <a href="/stocks">戻る</a>
    </div>
</x-app-layout>