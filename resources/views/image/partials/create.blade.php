<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('画像登録') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("画像を登録できます") }}
        </p>
    </header>

    <form method="POST" action="{{ route('image.create') }}" enctype="multipart/form-data">
        @csrf
        <br>
        <p>画像1</p>
        <input type="file" name="image1">
        <p>画像2</p>
        <input type="file" name="image2">
        <p>画像3</p>
        <input type="file" name="image3">
        <br><br><br>
        <button type="submit">登録</button>
    </form>
</section>
