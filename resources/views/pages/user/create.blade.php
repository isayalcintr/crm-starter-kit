@extends('layouts.main')
@section('content')
    <div class="use-spinner card" id="user_create_card">
        <x-spinner.default />
        <div class="card-header">
            <h3 class="card-title">
                Yeni Ekle
            </h3>
        </div>
        <div class=" card-body pt-3.5 pb-3.5">
            @include("pages.user.partials.form", ["id" => "user_create_form"])
        </div>
        <div class="card-footer flex justify-end gap-4">
            <a class="btn btn-sm btn-clear btn-danger" href="{{ route('user.index') }}">
                İptal
            </a>
            <button class="btn btn-sm btn-primary" data-kt-user-create-submit-button="true">
                Kaydet
            </button>
        </div>
    </div>
@endsection
@section('customJs')
    @vite('resources/js/pages/user/create.js')
@endsection
