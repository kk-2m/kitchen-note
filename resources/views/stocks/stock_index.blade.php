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
        <button type="button"><a href="{{ route('stock_create') }}">[create]</a></button>
        @foreach ($stocks as $stock)
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <div class='stock'>
                                <a href="/stocks/{{ $stock->id }}/edit">[edit]</a>
                                <h2 class='name'>
                                    {{ $stock->ingredient->name }}<br>
                                    個数：
                                    @if ($stock->quantity == (int)$stock->quantity) {{ number_format($stock->quantity) }}{{ $stock->unit->name }}
                                    @else {{ $stock->quantity }}{{ $stock->unit->name }}
                                    @endif <br>
                                    購入日：{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $stock->created_at)->format('Y-m-d') }}<br>
                                    賞味・消費期限：{{ $stock->expiration_at }}
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
                    
    <div class='paginate'>{{ $stocks->links() }}</div>
</x-app-layout>