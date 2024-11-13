@extends('layouts.main')
@section('content')
    <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-7.5">
        <div class="flex flex-col justify-center gap-2">
            <h1 class="text-xl font-medium leading-none text-gray-900">
                Servis Ekle
            </h1>
        </div>
    </div>
    @include("pages.service.partials.form", ["id" => "service_create_form"])
    <div class="flex justify-end gap-4 mt-2">
        <a class="btn btn-sm btn-clear btn-danger" href="{{ route('service.index') }}">
            İptal
        </a>
        <button class="btn btn-sm btn-primary" data-kt-service-create-submit-button="true">
            Kaydet
        </button>
    </div>
@endsection
@section('customJs')
    @vite('resources/js/pages/service/create.js')
@endsection