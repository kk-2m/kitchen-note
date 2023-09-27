<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('楽天レシピ一覧') }}
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
                                @foreach($rakuten_categories as $rakuten_category)
                                    <div>
                                        <h2><a href="rakuten_recipes/{{ $rakuten_category->id }}">
                                            {{ $rakuten_category->name }}
                                        </a></h2>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</x-app-layout>