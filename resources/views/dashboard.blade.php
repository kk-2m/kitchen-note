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
                        <div class="text-2xl font-black">
                            <div class="flex">
                                <div class="text-yellow-500">・</div>
                                <div class="text-yellow-700">・</div>
                                <div class="text-yellow-500 pr-2">・</div>
                                楽天レシピで人気のレシピ
                            </div>
                        </div>
                            
                            @foreach($rakuten_recipes as $rakuten_recipe)
                                <div class='rakuten_recipe border-b border-gray-300 py-4'>
                                    <div class="">
                                        <div class="flex font-bold text-2xl">
                                            @if ($loop->iteration == 1)
                                                <div class="circle1">
                                                    {{ $loop->iteration }}
                                                </div>
                                            @elseif ($loop->iteration == 2)
                                                <div class="circle2">
                                                    {{ $loop->iteration }}
                                                </div>
                                            @elseif ($loop->iteration == 3)
                                                <div class="circle3">
                                                    {{ $loop->iteration }}
                                                </div>
                                            @else
                                                <div class="circle">
                                                    {{ $loop->iteration }}
                                                </div>
                                            @endif
                                            <div class="ml-3 hover:underline">
                                                <a href={{ $rakuten_recipe->url }}>
                                                    {{ $rakuten_recipe->title }}
                                                </a>
                                            </div>
                                        </div>
                                        <div class="flex">
                                            <div class="flex-1">
                                                <p class='cooking_time'>調理時間 : {{ $rakuten_recipe->cooking_time }}</p>
                                                
                                                <div class='ingrediens'>
                                                    <div class="text-lg font-semibold pt-4">
                                                        材料リスト({{ $rakuten_recipe->number }}人前)
                                                    </div>
                                                </div>
                                                @foreach ($rakuten_recipe->rakuten_ingredients as $ingredient)
                                                    <p class='ingredient'>
                                                        {{ $ingredient->name }}　{{ $ingredient->pivot->serving }}
                                                    </p>
                                                @endforeach
                                            </div>
                                            <div class="flex-1">
                                                <img src="{{ $rakuten_recipe->image }}" width='300px'>
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
