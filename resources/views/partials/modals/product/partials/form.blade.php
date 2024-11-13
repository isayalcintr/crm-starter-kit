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
                                      value="{{isset($product) ? $product->code : ''}}"/>
            </div>
        </div>
        <div class="flex flex-col items-baseline flex-wrap lg:flex-nowrap gap-2.5 w-full">
            <x-form.label.default>
                Adı
            </x-form.label.default>
            <div class="w-full">
                <x-form.input.default placeholder="Adı..." name="name" type="text"
                                      value="{{isset($product) ? $product->name : ''}}"/>
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
                    @foreach(\App\Enums\Product\TypeEnum::cases() as $typeEnum)
                        <option value="{{$typeEnum->value}}" {{ (isset($product) && $product->type == $typeEnum->value ? 'selected' : '') }}>{{ \App\Enums\Product\TypeEnum::getLabel($typeEnum->value) }}</option>
                    @endforeach
                </x-form.select.default>
            </div>
        </div>
        <div class="flex flex-col items-baseline flex-wrap lg:flex-nowrap gap-2.5 flex-1">
            <x-form.label.default>
                Birim
            </x-form.label.default>
            <div class="w-full">
                <x-form.select.default name="unit_id" value="">
                    @foreach($_data["Units"] as $unitItem)
                        <option value="{{ $unitItem->id }}" {{ (isset($product) && $product->unit_id == $unitItem->id ? 'selected' : '') }}>{{ $unitItem->name }}</option>
                    @endforeach
                </x-form.select.default>
            </div>
        </div>
        <div class="flex flex-col items-baseline flex-wrap lg:flex-nowrap gap-2.5 flex-1">
            <x-form.label.default>
                Mevcut
            </x-form.label.default>
            <div class="w-full">
                <x-form.input.default placeholder="Mevcut..." name="quantity" type="number"
                                      value="{{isset($product) ? $product->quantity : ''}}"/>
            </div>
        </div>
    </div>
    <x-separator.default/>
    <div class="flex gap-2.5">
        <div class="flex flex-col items-baseline flex-wrap lg:flex-nowrap gap-2.5">
            <x-form.label.default>
                Alış KDV(%)
            </x-form.label.default>
            <div class="w-full">
                <x-form.input.default placeholder="Alış KDV(%)..." name="purchase_vat_rate" type="text"
                                      value="{{isset($product) ? $product->purchase_vat_rate : ''}}"/>
            </div>
        </div>
        <div class="flex flex-col items-baseline flex-wrap lg:flex-nowrap gap-2.5 w-full">
            <x-form.label.default>
                Alış Fiyat(TL)
            </x-form.label.default>
            <div class="w-full">
                <x-form.input.default placeholder="Alış Fiyat(TL) Kdv hariç!..." name="purchase_price" type="text"
                                      value="{{isset($product) ? $product->purchase_price : ''}}"/>
            </div>
        </div>
    </div>
    <x-separator.default/>
    <div class="flex gap-2.5">
        <div class="flex flex-col items-baseline flex-wrap lg:flex-nowrap gap-2.5">
            <x-form.label.default>
                Satış KDV(%)
            </x-form.label.default>
            <div class="w-full">
                <x-form.input.default placeholder="Satış KDV(%)..." name="sell_vat_rate" type="text"
                                      value="{{isset($product) ? $product->sell_vat_rate : ''}}"/>
            </div>
        </div>
        <div class="flex flex-col items-baseline flex-wrap lg:flex-nowrap gap-2.5 w-full">
            <x-form.label.default>
                Satış Fiyat(TL)
            </x-form.label.default>
            <div class="w-full">
                <x-form.input.default placeholder="Satış Fiyat(TL) Kdv hariç!..." name="sell_price" type="text"
                                      value="{{isset($product) ? $product->sell_price : ''}}"/>
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
                    data-kt-section="{{ \App\Enums\Group\SectionEnum::PRODUCT->value }}"
                    data-kt-type="{{ \App\Enums\Group\TypeEnum::PRODUCT_SG1->value }}"
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
                                          data-kt-section="{{ \App\Enums\Group\SectionEnum::PRODUCT->value }}"
                                          data-kt-type="{{ \App\Enums\Group\TypeEnum::PRODUCT_SG2->value }}">
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
                                          data-kt-section="{{ \App\Enums\Group\SectionEnum::PRODUCT->value }}"
                                          data-kt-type="{{ \App\Enums\Group\TypeEnum::PRODUCT_SG3->value }}">
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
                                          data-kt-section="{{ \App\Enums\Group\SectionEnum::PRODUCT->value }}"
                                          data-kt-type="{{ \App\Enums\Group\TypeEnum::PRODUCT_SG4->value }}">
                </x-form.select.choices-select>
            </div>
        </div>
    </div>
</form>
