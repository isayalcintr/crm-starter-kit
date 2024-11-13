@extends('layouts.main')
@section('content')
    <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-7.5">
        <div class="flex flex-col justify-center gap-2">
            <h1 class="text-xl font-medium leading-none text-gray-900">
                Teklifler
            </h1>
        </div>
        <div class="flex items-center gap-2.5">
            <a class="btn btn-sm btn-primary" href="{{ route('offer.create') }}" >
                Yeni Ekle
            </a>
        </div>
    </div>
    <div class="grid gap-5 lg:gap-7.5">
        <div class="card card-grid min-w-full">
            <div class="card-header flex-wrap gap-2">
                <h3 class="card-title font-medium text-sm">
                    Liste
                </h3>
                <div class="flex flex-wrap gap-2 lg:gap-5">
                    <div class="flex">
                        <label class="input input-sm">
                            <i class="ki-filled ki-magnifier">
                            </i>
                            <input placeholder="Ara" type="text" value="" data-kt-offer-table-filter="search"/>
                        </label>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table id="offer_table" class="w-full dataTable table table-auto table-border align-middle text-gray-700 font-medium text-sm" >
                    <thead>
                    <tr>
                        <th class="min-w-[100px]">Kod</th>
                        <th class="min-w-[300px]">Müşteri</th>
                        <th class="min-w-[185px]">Kullanıcı</th>
                        <th class="min-w-[150px] text-end">Ara Toplam</th>
                        <th class="min-w-[150px] text-end">K.D.V Toplam</th>
                        <th class="min-w-[150px] text-end">Genel Toplam</th>
                        <th class="min-w-[185px]">Tarih</th>
                        <th class="min-w-[185px]">Geç. Tarih</th>
                        <th class="min-w-[185px]">Grup 1</th>
                        <th class="min-w-[185px]">Grup 2</th>
                        <th class="min-w-[185px]">Grup 3</th>
                        <th class="min-w-[185px]">Grup 4</th>
                        <th class="min-w-[185px]">Aşama</th>
                        <th class="min-w-[185px]">Durum</th>
                        <th class="min-w-[185px]">O. Tarih</th>
                        <th class="w-[65px] max-w-[65px] min-w-[65px]"></th>
                        <th class="w-[65px] max-w-[65px] min-w-[65px]"></th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th class="min-w-[100px]">Kod</th>
                        <th class="min-w-[300px]">Müşteri</th>
                        <th class="min-w-[185px]">Kullanıcı</th>
                        <th class="min-w-[150px] text-end">Ara Toplam</th>
                        <th class="min-w-[150px] text-end">K.D.V Toplam</th>
                        <th class="min-w-[150px] text-end">Genel Toplam</th>
                        <th class="min-w-[185px]">Tarih</th>
                        <th class="min-w-[185px]">Geç. Tarih</th>
                        <th class="min-w-[185px]">Grup 1</th>
                        <th class="min-w-[185px]">Grup 2</th>
                        <th class="min-w-[185px]">Grup 3</th>
                        <th class="min-w-[185px]">Grup 4</th>
                        <th class="min-w-[185px]">Aşama</th>
                        <th class="min-w-[185px]">Durum</th>
                        <th class="min-w-[185px]">O. Tarih</th>
                        <th class="w-[65px] max-w-[65px] min-w-[65px]"></th>
                        <th class="w-[65px] max-w-[65px] min-w-[65px]"></th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('customJs')
    @vite('resources/js/pages/offer/index.js')
@endsection
