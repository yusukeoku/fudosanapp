<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('物件写真編集') }}
        </h2>
    </x-slot>

    <div style="display: flex; flex-wrap: wrap; justify-content: center; align-items: center;">
        @foreach ($images as $image)
        <div>
            <img src="{{ asset('storage/'. $image->image_path) }}" width="400" height="400">
            <br>
        </div>
        @endforeach
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <h2>

                <form action="{{ route('image.check') }}" method="post">
                    @csrf

                    @foreach ($images as $image)
                    @if($image->agent_check === 1)
                    <input type="checkbox" checked="checked" name="check" id="check" value="0">チェック
                    @else
                    <input type="checkbox" name="check" id="check" value="1">チェック
                    @endif
                    @endforeach
                    <br><br>
                    <button type="submit">完了</button>

                </form>

                </h2>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <section>
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('物件写真登録・更新') }}
                        </h2>
                    </header>

                    <form method="POST" action="{{ route('image.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('patch') <!-- これがないと画像が表示されない -->

                        <br>
                        <p>物件写真1を登録・更新</p>
                        <input type="file" name="image1">
                        <br><br>
                        <p>物件写真2を登録・更新</p>
                        <input type="file" name="image2">
                        <br><br>
                        <p>物件写真3を登録・更新</p>
                        <input type="file" name="image3">
                        <br><br>
                        <button type="submit">登録・更新</button>
                    </form>
                </section>
            </div>
        </div>
    </div>
</x-app-layout>
