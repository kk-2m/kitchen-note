<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('楽天レシピカテゴリ') }}
        </h2>
    </x-slot>
    <div class='login'>
            ログインユーザー：{{ Auth::user()->name }}
    </div>
    <div class='recipes'>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class='recipe'>
                            <div class=rakuten_recipes>
                                {{-- @foreach($rakuten_recipes as $rakuten_recipe)
                                    <div>
                                        <a href={{ $rakuten_recipe['recipeUrl'] }}>
                                            {{ $rakuten_recipe['recipeTitle'] }}
                                        </a>
                                        <p class='cooking_time'>調理時間 : {{ $rakuten_recipe['recipeIndication'] }}</p>
                                        
                                        <h3 class='ingrediens'>材料リスト({{ $rakuten_recipe['recipeNumber'] }}人前)</h3>
                                        @foreach ($rakuten_recipe['recipeMaterialQuantity'] as $ingredient)
                                            <p class='ingredient'>
                                                {{ $ingredient['name'] }}　{{ $ingredient['serving'] }}
                                            </p>
                                        @endforeach
                                        <img src="{{ $rakuten_recipe['foodImageUrl'] }}" width='300px'>
                                    </div>
                                @endforeach --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
                    
</x-app-layout>