<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('献立一覧') }}
        </h2>
        <div class="flex justify-end">
            <button type='button' class="my-btn"><a href="{{ route('menu_create') }}">献立作成</a></button>
        </div>
    </x-slot>

    <div class='menus'>
        
        @foreach ($menus as $menu)
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <div class='menu'>
                                <div class="date flex mb-3 justify-between">
                                    <div class="font-bold text-2xl">
                                        <div>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $menu->date)->isoFormat('dddd') }}</div>
                                    </div>
                                    <div class="flex justify-end">
                                        <div class="flex-none">
                                            <button type='button' class="my-btn"><a href="/menus/{{ $menu->id }}/edit">edit</a></button>
                                        </div>
                                        <div class="flex-none px-4">
                                            <form action="/menus/{{ $menu->id }}" id="form_{{ $menu->id }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                {{--
                                                    typeにbuttonを指定する（デフォルトはsubmit）
                                                    JSにdata-idでmenuのidを渡す
                                                    それに対応するレコードを削除
                                                --}}
                                                <button type="button" class="my-btn" id="delete_button{{$loop->index}}" data-id={{ $menu->id }}>delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class='title font-semibold text-xl hover:underline'>
                                    <a href="/recipes/{{ $menu->recipe_id }}">{{ $menu->recipe->title }}</a>
                                </div>
                                
                                <div class='flex pt-4'>
                                    <div class="flex-1">
                                        <p class='cooking_time'>調理時間 : {{ $menu->recipe->cooking_time }}
                                            @if ( $menu->recipe->cooking_time_unit  == 1) 秒
                                            @elseif ( $menu->recipe->cooking_time_unit  == 2) 分
                                            @elseif ( $menu->recipe->cooking_time_unit  == 3) 時間
                                            @elseif ( $menu->recipe->cooking_time_unit  == 4) 日
                                            @elseif ( $menu->recipe->cooking_time_unit  == 5) ヶ月
                                            @elseif ( $menu->recipe->cooking_time_unit  == 6) 年
                                            @endif
                                        </p>
                                        
                                        <div class="text-lg font-semibold pt-4">カテゴリ</div>
                                        @foreach ($menu->recipe->categories as $category)
                                            <p class='tag'>{{ $category->name }}</p>
                                        @endforeach
                                        
                                        <div class='text-lg font-semibold pt-4'>
                                            材料リスト（{{ $menu->number }}人前）<br>
                                        </div>
                                        @foreach($menu->ingredients as $ingredient)
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
                                    </div>
                                    <div class="flex-1">
                                        @if ($menu->recipe->image != '')
                                            <img src="{{ asset($menu->recipe->image) }}" alt='料理写真' width='50%'>
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
                    
</x-app-layout>