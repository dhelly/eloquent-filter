<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-2">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('dashboard') }}" method="POST">
                        @csrf
                        <!-- Name -->
                        <div>
                            <input id="search" name="search" class="block mt-1 w-full" type="text" value="{{ old('search') }}"/>
                            <button type="button" class="text-black bg-red-500 mt-2 py-3 px-4 rounded">Buscar</button>
                        </div>
                    </form>
                    {{ request('search') }}
                </div>
            </div>
        </div>



        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @foreach ($users as $user)
                        <li>{{ $user->id }} :: {{ $user->name }} :: {{ $user->email }} ::
                            <span @class(['bg-red-50 text-red-600'=> $user->admin])>{{ $user->admin? "ADMIN" : "Não é ADMIN"  }}</span> </li>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
