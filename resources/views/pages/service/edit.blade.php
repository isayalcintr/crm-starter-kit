@extends('layouts.main')
@section('content')
    <div class="use-spinner card" id="service_edit_card">
        <x-spinner.default />
        <div class="card-header">
            <h3 class="card-title">
                Düzenle
            </h3>
        </div>
        <div class=" card-body pt-3.5 pb-3.5">
            @include("pages.service.partials.form", ["id" => "service_edit_form", "service" => $_pageData["service"]])
        </div>
        <div class="card-footer flex justify-end gap-4">
            <a class="btn btn-sm btn-clear btn-danger" href="{{ route('service.index') }}">
                İptal
            </a>
            <button class="btn btn-sm btn-primary" data-kt-service-edit-submit-button="true">
                Kaydet
            </button>
        </div>
    </div>
@endsection
@section('customJs')
    @vite('resources/js/pages/service/edit.js')
@endsection
