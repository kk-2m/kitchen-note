<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('レシピ一覧') }}
        </h2>
    </x-slot>
    <div class='login'>
            ログインユーザー：{{ Auth::user()->name }}
    </div>
    <div class='recipes'>
        <button type="button"><a href="{{ route('recipe_create') }}">create</a></button>
        <button type="button"><a href="/recipes/getCategories">get categories</a></button>
        @foreach ($recipes as $recipe)
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <div class='recipe'>
                                <h2 class='title'>
                                    <a href="/recipes/{{ $recipe->id }}">{{ $recipe->title }}</a>
                                </h2>
                
                                <p class='cooking_time'>調理時間 : {{ $recipe->cooking_time }}
                                    @if ( $recipe->cooking_time_unit  == 1) 秒
                                    @elseif ( $recipe->cooking_time_unit  == 2) 分
                                    @elseif ( $recipe->cooking_time_unit  == 3) 時間
                                    @elseif ( $recipe->cooking_time_unit  == 4) 日
                                    @elseif ( $recipe->cooking_time_unit  == 5) ヶ月
                                    @elseif ( $recipe->cooking_time_unit  == 6) 年
                                    @endif
                                </p>
                
                                <h3 class='ingrediens'>材料リスト({{ $recipe->number }}人前)</h3>
                                @foreach ($recipe->ingredients as $ingredient)
                                    <p class='ingredient'>
                                        {{ $ingredient->name }}　
                                        <!--　小さじや大さじは　-->
                                        @if ($ingredient->pivot->unit->id === 14 || $ingredient->pivot->unit->id === 15)
                                            <!-- 小数点以下が0は整数表記 -->
                                            @if ($ingredient->pivot->quantity == (int)$ingredient->pivot->quantity) {{ $ingredient->pivot->unit->name }}{{ number_format($ingredient->pivot->quantity) }}
                                            @else {{ $ingredient->pivot->unit->name }}{{ $ingredient->pivot->quantity }}
                                            @endif
                                        <!-- 適量は適量のみ表示 -->
                                        @elseif ($ingredient->pivot->unit->id === 16) {{ $ingredient->pivot->unit->name }}
                                        @else
                                            @if ($ingredient->pivot->quantity == (int)$ingredient->pivot->quantity) {{ number_format($ingredient->pivot->quantity) }}{{ $ingredient->pivot->unit->name }}
                                            @else {{ $ingredient->pivot->quantity }}{{ $ingredient->pivot->unit->name }}
                                            @endif
                                            
                                        @endif
                                    </p>
                                @endforeach
                                @if ($recipe->image != '')
                                    <img src="{{ asset($recipe->image) }}" alt='料理写真' width='50%'>
                                @else
                                    <img src="{{ asset('storage/dish_image/noimage.png') }}" alt='料理写真' width='300px'>
                                @endif
            
                                <p>カテゴリ</p>
                                @foreach ($recipe->categories as $category)
                                    <p class='tag'>{{ $category->name }}</p>
                                @endforeach
                                <form action="/recipes/{{ $recipe->id }}" id="form_{{ $recipe->id }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    {{--
                                        typeにbuttonを指定する（デフォルトはsubmit）
                                        onclick(deleteRecipe)：要素がクリックされたさいに引数deleteRecipeを実行
                                    --}}
                                    <button type="button" id="delete_button{{$loop->index}}" data-id={{ $recipe->id }}>delete</button>
                                    {{-- <button type="button" onclick="deleteRecipe({{ $recipe->id }})">delete</button> --}}
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    
    <div class=rakuten_recipes>
        <h1>楽天レシピ</h1>
        @foreach($rakuten_recipes as $rakuten_recipe)
            <div>
                <a href={{ $rakuten_recipe['recipeUrl'] }}>
                    {{ $rakuten_recipe['recipeTitle'] }}
                </a>
                <p class='cooking_time'>調理時間 : {{ $rakuten_recipe['recipeIndication'] }}</p>
                
                <h3 class='ingrediens'>材料リスト({{ $rakuten_recipe['recipeNumber'] }}人前)</h3>
                @foreach ($rakuten_recipe['recipeMaterialQuantity'] as $ingredient)
                    <p class='ingredient'>
                        {{ $ingredient['name'] }}　{{ $ingredient['serving'] }}
                    </p>
                @endforeach
                <img src="{{ $rakuten_recipe['foodImageUrl'] }}" width='300px'>
            </div>
        @endforeach
    </div>
                    
    <div class='paginate'>{{ $recipes->links() }}</div>
</x-app-layout>