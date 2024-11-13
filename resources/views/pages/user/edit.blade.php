@extends('layouts.main')
@section('content')
    <div class="use-spinner card" id="user_edit_card">
        <x-spinner.default />
        <div class="card-header">
            <h3 class="card-title">
                Düzenle Ekle
            </h3>
        </div>
        <div class=" card-body pt-3.5 pb-3.5">
            @include("pages.user.partials.form", ["id" => "user_edit_form", "user" => $_pageData["user"]])
        </div>
        <div class="card-footer flex justify-end gap-4">
            <a class="btn btn-sm btn-clear btn-danger" href="{{ route('user.index') }}">
                İptal
            </a>
            <button class="btn btn-sm btn-primary" data-kt-user-edit-submit-button="true">
                Kaydet
            </button>
        </div>
    </div>
@endsection
@section('customJs')
    @vite('resources/js/pages/user/edit.js')
@endsection
