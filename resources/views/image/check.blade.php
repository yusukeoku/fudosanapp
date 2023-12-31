<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('画像確認') }}
        </h2>
    </x-slot>
    <div style="display: flex; flex-wrap: wrap; justify-content: center; align-items: center;">

    @foreach ($images as $image)
    <div>
        <img src="{{ asset('storage/'. $image->image_path) }}" width="400" height="400">
        <br>
    </div>
    @endforeach

    <br>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">

            <h2>
            <form action="{{ route('image.check') }}" method="post">
            @csrf
                <input type="checkbox" name="checkbox_tenant" id="checkbox_tenant" value="1">チェック
                <br>
                <input type="hidden" name="image_group_id" id="image_group_id" value="{{$images->image_group_id}}">
                <button type="submit">更新</button>
            </form>
            </h2>

<section>
    <header>
        <!-- <h2 class="text-lg font-medium text-gray-900">
            {{ __('画像更新') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("画像を更新できます") }}
        </p> -->
    </header>

    <form method="POST" action="{{ route('image.update') }}" enctype="multipart/form-data">
        @csrf
        <br>
        <!-- <p>画像1を更新</p>
        <input type="file" name="image1">
        <br>
        <p>画像2を更新</p>
        <input type="file" name="image2">
        <br>
        <p>画像3を更新</p>
        <input type="file" name="image3">
        <br><br><br>
        <button type="submit">登録</button> -->
    </form>
</section>

            </div>
        </div>
    </div>

</x-app-layout>
