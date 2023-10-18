<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('レシピ一覧') }}
        </h2>
    </x-slot>
    
    <div class='recipes'>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-5 -mb-7">
            <button type="button" class="my-btn"><a href="{{ route('recipe_create') }}">レシピ作成</a></button>
        </div>
        
        <!--<button type="button"><a href="/recipes/getCategories">get categories</a></button>-->
        @foreach ($recipes as $recipe)
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <div class='recipe'>
                                <div class="flex  mb-5 justify-between">
                                    <div class='title'>
                                        <div class="font-bold text-2xl hover:underline">
                                            <a href="/recipes/{{ $recipe->id }}">{{ $recipe->title }}</a>
                                        </div>
                                    </div>
                                    
                                    <div class="flex w-64 justify-end">
                                        <div class="flex1 w-30 px-4">
                                            <!-- リンクを使用し、献立作成画面に各レシピのidを渡す -->
                                            <button type="button" class="my-btn"><a href="{{ route('menu_create', ['recipe_id' => $recipe->id]) }}">献立追加</a></button>
                                        </div>
                                        <div class="flex1 w-10">
                                            <form action="/recipes/{{ $recipe->id }}" id="form_{{ $recipe->id }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                {{--
                                                    typeにbuttonを指定する（デフォルトはsubmit）
                                                    onclick(deleteRecipe)：要素がクリックされたさいに引数deleteRecipeを実行
                                                --}}
                                                <button type="button" class="my-btn" id="delete_button{{$loop->index}}" data-id={{ $recipe->id }}>削除</button>
                                                {{-- <button type="button" onclick="deleteRecipe({{ $recipe->id }})">delete</button> --}}
                                            </form>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="flex">
                                    <div class="flex-1">
                                        <p class='cooking_time'>調理時間 : {{ $recipe->cooking_time }}
                                            @if ( $recipe->cooking_time_unit  == 1) 秒
                                            @elseif ( $recipe->cooking_time_unit  == 2) 分
                                            @elseif ( $recipe->cooking_time_unit  == 3) 時間
                                            @elseif ( $recipe->cooking_time_unit  == 4) 日
                                            @elseif ( $recipe->cooking_time_unit  == 5) ヶ月
                                            @elseif ( $recipe->cooking_time_unit  == 6) 年
                                            @endif
                                        </p>
                        
                                        <div class='ingrediens'>
                                            <div class="text-lg font-semibold">
                                                材料リスト({{ $recipe->number }}人前)
                                            </div>
                                        </div>
                                        @foreach ($recipe->ingredients as $ingredient)
                                            <p class='ingredient'>
                                                {{ $ingredient->name }}　
                                                <!--　小さじ, 大さじ　-->
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
                    
                                        <div class="text-lg font-semibold">カテゴリ</div>
                                        @foreach ($recipe->categories as $category)
                                            <p class='tag'>{{ $category->name }}</p>
                                        @endforeach
                                    </div>
                                    <div class="flex-1">
                                        @if ($recipe->image != '')
                                            <img src="{{ asset($recipe->image) }}" alt='料理写真' width='50%'>
                                        @else
                                            <img src="{{ asset('storage/dish_image/noimage.png') }}" alt='料理写真' width='300px'>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    
    {{-- <div class=rakuten_recipes>
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
    </div> --}}
                    
    <div class='paginate'>{{ $recipes->links() }}</div>
</x-app-layout>