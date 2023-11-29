<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('献立一覧') }}
            </h2>
            <div class="flex justify-end">
                <button type='button' class="my-btn"><a href="{{ route('menu_create') }}">献立作成</a></button>
            </div>
        </div>
        
    </x-slot>

    <div class='menus py-6'>
        
        @foreach ($menus as $menu)
            <div class="pt-6 pb-6">
                <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-2 sm:p-6 text-gray-900">
                            <div class='menu'>
                                <div class="date flex mb-3 justify-between">
                                    <div class="font-bold text-2xl">
                                        <div>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $menu->date)->isoFormat('dddd') }}</div>
                                    </div>
                                    <div class="flex justify-end">
                                        <div class="flex-none px-1 sm:px-4">
                                            <form id="shoppingDataForm{{ $menu->id }}">
                                                @csrf
                                                @foreach($menu->ingredients as $ingredient)
                                                    <input type="hidden" name="slist[{{ $loop->index }}][user_id]" value="{{ Auth::user()->id }}"/>
                                                    <input type="hidden" name="slist[{{ $loop->index }}][ingredient_id]" value="{{ $ingredient->id }}"/>
                                                    <input type="hidden" name="slist[{{ $loop->index }}][menu_id]" value="{{ $menu->id }}"/>
                                                    <input type="hidden" name="slist[{{ $loop->index }}][quantity]" value="{{ (float)$ingredient->pivot->quantity }}"/>
                                                    <input type="hidden" name="slist[{{ $loop->index }}][unit_id]" value="{{ $ingredient->pivot->unit_id }}"/>
                                                @endforeach
                                                <button type="button" class="my-btn" id="add2shoppinglist{{ $loop->index }}" data-id='{{ $menu->id }}'>買い物リストに追加</button>
                                            </form>
                                        </div>
                                        <div class="flex-none">
                                            <button type='button' class="my-btn"><a href="/menus/{{ $menu->id }}/edit">編集</a></button>
                                        </div>
                                        <div class="flex-none px-1 sm:px-4">
                                            <form action="/menus/{{ $menu->id }}" id="form_{{ $menu->id }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                {{--
                                                    typeにbuttonを指定する（デフォルトはsubmit）
                                                    JSにdata-idでmenuのidを渡す
                                                    それに対応するレコードを削除
                                                --}}
                                                <button type="button" class="my-btn" id="delete_button{{$loop->index}}" data-id={{ $menu->id }}>削除</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class='title'>
                                        <a href="/recipes/{{ $menu->recipe_id }}" class="font-semibold text-xl hover:underline">{{ $menu->recipe->title }}</a>
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
                                        @if ($menu->recipe->image != '')
                                            <img src="https://rihwablog.com/KitchenNote/{{ $menu->recipe->image }}" alt='料理写真'>
                                        @else
                                            <img src="https://rihwablog.com/KitchenNote/noimage.png" alt='料理写真' width='300px'>
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
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/themes/smoothness/jquery-ui.css">
    <script>
        $(document).ready(function () {
            $('[id*="add2shoppinglist"]').each(function () {
                // チェックボックスが変更されたら非同期でコントローラーにリクエストを送る
                $(this).on('click', function () {
                    console.log('enter the function');
                    
                    // data-id属性を取得
                    const dataId = $(this).data("id");
                    console.log(dataId);
                    var formData = $('#shoppingDataForm'+dataId).serialize();
                    console.log(formData);
                    add2ShoppinglistUrl = `/menus/${dataId}/add2shoppinglist`;
                    // 指定のURLに非同期でPUTリクエストを送信
                    $.ajax({
                        url: add2ShoppinglistUrl,
                        method: "PUT",
                        data: formData,
                    }).done(function (response) {
                        console.log(response);
                        alert(response['message']);
                    }).fail(function(response){
                        console.log(response);
                        alert('通信の失敗をしました');
                    });
                });
            });
        });
    </script>
</x-app-layout>