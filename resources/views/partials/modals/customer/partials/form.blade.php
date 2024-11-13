@php
    $id = $id ?? unique_code();
@endphp
<form class="" id="{{ $id }}">
    <div class="flex gap-2.5">
        <div class="flex flex-col items-baseline flex-wrap lg:flex-nowrap gap-2.5">
            <x-form.label.default>
                Kodu
            </x-form.label.default>
            <div class="w-full">
                <x-form.input.default placeholder="Kod..." name="code" type="text"
                                      value="{{isset($customer) ? $customer->code : ''}}"/>
            </div>
        </div>
        <div class="flex flex-col items-baseline flex-wrap lg:flex-nowrap gap-2.5 w-full">
            <x-form.label.default>
                Adı Soyadı / Unvanı
            </x-form.label.default>
            <div class="w-full">
                <x-form.input.default placeholder="Adı Soyadı / Unvanı..." name="title" type="text"
                                      value="{{isset($customer) ? $customer->title : ''}}"/>
            </div>
        </div>
    </div>
    <x-separator.default/>
    <div class="flex gap-2.5">
        <div class="flex flex-col items-baseline flex-wrap lg:flex-nowrap gap-2.5 flex-1">
            <x-form.label.default>
                Tip
            </x-form.label.default>
            <div class="w-full">
                <x-form.select.default name="type" value="">
                    @foreach(\App\Enums\Customer\TypeEnum::cases() as $typeEnum)
                        <option value="{{$typeEnum->value}}" {{ (isset($customer) && $customer->type == $typeEnum->value ? 'selected' : '') }}>{{ \App\Enums\Customer\TypeEnum::getLabel($typeEnum->value) }}</option>
                    @endforeach
                </x-form.select.default>
            </div>
        </div>
        <div class="flex flex-col items-baseline flex-wrap lg:flex-nowrap gap-2.5 flex-1">
            <x-form.label.default>
                Vergi No
            </x-form.label.default>
            <div class="w-full">
                <x-form.input.default placeholder="Vergi No..." name="tax_number" type="text"
                                      value="{{isset($customer) ? $customer->title : ''}}"/>
            </div>
        </div>
        <div class="flex flex-col items-baseline flex-wrap lg:flex-nowrap gap-2.5 flex-1">
            <x-form.label.default>
                Vergi Daire
            </x-form.label.default>
            <div class="w-full">
                <x-form.input.default placeholder="Vergi Daire..." name="tax_office" type="text"
                                      value="{{isset($customer) ? $customer->title : ''}}"/>
            </div>
        </div>
    </div>
    <x-separator.default/>
    <div class="flex gap-2.5">
        <div class="flex flex-col items-baseline flex-wrap lg:flex-nowrap gap-2.5 flex-1">
            <x-form.label.default>
                e-Posta
            </x-form.label.default>
            <div class="w-full">
                <x-form.input.default placeholder="e-Posta..." name="email" type="text"
                                      value="{{isset($customer) ? $customer->email : ''}}"/>
            </div>
        </div>
        <div class="flex flex-col items-baseline flex-wrap lg:flex-nowrap gap-2.5 flex-1">
            <x-form.label.default>
                Telefon 1
            </x-form.label.default>
            <div class="w-full">
                <x-form.input.default placeholder="Telefon 1..." name="phone1" type="text"
                                      value="{{isset($customer) ? $customer->phone1 : ''}}"/>
            </div>
        </div>
        <div class="flex flex-col items-baseline flex-wrap lg:flex-nowrap gap-2.5 flex-1">
            <x-form.label.default>
                Telefon 2
            </x-form.label.default>
            <div class="w-full">
                <x-form.input.default placeholder="Telefon 2..." name="phone2" type="text"
                                      value="{{isset($customer) ? $customer->phone2 : ''}}"/>
            </div>
        </div>
    </div>
    <x-separator.default/>
    <div class="flex gap-2.5">
        <div class="flex flex-col items-baseline flex-wrap lg:flex-nowrap gap-2.5 flex-1">
            <x-form.label.default>
                İl
            </x-form.label.default>
            <div class="w-full">
                <x-form.select.default name="city" value="" data-kt-city-select="true" id="{{ $id . '-city-selector' }}">
                </x-form.select.default>
            </div>
        </div>
        <div class="flex flex-col items-baseline flex-wrap lg:flex-nowrap gap-2.5 flex-1">
            <x-form.label.default>
                İlçe
            </x-form.label.default>
            <div class="w-full">
                <x-form.select.default name="district" value="" data-kt-district-select="true" data-kt-city-select-selector="{{ '#' . $id . '-city-selector'}}">
                </x-form.select.default>
            </div>
        </div>
    </div>
    <x-separator.default/>
    <div class="flex gap-2.5">
        <div class="flex flex-col items-baseline flex-wrap lg:flex-nowrap gap-2.5 flex-1">
            <x-form.label.default>
                Adres 1
            </x-form.label.default>
            <div class="w-full">
                <x-form.textarea.default name="address1"></x-form.textarea.default>
            </div>
        </div>
        <div class="flex flex-col items-baseline flex-wrap lg:flex-nowrap gap-2.5 flex-1">
            <x-form.label.default>
                Adres 2
            </x-form.label.default>
            <div class="w-full">
                <x-form.textarea.default name="address2"></x-form.textarea.default>
            </div>
        </div>
    </div>
    <x-separator.default/>
    <div class="flex gap-2.5">
        <div class="flex flex-col items-baseline flex-wrap lg:flex-nowrap gap-2.5 flex-1">
            <x-form.label.default>
                Grup 1
            </x-form.label.default>
            <div class="w-full">
                <x-form.select.choices-select name="special_group1_id" value=""
                                              data-kt-group-select="true"
                                              data-kt-key="{{ unique_code() }}"
                                              data-kt-section="{{ \App\Enums\Group\SectionEnum::CUSTOMER->value }}"
                                              data-kt-type="{{ \App\Enums\Group\TypeEnum::CUSTOMER_SG1->value }}"
                >
                </x-form.select.choices-select>
            </div>
        </div>
        <div class="flex flex-col items-baseline flex-wrap lg:flex-nowrap gap-2.5 flex-1">
            <x-form.label.default>
                Grup 2
            </x-form.label.default>
            <div class="w-full">
                <x-form.select.choices-select name="special_group2_id" value=""
                                              data-kt-group-select="true"
                                              data-kt-key="{{ unique_code() }}"
                                              data-kt-section="{{ \App\Enums\Group\SectionEnum::CUSTOMER->value }}"
                                              data-kt-type="{{ \App\Enums\Group\TypeEnum::CUSTOMER_SG2->value }}">
                </x-form.select.choices-select>
            </div>
        </div>
    </div>
    <x-separator.default/>
    <div class="flex gap-2.5">
        <div class="flex flex-col items-baseline flex-wrap lg:flex-nowrap gap-2.5 flex-1">
            <x-form.label.default>
                Grup 3
            </x-form.label.default>
            <div class="w-full">
                <x-form.select.choices-select name="special_group3_id" value=""
                                              data-kt-group-select="true"
                                              data-kt-key="{{ unique_code() }}"
                                              data-kt-section="{{ \App\Enums\Group\SectionEnum::CUSTOMER->value }}"
                                              data-kt-type="{{ \App\Enums\Group\TypeEnum::CUSTOMER_SG3->value }}">
                </x-form.select.choices-select>
            </div>
        </div>
        <div class="flex flex-col items-baseline flex-wrap lg:flex-nowrap gap-2.5 flex-1">
            <x-form.label.default>
                Grup 4
            </x-form.label.default>
            <div class="w-full">
                <x-form.select.choices-select name="special_group4_id" value=""
                                              data-kt-group-select="true"
                                              data-kt-key="{{ unique_code() }}"
                                              data-kt-section="{{ \App\Enums\Group\SectionEnum::CUSTOMER->value }}"
                                              data-kt-type="{{ \App\Enums\Group\TypeEnum::CUSTOMER_SG4->value }}">
                </x-form.select.choices-select>
            </div>
        </div>
    </div>
</form>
