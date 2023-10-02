<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('献立一覧') }}
        </h2>
    </x-slot>
    <div class='login'>
            ログインユーザー：{{ Auth::user()->name }}
    </div>
    <div class='menus'>
        <button type='button'><a href="{{ route('menu_create') }}">create</a></button>
        @foreach ($menus as $menu)
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <div class='menu'>
                                <div>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $menu->date)->isoFormat('dddd') }}</div>
                                
                                <h2 class='name'>
                                    <a href="/recipes/{{ $menu->recipe_id }}">{{ $menu->recipe->title }}</a>
                                </h2>
                                @if ($menu->recipe->image != '')
                                    <img src="{{ asset($menu->recipe->image) }}" alt='料理写真' width='50%'>
                                @else
                                    <img src="{{ asset('storage/dish_image/noimage.png') }}" alt='料理写真' width='300px'>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
                    
</x-app-layout>