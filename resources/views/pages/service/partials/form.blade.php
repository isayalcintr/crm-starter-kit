@php
    $id = $id ?? unique_code();
@endphp
<form class="use-spinner" id="{{ $id }}">
    <x-spinner.default/>
    <div class="flex flex-col -md:flex-row items-start gap-2.5 mb-2">
        <div class="card w-full -md:max-w-[500px]">
            <div class="card-header">
                <h3 class="card-title">
                    Genel
                </h3>
            </div>
            <div class="card-body flex flex-col sm:flex-row gap-2.5 pt-3.5 pb-3.5">
                <div class="flex-1">
                    <div class="flex-1 flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                        <x-form.label.default class="w-1/3">
                            Müşteri
                        </x-form.label.default>
                        <div class="w-full">
                            <x-form.select.choices-select name="customer_id"
                                                          data-kt-value="{{ isset($service) ? $service->customer_id : '' }}"
                                                          data-kt-customer-select="true"
                                                          data-kt-key="{{ unique_code() }}">
                            </x-form.select.choices-select>
                        </div>
                    </div>
                    <x-separator.default/>
                    <div class="flex-1 flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                        <x-form.label.default class="w-1/3">
                            Açıklama
                        </x-form.label.default>
                        <div class="w-full">
                            <x-form.textarea.default name="description" rows="5"></x-form.textarea.default>
                        </div>
                    </div>
                    <x-separator.default/>
                    <div class="flex-1 flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                        <x-form.label.default class="w-1/3">
                            Baş. / Bit.
                        </x-form.label.default>
                        <div class="w-full flex gap-2.5">
                            <x-form.input.default class="flex-1" placeholder="Başlanğıç..." name="start_date" type="datetime-local" value="{{ date('Y-m-d H:i') }}"/>
                            <x-form.input.default class="flex-1" placeholder="Bitiş..." name="end_date" type="datetime-local" value="{{ date('Y-m-d H:i', strtotime('+1 hours')) }}"/>
                        </div>
                    </div>
                </div>
                <div class="flex-1">
                    <x-separator.default class="block sm:hidden"/>
                    <div class="flex-1 flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                        <x-form.label.default class="w-1/3">
                            Grup 1
                        </x-form.label.default>
                        <div class="w-full">
                            <x-form.select.choices-select name="special_group1_id" value=""
                                                          data-kt-group-select="true"
                                                          data-kt-key="{{ unique_code() }}"
                                                          data-kt-value="{{ isset($service) ? $service->special_group1_id : '' }}"
                                                          data-kt-section="{{ \App\Enums\Group\SectionEnum::SERVICE->value }}"
                                                          data-kt-type="{{ \App\Enums\Group\TypeEnum::SERVICE_SG1->value }}"
                            >
                            </x-form.select.choices-select>
                        </div>
                    </div>
                    <x-separator.default/>
                    <div class="flex-1 flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                        <x-form.label.default class="w-1/3">
                            Grup 2
                        </x-form.label.default>
                        <div class="w-full">
                            <x-form.select.choices-select name="special_group2_id" value=""
                                                          data-kt-group-select="true"
                                                          data-kt-value="{{ isset($service) ? $service->special_group2_id : '' }}"
                                                          data-kt-key="{{ unique_code() }}"
                                                          data-kt-section="{{ \App\Enums\Group\SectionEnum::SERVICE->value }}"
                                                          data-kt-type="{{ \App\Enums\Group\TypeEnum::SERVICE_SG1->value }}"
                            >
                            </x-form.select.choices-select>
                        </div>
                    </div>
                    <x-separator.default/>
                    <div class="flex-1 flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                        <x-form.label.default class="w-1/3">
                            Grup 3
                        </x-form.label.default>
                        <div class="w-full">
                            <x-form.select.choices-select name="special_group3_id" value=""
                                                          data-kt-group-select="true"
                                                          data-kt-value="{{ isset($service) ? $service->special_group3_id : '' }}"
                                                          data-kt-key="{{ unique_code() }}"
                                                          data-kt-section="{{ \App\Enums\Group\SectionEnum::SERVICE->value }}"
                                                          data-kt-type="{{ \App\Enums\Group\TypeEnum::SERVICE_SG1->value }}"
                            >
                            </x-form.select.choices-select>
                        </div>
                    </div>
                    <x-separator.default/>
                    <div class="flex-1 flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                        <x-form.label.default class="w-1/3">
                            Grup 4
                        </x-form.label.default>
                        <div class="w-full">
                            <x-form.select.choices-select name="special_group4_id" value=""
                                                          data-kt-group-select="true"
                                                          data-kt-value="{{ isset($service) ? $service->special_group4_id : '' }}"
                                                          data-kt-key="{{ unique_code() }}"
                                                          data-kt-section="{{ \App\Enums\Group\SectionEnum::SERVICE->value }}"
                                                          data-kt-type="{{ \App\Enums\Group\TypeEnum::SERVICE_SG1->value }}"
                            >
                            </x-form.select.choices-select>
                        </div>
                    </div>
                    <x-separator.default/>
                    <div class="flex-1 flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                        <x-form.label.default class="w-1/3">
                            Durum
                        </x-form.label.default>
                        <div class="w-full">
                            <x-form.select.default name="status" value="">
                                @foreach(\App\Enums\Service\StatusEnum::cases() as $typeEnum)
                                    <option
                                        value="{{$typeEnum->value}}" {{ $typeEnum->value === \App\Enums\Service\StatusEnum::COMPLETED->value ? 'selected' : '' }}>{{ \App\Enums\Service\StatusEnum::getLabel($typeEnum->value) }}</option>
                                @endforeach
                            </x-form.select.default>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex-1 w-full">
            <div class="grid gap-5 lg:gap-7.5">
                <div class="card card-grid min-w-full">
                    <div class="card-header flex-wrap gap-2">
                        <div class="flex flex-col justify-center gap-2">
                            <h1 class="text-xl font-medium leading-none text-gray-900">
                                Hizmetler / Ürünler
                            </h1>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="">
                            <table id="user_table" class="w-full dataTable table table-auto table-border align-middle text-gray-700 font-medium text-sm">
                                <thead>
                                <tr>
                                    <th class="min-w-[100px]">S.N</th>
                                    <th class="min-w-[100px]">Tip</th>
                                    <th class="w-full min-w-[250px]">Hizmet / Ürün</th>
                                    <th class="min-w-[100px]">Miktar</th>
                                    <th class="min-w-[125px]">Birim</th>
                                    <th class="min-w-[150px]">Fiyat</th>
                                    <th class="min-w-[100px]">K.D.V(%)</th>
                                    <th class="min-w-[175px] text-end">Ara Top.</th>
                                    <th class="min-w-[175px] text-end">K.D.V Top.</th>
                                    <th class="min-w-[175px] text-end">Genel Top.</th>
                                    <th class="w-[65px] max-w-[65px] min-w-[65px]"></th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th class="min-w-[100px]">S.N</th>
                                    <th class="min-w-[100px]">Tip</th>
                                    <th class="w-full min-w-[250px]">Hizmet / Ürün</th>
                                    <th class="min-w-[100px]">Miktar</th>
                                    <th class="min-w-[125px]">Birim</th>
                                    <th class="min-w-[150px]">Fiyat</th>
                                    <th class="min-w-[100px]">K.D.V(%)</th>
                                    <th class="min-w-[175px] text-end">Ara Top.</th>
                                    <th class="min-w-[175px] text-end">K.D.V Top.</th>
                                    <th class="min-w-[175px] text-end">Genel Top.</th>
                                    <th class="w-[65px] max-w-[65px] min-w-[65px]"></th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="flex gap-2.5 mx-4 my-2">
                            <div class="flex-1 flex items-baseline  gap-2.5">
                                <x-form.label.default class="w-1/3">
                                    Ürün
                                </x-form.label.default>
                                <div class="w-full">
                                    <x-form.select.choices-select name="product">
                                    </x-form.select.choices-select>
                                </div>
                            </div>
                            <div class="md:flex-1">
                                <a href="javascript:void(0);" class="btn btn-sm btn-outline btn-info" data-kt-service-add-product-button="true">
                                    Ekle
                                    <i class="ki-outline ki-plus-squared">
                                    </i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-2.5 flex w-full justify-end">
                <div class="card w-full md:max-w-96 md:w-96">
                    <div class="card-header">
                        <h3 class="card-title">
                            Toplam
                        </h3>
                    </div>
                    <div class="card-body pt-3.5 pb-3.5">
                        <div class="flex-1 flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                            <x-form.label.default>
                                Hizmet Toplam
                            </x-form.label.default>
                            <div class="w-full text-end">
                                <span class="font-bold text-gray-900" data-kt-service-total="service_total">₺0,00</span>
                            </div>
                        </div>
                        <x-separator.default/>
                        <div class="flex-1 flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                            <x-form.label.default>
                                Stok Toplam
                            </x-form.label.default>
                            <div class="w-full text-end">
                                <span class="font-bold text-gray-900" data-kt-service-total="stock_total">₺0,00</span>
                            </div>
                        </div>
                        <x-separator.default/>
                        <div class="flex-1 flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                            <x-form.label.default>
                                Ara Toplam
                            </x-form.label.default>
                            <div class="w-full text-end">
                                <span class="font-bold text-gray-900" data-kt-service-total="sub_total">₺0,00</span>
                            </div>
                        </div>
                        <x-separator.default/>
                        <div class="flex-1 flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                            <x-form.label.default>
                                Kdv Toplam
                            </x-form.label.default>
                            <div class="w-full text-end">
                                <span class="font-bold text-gray-900" data-kt-service-total="vat_total">₺0,00</span>
                            </div>
                        </div>
                        <x-separator.default/>
                        <div class="flex-1 flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                            <x-form.label.default>
                                Genel Toplam
                            </x-form.label.default>
                            <div class="w-full text-end">
                                <span class="font-bold text-gray-900" data-kt-service-total="total">₺0,00</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

