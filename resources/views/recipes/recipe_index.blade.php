<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('レシピ一覧') }}
            </h2>
            <div class="flex justify-end">
                <button type="button" class="my-btn"><a href="{{ route('recipe_create') }}">レシピ作成</a></button>
            </div>
        </div>
        
    </x-slot>
    
    <div class='recipes py-6 pb-6'>
        
        <!--<button type="button"><a href="/recipes/getCategories">get categories</a></button>-->
        @foreach ($recipes as $recipe)
            <div class="pt-6">
                <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-2 sm:p-6 text-gray-900">
                            <div class='recipe'>
                                <div class="flex  mb-5 justify-between">
                                    <div class='title'>
                                        <div class="font-bold text-2xl pl-2 hover:underline">
                                            <a href="{{ route('recipe_show', ['recipe'=>$recipe->id]) }}">{{ $recipe->title }}</a>
                                        </div>
                                    </div>
                                    
                                    <div class="flex justify-end">
                                        <div class="flex-none px-2">
                                            <!-- リンクを使用し、献立作成画面に各レシピのidを渡す -->
                                            <button type="button" class="my-btn"><a href="{{ route('menu_create', ['recipe_id' => $recipe->id]) }}">献立追加</a></button>
                                        </div>
                                        <div class="flex-none pl-2 sm:px-4">
                                            <form action="{{ route('recipe_delete', ['recipe'=>$recipe->id]) }}" id="form_{{ $recipe->id }}" method="post">
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
                                        
                                        <div class="text-lg font-semibold pt-4">カテゴリ</div>
                                        @foreach ($recipe->categories as $category)
                                            <p class='tag'>{{ $category->name }}</p>
                                        @endforeach
                        
                                        <div class='ingrediens'>
                                            <div class="text-lg font-semibold pt-4">
                                                材料リスト（{{ $recipe->number }}人前）
                                            </div>
                                        </div>
                                        @foreach ($recipe->ingredients as $ingredient)
                                            <p class='ingredient'>
                                                {{ $ingredient->name }}　
                                                <!--　小さじ, 大さじ　-->
                                                @if ($ingredient->pivot->unit->id === 14 || $ingredient->pivot->unit->id === 15)
                                                    <!-- 小数点以下が0は整数表記 -->
                                                    @if ($ingredient->pivot->quantity == (int)$ingredient->pivot->quantity) {{ $ingredient->pivot->unit->name }} {{ number_format($ingredient->pivot->quantity) }}
                                                    @else {{ $ingredient->pivot->unit->name }} {{ $ingredient->pivot->quantity }}
                                                    @endif
                                                <!-- 適量は適量のみ表示 -->
                                                @elseif ($ingredient->pivot->unit->id === 16) {{ $ingredient->pivot->unit->name }}
                                                @else
                                                    @if ($ingredient->pivot->quantity == (int)$ingredient->pivot->quantity) {{ number_format($ingredient->pivot->quantity) }} {{ $ingredient->pivot->unit->name }}
                                                    @else {{ $ingredient->pivot->quantity }} {{ $ingredient->pivot->unit->name }}
                                                    @endif
                                                @endif
                                            </p>
                                        @endforeach
                                    </div>
                                    <div class="flex-1 max-w-xs">
                                        @if ($recipe->image != '')
                                            <img src="https://rihwablog.com/KitchenNote/{{ $recipe->image }}" alt='料理写真' max-width='100px'>
                                        @else
                                            <img src="https://rihwablog.com/KitchenNote/noimage.png" alt='料理写真'>
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
    
    <div class="pagination pt-6">
        @if ($recipes->lastPage() > 1)
            <div class="flex items-center justify-center">
                <ul class="flex space-x-2 border border-2 border-gray-300 rounded overflow-hidden">
                    <li class="page-item {{ ($recipes->currentPage() == 1) ? ' disabled' : '' }} border-r-2 border-gray-300 hover:underline">
                        <a class="page-link block py-2 px-4" href="{{ $recipes->url(1) }}">First Page</a>
                    </li>
                    @if ($recipes->currentPage() > 1)
                        <li class="page-item border-r-2 border-gray-300 hover:underline">
                            <a class="page-link block py-2 px-4" href="{{ $recipes->url($recipes->currentPage()-1) }}">
                                <span aria-hidden="true">«</span>
                                {{-- Previous --}}
                            </a>
                        </li>
                    @endif
                    @for ($i = 1; $i <= $recipes->lastPage(); $i++)
                        <li class="page-item {{ ($recipes->currentPage() == $i) ? ' active bg-blue-500 text-white' : '' }} border-r-2 border-gray-300 hover:underline">
                            <a class="page-link block py-2 px-4" href="{{ $recipes->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor
                    @if ($recipes->currentPage() < $recipes->lastPage())
                        <li class="page-item {{ ($recipes->currentPage() == $recipes->lastPage()) ? ' disabled' : '' }} border-r-2 border-gray-300 hover:underline">
                            <a class="page-link block py-2 px-4" href="{{ $recipes->url($recipes->currentPage()+1) }}" >
                                <span aria-hidden="true">»</span>
                                {{-- Next --}}
                            </a>
                        </li>
                    @endif
                    <li class="page-item {{ ($recipes->currentPage() == $recipes->lastPage()) ? ' disabled' : '' }} hover:underline">
                        <a class="page-link block py-2 px-4" href="{{ $recipes->url($recipes->lastPage()) }}">Last Page</a>
                    </li>
                </ul>
            </div>
        @endif
    </div>
</x-app-layout>