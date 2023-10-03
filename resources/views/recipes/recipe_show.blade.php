<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('レシピ詳細') }}
        </h2>
    </x-slot>
    <body>
        <div class='contents'>
            @if ($recipe->image != '')
                <img src="{{ asset($recipe->image) }}">
            @else
                <img src="{{ \Storage::url('dish_image/noimage.png') }}", alt='料理写真' width="50%">
            @endif
            <h2 class='title'>{{ $recipe->title }}</h2>

            <p class='cooking_time'>調理時間 : {{ $recipe->cooking_time }}
                @if ( $recipe->cooking_time_unit  == 1) 秒
                @elseif ( $recipe->cooking_time_unit  == 2) 分
                @elseif ( $recipe->cooking_time_unit  == 3) 時間
                @elseif ( $recipe->cooking_time_unit  == 4) 日
                @elseif ( $recipe->cooking_time_unit  == 5) ヶ月
                @elseif ( $recipe->cooking_time_unit  == 6) 年
                @endif
            </p>

            <p class='categories'>カテゴリ : 
                @foreach ($recipe->categories as $category)
                    {{ $category->name }}　
                @endforeach
            </p>

            <h3 class='ingrediens'>材料リスト({{ $recipe->number }}人前)</h3>
            @foreach ($recipe->ingredients as $ingredient)
                <p class='ingredient'>
                    {{ $ingredient->name }}　
                    @if ($ingredient->pivot->unit->id === 14 || $ingredient->pivot->unit->id === 15)
                        <!-- 小数点以下が0は整数表記 -->
                        @if ($ingredient->pivot->quantity == (int)$ingredient->pivot->quantity) {{ $ingredient->pivot->unit->name }}{{ number_format($ingredient->pivot->quantity) }}
                        @else {{ $ingredient->pivot->unit->name }}{{ $ingredient->pivot->quantity }}
                        @endif
                    @elseif ($ingredient->pivot->unit->id === 16)
                        {{ $ingredient->pivot->unit->name }}
                    @else
                        <!-- 小数点以下が0は整数表記 -->
                        @if ($ingredient->pivot->quantity == (int)$ingredient->pivot->quantity) {{ number_format($ingredient->pivot->quantity) }}{{ $ingredient->pivot->unit->name }}
                        @else {{ $ingredient->pivot->quantity }}{{ $ingredient->pivot->unit->name }}
                        @endif
                    @endif
                </p>
            @endforeach

            <h3 class='cooking_procedures'>作り方</h3>
            @foreach ($procedures as $procedure)
                <p class='cooking_procedure'>{{ $procedure->body }}</p>
            @endforeach
        </div>
        <div class="edit"><a href="/recipes/{{ $recipe->id }}/edit">edit</a></div>
        <div class='footer'>
            <a href="/recipes">戻る</a>
        </div>
    </body>
</x-app-layout>