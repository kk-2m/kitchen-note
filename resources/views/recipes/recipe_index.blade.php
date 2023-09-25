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
        <button type="button"><a href="{{ route('create') }}">create</a></button>
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
                                        @if ($ingredient->pivot->unit->id === 14 || $ingredient->pivot->unit->id === 15)
                                            {{ $ingredient->pivot->unit->name }}{{ $ingredient->pivot->quantity }}
                                        @else
                                            {{ $ingredient->pivot->quantity }}{{ $ingredient->pivot->unit->name }}
                                        @endif
                                    </p>
                                @endforeach
                                @if ($recipe->image != '')
                                    <img src="{{ asset($recipe->image) }}">
                                @else
                                    <img src="{{ \Storage::url('dish_image/noimage.png') }}", alt='料理写真' width="50%">
                                @endif
            
                                <p>カテゴリ</p>
                                @foreach ($recipe->categories as $category)
                                    <p class='tag'>{{ $category->name }}</p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
                    
    <div class='paginate'>
        {{ $recipes->links() }}
    </div>
</x-app-layout>