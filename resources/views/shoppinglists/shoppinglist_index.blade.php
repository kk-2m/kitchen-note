<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('買い物リスト') }}
            </h2>
            <div class="flex justify-end">
                <button type="button" class="my-btn"><a href="{{ route('shoppinglist_create') }}">買い物リスト追加</a></button>
            </div>
        </div>
    </x-slot>
    
    <div class='slists'>
        
        @foreach ($slists as $slist)
            <div class="py-12">
                <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
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
                                            <div class="">
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
                                            <button type="button" class="my-btn"><a href="route('shoppinglist_edit', ['shoppinglist' => $slist->id]) }}">編集</a></button>
                                        </div>
                                        <div class="flex-none px-4">
                                            <form action="{{ route('shoppinglist_delete', ['shoppinglist' => $slist->id]) }}" id="form_{{ $slist->id }}" method="post">
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
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function () {
            console.log('hello');
            $('#status-checkbox').change(function () {
                // チェックボックスが変更されたら非同期でサーバーにリクエストを送る
                var formData = $('#updateStatusForm').serialize();
                console.log('enter the function');
                console.log(formData);
                
                // 指定のURLに非同期でPUTリクエストを送信
                $.ajax({
                    url: "{{ route('shoppinglist_updateStatus', ['shoppinglist' => $slist->id]) }}",
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