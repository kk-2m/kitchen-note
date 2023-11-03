<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}<br>
                    {{ __("Have a nice day!") }}
                </div>
            </div>
        </div>
    </div>
    <div class=rakuten_recipes>
        <div class="pb-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="text-2xl font-black">人気ランキング</div>
                            @foreach($rakuten_recipes as $rakuten_recipe)
                                <div class='rakuten_recipe border-b border-gray-300 py-4'>
                                    <div class="">
                                        <div class="font-bold text-2xl hover:underline">
                                            <a href={{ $rakuten_recipe['recipeUrl'] }}>
                                                {{ $rakuten_recipe['recipeTitle'] }}
                                            </a>
                                        </div>
                                        <div class="flex">
                                            <div class="flex-1">
                                                <p class='cooking_time'>調理時間 : {{ $rakuten_recipe['recipeIndication'] }}</p>
                                                
                                                <div class='ingrediens'>
                                                    <div class="text-lg font-semibold pt-4">
                                                        材料リスト({{ $rakuten_recipe['recipeNumber'] }}人前)
                                                    </div>
                                                </div>
                                                @foreach ($rakuten_recipe['recipeMaterialQuantity'] as $ingredient)
                                                    <p class='ingredient'>
                                                        {{ $ingredient['name'] }}　{{ $ingredient['serving'] }}
                                                    </p>
                                                @endforeach
                                            </div>
                                            <div class="flex-1">
                                                <img src="{{ $rakuten_recipe['foodImageUrl'] }}" width='300px'>
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
    </div>
</x-app-layout>
