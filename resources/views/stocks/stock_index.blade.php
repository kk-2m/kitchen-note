<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('在庫情報一覧') }}
        </h2>
    </x-slot>
    <div class='login'>
            ログインユーザー：{{ Auth::user()->name }}
    </div>
    <div class='stocks'>
        {{--<input type="button" onclick="location.href='{{ route('stock_create') }}'" value="遷移">--}}
        <button type="button" class="my-btn"><a href="{{ route('stock_create') }}">stock create</a></button>
        @foreach ($stocks as $stock)
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <div class='stock'>
                                <a href="/stocks/{{ $stock->id }}/edit">[edit]</a>
                                <h2 class='name'>
                                    {{ $stock->ingredient->name }}<br>
                                </h2>
                                <div class='body'>
                                    個数：
                                    @if ($stock->quantity == (int)$stock->quantity) {{ number_format($stock->quantity) }}{{ $stock->unit->name }}
                                    @else {{ $stock->quantity }}{{ $stock->unit->name }}
                                    @endif <br>
                                    購入日：{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $stock->created_at)->format('Y-m-d') }}<br>
                                    賞味・消費期限：{{ $stock->expiration_at }}
                                </div>
                                <form action="/stocks/{{ $stock->id }}" id="form_{{ $stock->id }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    {{--
                                        typeにbuttonを指定する（デフォルトはsubmit）
                                        onclick(deleteRecipe)：要素がクリックされたさいに引数deleteRecipeを実行
                                    --}}
                                    <button type="button" id="delete_button{{$loop->index}}" data-id={{ $stock->id }}>delete</button>
                                    {{-- <button type="button" onclick="deleteRecipe({{ $recipe->id }})">delete</button> --}}
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
                    
    <div class='paginate'>{{ $stocks->links() }}</div>
</x-app-layout>