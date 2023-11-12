<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('レシピ詳細') }}
        </h2>
    </x-slot>
    
    <div class='contents'>
        <div class="py-12">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex pb-4 justify-between">
                            <div class='title'>
                                <div class="font-bold text-2xl">
                                    {{ $recipe->title }}
                                </div>
                            </div>
                            <div class="flex justify-end">
                                <div class="flex-none px-4">
                                    <div class="edit">
                                        <div class="my-btn">
                                            <a href="{{ route('recipe_edit', ['recipe'=>$recipe->id]) }}">編集</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                            
                        <div class="flex space-x-4">
                            <div class="flex-auto max-w-md mx-auto">
                                <div class="image">
                                    @if ($recipe->image != '')
                                        <img src="https://rihwablog.com/KitchenNote/{{ $recipe->image }}">
                                    @else
                                        <img src="https://rihwablog.com/KitchenNote/noimage.png", alt='料理写真' width="50%">
                                    @endif
                                </div>
                            </div>
                            <div class="flex-auto">
                                <div class="flex-none w-128">
                                    <p class='cooking_time'>調理時間 : {{ $recipe->cooking_time }}
                                        @if ( $recipe->cooking_time_unit  == 1) 秒
                                        @elseif ( $recipe->cooking_time_unit  == 2) 分
                                        @elseif ( $recipe->cooking_time_unit  == 3) 時間
                                        @elseif ( $recipe->cooking_time_unit  == 4) 日
                                        @elseif ( $recipe->cooking_time_unit  == 5) ヶ月
                                        @elseif ( $recipe->cooking_time_unit  == 6) 年
                                        @endif
                                    </p>
                        
                                    <div class='categories'>
                                        <div class="text-lg font-semibold">カテゴリ : </div>
                                            @foreach ($recipe->categories as $category)
                                                {{ $category->name }}　
                                            @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        
            
                        <div class='ingrediens'>
                            <div class="text-lg font-semibold pt-4">
                                材料リスト({{ $recipe->number }}人前)
                            </div>
                        </div>
                        @foreach ($recipe->ingredients as $ingredient)
                            <div class='ingredient'>
                                {{ $ingredient->name }}　
                                @if ($ingredient->pivot->unit->id === 14 || $ingredient->pivot->unit->id === 15)
                                    <!-- 小数点以下が0は整数表記 -->
                                    @if ($ingredient->pivot->quantity == (int)$ingredient->pivot->quantity) {{ $ingredient->pivot->unit->name }} {{ number_format($ingredient->pivot->quantity) }}
                                    @else {{ $ingredient->pivot->unit->name }} {{ $ingredient->pivot->quantity }}
                                    @endif
                                @elseif ($ingredient->pivot->unit->id === 16)
                                    {{ $ingredient->pivot->unit->name }}
                                @else
                                    <!-- 小数点以下が0は整数表記 -->
                                    @if ($ingredient->pivot->quantity == (int)$ingredient->pivot->quantity) {{ number_format($ingredient->pivot->quantity) }} {{ $ingredient->pivot->unit->name }}
                                    @else {{ $ingredient->pivot->quantity }} {{ $ingredient->pivot->unit->name }}
                                    @endif
                                @endif
                            </div>
                        @endforeach
            
                        <div class='cooking_procedures'>
                            <div class="text-lg font-semibold pt-4">作り方</div>
                        </div>
                        @foreach ($procedures as $procedure)
                            <p class='cooking_procedure'>{{ $procedure->body }}</p>
                        @endforeach
                        
                        <div class="footer w-20 pt-4">
                            <button type="button" class="my-btn" onclick="history.back()">戻る</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>