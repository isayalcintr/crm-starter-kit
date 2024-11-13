@props(['text' => 'Lütfen bekleyiniz!' ])
<div class="spinner-wrapper">
    <div class="flex flex-col items-center justify-center gap-2 h-screen">
        <div class="spinner animate-spin rounded-full border-4 border-t-4 border-orange-500 border-t-transparent w-8 h-8"></div>
        <span class="spinner-text text-orange-500 text-2xl">{{ $text }}</span>
    </div>
</div>
