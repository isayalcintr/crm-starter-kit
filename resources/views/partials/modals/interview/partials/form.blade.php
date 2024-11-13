@php
    $id = $id ?? unique_code();
@endphp
<form class="" id="{{ $id }}">
    <div class="flex flex-col items-baseline flex-wrap lg:flex-nowrap gap-2.5">
        <x-form.label.default>
            Müşteri
        </x-form.label.default>
        <div class="w-full" >
            <x-form.select.choices-select  name="customer_id"
                                          data-kt-customer-select="true"
                                          data-kt-key="{{ unique_code() }}">
            </x-form.select.choices-select>
        </div>
    </div>
    <x-separator.default/>
    <div class="flex flex-col items-baseline flex-wrap lg:flex-nowrap gap-2.5">
        <x-form.label.default>
            Konu
        </x-form.label.default>
        <div class="w-full">
            <x-form.input.default placeholder="Konu..." name="subject" type="text" value=""/>
        </div>
    </div>
    <x-separator.default/>
    <div class="flex flex-col items-baseline flex-wrap lg:flex-nowrap gap-2.5">
        <x-form.label.default>
            Açıklama
        </x-form.label.default>
        <div class="w-full">
            <x-form.textarea.default name="description"></x-form.textarea.default>
        </div>
    </div>
    <x-separator.default/>
    <div class="flex gap-2.5">
        <div class="flex flex-col items-baseline flex-wrap lg:flex-nowrap gap-2.5 flex-1">
            <x-form.label.default>
                Kategori
            </x-form.label.default>
            <div class="w-full">
                <x-form.select.choices-select name="category_id" value=""
                                              data-kt-group-select="true"
                                              data-kt-key="{{ unique_code() }}"
                                              data-kt-section="{{ \App\Enums\Group\SectionEnum::INTERVIEW->value }}"
                                              data-kt-type="{{ \App\Enums\Group\TypeEnum::INTERVIEW_CATEGORY->value }}"
                >
                </x-form.select.choices-select>
            </div>
        </div>
        <div class="flex flex-col items-baseline flex-wrap lg:flex-nowrap gap-2.5 flex-1">
            <x-form.label.default>
                Tip
            </x-form.label.default>
            <div class="w-full">
                <x-form.select.choices-select name="type_id" value=""
                                              data-kt-group-select="true"
                                              data-kt-key="{{ unique_code() }}"
                                              data-kt-section="{{ \App\Enums\Group\SectionEnum::INTERVIEW->value }}"
                                              data-kt-type="{{ \App\Enums\Group\TypeEnum::INTERVIEW_TYPE->value }}">
                </x-form.select.choices-select>
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
                                              data-kt-section="{{ \App\Enums\Group\SectionEnum::INTERVIEW->value }}"
                                              data-kt-type="{{ \App\Enums\Group\TypeEnum::INTERVIEW_SG1->value }}"
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
                                              data-kt-section="{{ \App\Enums\Group\SectionEnum::INTERVIEW->value }}"
                                              data-kt-type="{{ \App\Enums\Group\TypeEnum::INTERVIEW_SG2->value }}">
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
                                              data-kt-section="{{ \App\Enums\Group\SectionEnum::INTERVIEW->value }}"
                                              data-kt-type="{{ \App\Enums\Group\TypeEnum::INTERVIEW_SG3->value }}">
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
                                              data-kt-section="{{ \App\Enums\Group\SectionEnum::INTERVIEW->value }}"
                                              data-kt-type="{{ \App\Enums\Group\TypeEnum::INTERVIEW_SG4->value }}">
                </x-form.select.choices-select>
            </div>
        </div>
    </div>
</form>
