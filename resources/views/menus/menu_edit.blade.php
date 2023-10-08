<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('献立登録') }}
        </h2>
    </x-slot>
    <!--　/recipes/storeにフォームのデータが渡され、web.phpで指定したRecipeControllerのstoreメソッドが実行される　-->
    <form action="/menus/{{ $menu->id }}" method="POST">
        @csrf
        @method('PUT')
        
        
        <!-- 食材の名前の入力 -->
        <div class="name">
            <h2><label for="recipe">レシピ</label></h2>
            <select name="menu[recipe_id]" id="recipe">
                <option value="">レシピを選んでください</option>
                @foreach ($recipes as $recipe)
                    <option value="{{ $recipe->id }}" @if ((int)$menu->recipe_id === $recipe->id) selected @endif>{{ $recipe->title }}</option>
                @endforeach
            </select><br>
            <p class="recipe_error" style="color:red">{{ $errors->first('menu.recipe_id') }}</p>
        </div>
        
        <!-- 個数を入力 -->
        <div class='number'>
            <h4><label for="number">人数</label></h4>
            <input type="number" name="menu[number]" id="number" placeholder="例)5" value="{{ old('menu.number', $menu->number) }}" min="1" max="200">人前</input>
            <p class="number_error" style="color:red">{{ $errors->first('menu.number') }}</p><br>
        </div>
        
        
        <!-- 献立の日を入力 -->
        <div class='date'>
            <h4><label for="date">日付</label></h4>
            <input type="date" name="menu[date]" id="date" value="{{ old('menu.date', $menu->date) }}" min="{{ \Carbon\Carbon::now()->toDateString() }}"/>
            <p class="date_error" style="color:red">{{ $errors->first('menu.date') }}</p><br>
        </div>
        
        <!-- 送信ボタン -->
        <input type="submit" value="保存"/>
    </form>
    <div class="footer">
        <a href="/menus">戻る</a>
    </div>
</x-app-layout>