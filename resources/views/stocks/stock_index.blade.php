<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('レシピ一覧') }}
        </h2>
    </x-slot>
    <div class='login'>
            ログインユーザー：{{ Auth::user()->name }}
    </div>
    <div class='stocks'>
        <button type="button"><a href="{{ route('recipe_create') }}">create</a></button>
        @foreach ($stocks as $stock)
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <div class='stock'>
                                <h2 class='name'>
                                    {{ $stock->ingredient->name }}
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