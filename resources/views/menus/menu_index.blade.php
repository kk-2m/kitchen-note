<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('献立一覧') }}
        </h2>
    </x-slot>
    <div class='login'>
            ログインユーザー：{{ Auth::user()->name }}
    </div>
    <div class='menus'>
        <button type='button'><a href="{{ route('menu_create') }}">create</a></button>
        @foreach ($menus as $menu)
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <div class='menu'>
                                <div>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $menu->date)->isoFormat('dddd') }}</div>
                                
                                <button type='button'><a href="/menus/{{ $menu->id }}/edit">edit</a></button>
                                
                                <h2 class='name'>
                                    <a href="/recipes/{{ $menu->recipe_id }}">{{ $menu->recipe->title }}</a>
                                </h2>
                                <div class='body'>
                                    材料{{ $menu->number }}人前<br>
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
                                    @if ($menu->recipe->image != '')
                                        <img src="{{ asset($menu->recipe->image) }}" alt='料理写真' width='50%'>
                                    @else
                                        <img src="{{ asset('storage/dish_image/noimage.png') }}" alt='料理写真' width='300px'>
                                    @endif
                                </div>
                                <form action="/menus/{{ $menu->id }}" id="form_{{ $menu->id }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    {{--
                                        typeにbuttonを指定する（デフォルトはsubmit）
                                        JSにdata-idでmenuのidを渡す
                                        それに対応するレコードを削除
                                    --}}
                                    <button type="button" id="delete_button{{$loop->index}}" data-id={{ $menu->id }}>delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
                    
</x-app-layout>