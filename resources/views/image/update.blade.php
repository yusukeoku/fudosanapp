<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('画像更新') }}
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

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('画像更新') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("画像を更新できます") }}
        </p>
    </header>

    <form action="./index.php" method="post">
        <input type="checkbox" name="checkbox_name" id="" value="1">チェックテスト
        <button type="submit">送信</button>
    </form>

    <form method="POST" action="{{ route('image.update') }}" enctype="multipart/form-data">
        @csrf
        <p>画像1を更新するために画像1を指定する</p>
        <input type="file" name="image1">
        <p>画像2を更新するために画像2を指定する</p>
        <input type="file" name="image2">
        <p>画像3を更新するために画像3を指定する</p>
        <input type="file" name="image3">
        <button type="submit">登録</button>
    </form>
</section>

            </div>
        </div>
    </div>

</x-app-layout>

