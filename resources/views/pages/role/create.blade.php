@extends('layouts.main')
@section('content')
    <div class="use-spinner card" id="role_create_card">
        <x-spinner.default />
        <div class="card-header">
            <h3 class="card-title">
                Yeni Ekle
            </h3>
        </div>
        <div class=" card-body pt-3.5 pb-3.5">
            @include("pages.role.partials.form", ["id" => "role_create_form"])
        </div>
        <div class="card-footer flex justify-end gap-4">
            <a class="btn btn-sm btn-clear btn-danger" href="{{ route('role.index') }}">
                İptal
            </a>
            <button class="btn btn-sm btn-primary" data-kt-role-create-submit-button="true">
                Kaydet
            </button>
        </div>
    </div>
@endsection
@section('customJs')
    @vite('resources/js/pages/role/create.js')
@endsection
