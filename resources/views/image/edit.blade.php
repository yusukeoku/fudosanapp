<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('物件写真編集') }}
        </h2>
    </x-slot>

    <div style="display: flex; flex-wrap: wrap; justify-content: center; align-items: center;">
            @if(isset($images))
            <img src="{{ asset('storage/'. $images->image_path_1) }}" width="400" height="400">
            <img src="{{ asset('storage/'. $images->image_path_2) }}" width="400" height="400">
            <img src="{{ asset('storage/'. $images->image_path_3) }}" width="400" height="400">
            @endif
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <h2>
                @if(isset($images))
                <form action="{{ route('image.check') }}" method="post">
                    @csrf
                    @if($images->agent_check === 1)
                    <x-input-label for="name" :value="__('画像確認後、チェックをつけて保存ボタンを押してください。')" />
                    <input type="checkbox" checked="checked" name="check" id="check">
                    @else
                    <x-input-label for="name" :value="__('画像確認後、チェックをつけて保存ボタンを押してください。')" />
                    <input type="checkbox" name="check" id="check">
                    @endif
                    <br><br>
                    <input type="hidden" name="image_group_id" value="{{$images->image_group_id}}">
                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('保存') }}</x-primary-button>
                    </div>
                </form>
                @endif
                </h2>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <section>
                    <!-- <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('物件写真登録') }}
                        </h2>
                    </header> -->

                    @if(isset($images))
                    <form method="POST" action="{{ route('image.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                        <x-input-label for="name" :value="__('物件写真を更新します。')" />
                        <input type="file" name="image1">
                        <br><br>
                        <input type="file" name="image2">
                        <br><br>
                        <input type="file" name="image3">
                        <br><br>
                        <input type="hidden" name="image_group_id" value="{{$images->image_group_id}}">
                        <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('更新') }}</x-primary-button>
                    </div>
                    </form>
                    @else
                    <form method="POST" action="{{ route('image.create') }}" enctype="multipart/form-data">
                        @csrf
                        <x-input-label for="name" :value="__('物件写真を登録します。')" />
                        <br>
                        <input type="file" name="image1">
                        <br><br>
                        <input type="file" name="image2">
                        <br><br>
                        <input type="file" name="image3">
                        <br><br>
                        <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('登録') }}</x-primary-button>
                    </div>
                    </form>
                    @endif

                </section>
            </div>
        </div>
    </div>
</x-app-layout>
