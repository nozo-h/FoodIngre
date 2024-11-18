@props(['filename', 'type'])

{{-- ローカルの場合 --}}
@if(env('APP_ENV') === "local")
    {{-- プロフィールの場合 --}}
    @if($type === "profile")
        @if($filename)
            <img src="{{ asset($filename) }}" class="object-cover w-full h-full">
        @else
            <img src="{{ asset('pictures/sample/no-image.jpg') }}" class="object-cover w-full h-full">
        @endif

    {{-- 詳細画面の場合 --}}
    @elseif($type === "detail")
        @if($filename)
        <a href="{{ url($filename) }}" class="cursor-pointer">
            <img src="{{ asset($filename) }}">
        </a>
        @else
        <img src="{{ asset('pictures/sample/no-image.jpg') }}">
        @endif
    
    {{-- 編集画面の場合 --}}
    @elseif($type === 'edit')
        @if($filename)
        <a href="{{ asset($filename) }}" class="cursor-pointer">
            <img src="{{ asset($filename) }}" class="object-cover w-full h-full">
        </a>
        @else
        <img src="{{ asset('pictures/sample/no-image.jpg') }}">
        @endif

    @endif

    
{{-- AWSの場合 --}}
@elseif(env('APP_ENV') !== "local")
    {{-- プロフィールの場合 --}}
    @if($type === "profile")
        @if($filename)
            <img src="{{ "https://" . env('AWS_BUCKET') . ".s3." . env('AWS_DEFAULT_REGION') . ".amazonaws.com/" . $filename  }}" class="object-cover w-full h-full">
        @else
            <img src="{{ asset('pictures/sample/no-image.jpg') }}" class="object-cover w-full h-full">
        @endif

    {{-- 詳細画面の場合 --}}
    @elseif($type === "detail")
        @if($filename)
        <a href="{{ "https://" . env('AWS_BUCKET') . ".s3." . env('AWS_DEFAULT_REGION') . ".amazonaws.com/" . $filename }}" class="cursor-pointer">
            <img src="{{ "https://" . env('AWS_BUCKET') . ".s3." . env('AWS_DEFAULT_REGION') . ".amazonaws.com/" . $filename }}">
        </a>
        @else
        <img src="{{ asset('pictures/sample/no-image.jpg') }}">
        @endif

    {{-- 編集画面の場合 --}}
    @elseif($type === 'edit')
        @if($filename)
        <a href="{{ "https://" . env('AWS_BUCKET') . ".s3." . env('AWS_DEFAULT_REGION') . ".amazonaws.com/" . $filename }}" class="cursor-pointer">
            <img src="{{ "https://" . env('AWS_BUCKET') . ".s3." . env('AWS_DEFAULT_REGION') . ".amazonaws.com/" . $filename }}" class="object-cover w-full h-full">
        </a>
        @else
        <img src="{{ asset('pictures/sample/no-image.jpg') }}">
        @endif

    @endif

@endif
