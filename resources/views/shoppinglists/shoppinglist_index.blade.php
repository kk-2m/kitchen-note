<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('買い物リスト') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="text-2xl font-black">買い物リストへ追加</div>
                    <form action="{{ route('shoppinglist_store') }}" method="POST" enctype="multipart/form-data" class="mt-5">
                        @csrf
                  
                        <div class="flex flex-col">
                            <div class="slist_name sm:mx-5 lg:mx-10">
                                <label for="name" class="font-semibold">材料名：</label>
                                <input
                                    class="placeholder:italic placeholder:text-slate-400 bg-white border border-slate-300 rounded-md py-4 pl-4 shadow-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500 focus:ring-1"
                                    id="name" placeholder="じゃがいも" type="text" name="ingredient[name]" value="{{ old('ingredient.name') }}" autocomplete="off"/>
                                <p class="ingredient_error" style="color:red">{{ $errors->first('ingredient.name') }}</p>
                            </div>
                            <div class="flex sm:ml-5 lg:ml-10">
                                <div class="slist_quantity">
                                    <label for="quantity" class="font-semibold">量：</label>
                                    <input
                                        class="placeholder:italic placeholder:text-slate-400 bg-white border border-slate-300 rounded-md py-4 pl-4 shadow-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500 focus:ring-1"
                                        id="quantity" placeholder="7" type="number" name="slist[quantity]" value="{{ old('stock.quantity') }}" min="1" step="0.01" max="99999999"/>
                                    <p class="quantity_error" style="color:red">{{ $errors->first('slist.quantity') }}</p>
                                </div>
                                <div class="ingredient_unit pl-5">
                                    <select name="slist[unit_id]" id="select_ingredient_unit"
                                            class="bg-white border border-slate-300 rounded-md py-4 pl-4 shadow-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500 focus:ring-1">
                                        <option value="">単位を選んでください</option>
                                        @foreach ($units as $unit)
                                            <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                        @endforeach
                                    </select>
                                    <p class="unit_error" style="color:red">{{ $errors->first("ingredient_recipe.unit_id") }}</p>
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit"
                                    class="mt-8 p-4 bg-slate-900 text-white w-full max-w-xs hover:bg-slate-700 transition-colors">
                                    追加する
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <div class='slists'>
        
        
        <div class="pb-12">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="text-2xl font-black">一覧</div>
                        @foreach ($slists as $slist)
                            <div class='slist'>
                                <div class="flex my-3 justify-between">
                                    <div class="flex">
                                        <form id="updateStatusForm">
                                            @csrf
                                            <input type="hidden" name="slist[id]" value="{{ $slist->id }}"/>
                                            {{-- var_dump($slist->id) --}}
                                            <input type="hidden" name="slist[status]" value="0"/>
                                            <input id='status-checkbox' type="checkbox" name="slist[status]" value="1" {{ (int)$slist->status === 1 ? 'checked' : "" }}/>
                                        </form>
                                        <div class='flex text-xl ml-8'>
                                            <div class="ingredient_name">
                                                <div class="font-bold">
                                                    {{ $slist->ingredient->name }}
                                                </div>
                                            </div>
                                            <div class='body ml-4'>
                                                @if ($slist->quantity == (int)$slist->quantity) {{ number_format($slist->quantity) }}{{ $slist->unit->name }}
                                                @else {{ $slist->quantity }}{{ $slist->unit->name }}
                                                @endif 
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="flex justify-end">
                                        <div class="flex-none">
                                            <button type="button" class="my-btn"><a href="route('shoppinglist_edit', ['slist' => $slist->id]) }}">編集</a></button>
                                        </div>
                                        <div class="flex-none px-4">
                                            <form action="{{ route('shoppinglist_delete', ['slist' => $slist->id]) }}" id="form_{{ $slist->id }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                {{--
                                                    typeにbuttonを指定する（デフォルトはsubmit）
                                                    onclick(deleteRecipe)：要素がクリックされたさいに引数deleteRecipeを実行
                                                --}}
                                                <button type="button" class="my-btn" id="delete_button{{$loop->index}}" data-id={{ $slist->id }}>削除</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/themes/smoothness/jquery-ui.css">
    <script>
        
        $(document).ready(function () {
            // 入力候補から選ばれたかのflag
            var autoCompleteSelected = false;
            
            $('#name').autocomplete({
                source: function (request, response) {
                    console.log(request);
                    $.ajax({
                        url: "{{ route('shoppinglist_search') }}",
                        data: { term:request.term },
                        dataType: "json",
                        success: function( data ) {
                            console.log(data);
                            var formattedData = data.map(function (item) {
                                return {
                                    label: item.name,  // 表示するテキスト
                                    value: item.name   // 実際にフォームにセットされる値
                                };
                            });
                            response(formattedData);
                        }
                    });
                },
                autoFocus: true,
                delay: 500,
                minLength: 1,
                select: function (event, ui) {
                    autoCompleteSelected = true;
                },
            });
            
            $('#name').on('blur', function () {
                if (!autoCompleteSelected) {
                    // Ignore manual input when autoCompleteSelected is false
                    $(this).val("");
                }
                autoCompleteSelected = false;
            });
            
            $('#status-checkbox').change(function () {
                // チェックボックスが変更されたら非同期でサーバーにリクエストを送る
                var formData = $('#updateStatusForm').serialize();
                console.log(formData);
                
                // 指定のURLに非同期でPUTリクエストを送信
                $.ajax({
                    url: "{{ route('shoppinglist_updateStatus', ['slist' => $slist->id]) }}",
                    method: "PUT",
                    data: formData,
                }).done(function (response) {
                    console.log(response);
                }).fail(function(){
                    alert('通信の失敗をしました');
                });
            });
        });
    </script>
</x-app-layout>