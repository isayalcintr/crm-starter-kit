@extends('layouts.main')
@section('content')
    <div class="use-spinner card" id="offer_edit_card">
        <x-spinner.default />
        <div class="card-header">
            <h3 class="card-title">
                Düzenle
            </h3>
        </div>
        <div class=" card-body pt-3.5 pb-3.5">
            @include("pages.offer.partials.form", ["id" => "offer_edit_form", "offer" => $_pageData["offer"]])
        </div>
        <div class="card-footer flex justify-end gap-4">
            <a class="btn btn-sm btn-clear btn-danger" href="{{ route('offer.index') }}">
                İptal
            </a>
            <button class="btn btn-sm btn-primary" data-kt-offer-edit-submit-button="true">
                Kaydet
            </button>
        </div>
    </div>
@endsection
@section('customJs')
    @vite('resources/js/pages/offer/edit.js')
@endsection
