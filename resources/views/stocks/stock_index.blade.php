<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('在庫情報一覧') }}
            </h2>
            <div class="flex justify-end">
                <button type="button" class="my-btn"><a href="{{ route('stock_create') }}">新規在庫作成</a></button>
            </div>
        </div>
    </x-slot>
    
    <div class='stocks py-6'>
        {{-- <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 mt-5 -mb-7">
            {{--<input type="button" onclick="location.href='{{ route('stock_create') }}'" value="遷移"> --}
            <button type="button" class="my-btn"><a href="{{ route('stock_create') }}">stock create</a></button>
        </div> --}}
        
        @foreach ($stocks as $stock)
            <div class="pt-6">
                <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-2 sm:p-6 text-gray-900">
                            <div class='stock'>
                                <div class="flex mb-3 justify-between">
                                    <div class='title'>
                                        <div class="font-bold text-2xl">
                                            {{ $stock->ingredient->name }}
                                        </div>
                                    </div>
                                    
                                    <div class="flex justify-end">
                                        <div class="flex-none">
                                            <button type="button" class="my-btn"><a href="{{ route('stock_edit', ['stock'=>$stock->id]) }}">編集</a></button>
                                        </div>
                                        <div class="flex-none px-4">
                                            <form action="{{ route('stock_delete', ['stock'=>$stock->id]) }}" id="form_{{ $stock->id }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                {{--
                                                    typeにbuttonを指定する（デフォルトはsubmit）
                                                    onclick(deleteRecipe)：要素がクリックされたさいに引数deleteRecipeを実行
                                                --}}
                                                <button type="button" class="my-btn" id="delete_button{{$loop->index}}" data-id={{ $stock->id }}>削除</button>
                                                {{-- <button type="button" onclick="deleteRecipe({{ $recipe->id }})">delete</button> --}}
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class='body'>
                                    個数：
                                    @if ($stock->quantity == (int)$stock->quantity) {{ number_format($stock->quantity) }}{{ $stock->unit->name }}
                                    @else {{ $stock->quantity }}{{ $stock->unit->name }}
                                    @endif <br>
                                    登録日：{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $stock->created_at)->format('Y-m-d') }}<br>
                                    <div class="flex">
                                        賞味・消費期限：
                                        @if ($stock->expiration_at >= $today)
                                            {{ $stock->expiration_at }}
                                        @else
                                            <div class="text-red-600">
                                                {{ $stock->expiration_at }}
                                            </div>
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
    
    {{-- <div class='paginate'>{{ $stocks->links() }}</div> --}}
    <div class="pagination pt-6">
        @if ($stocks->lastPage() > 1)
            <div class="flex items-center justify-center">
                <ul class="flex space-x-2 border border-2 border-gray-300 rounded overflow-hidden">
                    <li class="page-item {{ ($stocks->currentPage() == 1) ? ' disabled' : '' }} border-r-2 border-gray-300 hover:underline">
                        <a class="page-link block py-2 px-4" href="{{ $stocks->url(1) }}">First Page</a>
                    </li>
                    @if ($stocks->currentPage() > 1)
                        <li class="page-item border-r-2 border-gray-300 hover:underline">
                            <a class="page-link block py-2 px-4" href="{{ $stocks->url($stocks->currentPage()-1) }}">
                                <span aria-hidden="true">«</span>
                                {{-- Previous --}}
                            </a>
                        </li>
                    @endif
                    @for ($i = 1; $i <= $stocks->lastPage(); $i++)
                        <li class="page-item {{ ($stocks->currentPage() == $i) ? ' active bg-blue-500 text-white' : '' }} border-r-2 border-gray-300 hover:underline">
                            <a class="page-link block py-2 px-4" href="{{ $stocks->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor
                    @if ($stocks->currentPage() < $stocks->lastPage())
                        <li class="page-item border-r-2 border-gray-300 hover:underline">
                            <a class="page-link block py-2 px-4" href="{{ $stocks->url($stocks->currentPage() + 1) }}">
                                <span aria-hidden="true">»</span>
                                {{-- Next --}}
                            </a>
                        </li>
                    @endif
                    <li class="page-item {{ ($stocks->currentPage() == $stocks->lastPage()) ? ' disabled' : '' }} hover:underline">
                        <a class="page-link block py-2 px-4" href="{{ $stocks->url($stocks->lastPage()) }}">Last Page</a>
                    </li>
                </ul>
            </div>
        @endif
    </div>
</x-app-layout>