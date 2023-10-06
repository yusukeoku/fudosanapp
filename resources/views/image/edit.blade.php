<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('画像登録') }}
        </h2>
    </x-slot>
    <div style="display: flex; flex-wrap: wrap; justify-content: center; align-items: center;">
    @foreach ($images as $image)
        <img src="{{ asset('storage/'. $image->image_path) }}" width = '100', height="100">
    @endforeach
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('image.partials.create')
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
