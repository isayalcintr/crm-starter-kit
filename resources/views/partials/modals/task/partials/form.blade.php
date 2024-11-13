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
    <div class="flex gap-2 5">
        <div class="flex flex-col items-baseline flex-wrap lg:flex-nowrap gap-2.5 flex-1">
            <x-form.label.default>
                Konu
            </x-form.label.default>
            <div class="w-full">
                <x-form.input.default placeholder="Konu..." name="subject" type="text" value=""/>
            </div>
        </div>
        <div class="flex flex-col items-baseline flex-wrap lg:flex-nowrap gap-2.5 flex-1">
            <x-form.label.default>
                Kullanıcı
            </x-form.label.default>
            <div class="w-full">
                <x-form.select.default name="incumbent_by" value="">
                    @foreach($_data["Users"] as $item)
                        <option value="{{$item->id}}" {{ $item->id === \Illuminate\Support\Facades\Auth::id() ? 'selected' : '' }}>{{ $item->text }}</option>
                    @endforeach
                </x-form.select.default>
            </div>
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
                Başlanğıç
            </x-form.label.default>
            <div class="w-full">
                <x-form.input.default placeholder="Başlanğıç..." name="start_date" type="date" />
            </div>
        </div>
        <div class="flex flex-col items-baseline flex-wrap lg:flex-nowrap gap-2.5 flex-1">
            <x-form.label.default>
                Bitiş
            </x-form.label.default>
            <div class="w-full">
                <x-form.input.default placeholder="Bitiş..." name="end_date" type="date" :value="date('Y-m-d', strtotime('+1days'))"/>
            </div>
        </div>
    </div>
    <x-separator.default/>
    <div class="flex gap-2.5">
        <div class="flex flex-col items-baseline flex-wrap lg:flex-nowrap gap-2.5 flex-1">
            <x-form.label.default>
                Öncelik
            </x-form.label.default>
            <div class="w-full">
                <x-form.select.default name="priority" value="">
                    @foreach(\App\Enums\Task\PriorityEnum::cases() as $typeEnum)
                        <option value="{{$typeEnum->value}}" {{ $typeEnum->value === \App\Enums\Task\PriorityEnum::NORMAL->value ? 'selected' : '' }}>{{ \App\Enums\Task\PriorityEnum::getLabel($typeEnum->value) }}</option>
                    @endforeach
                </x-form.select.default>
            </div>
        </div>
        <div class="flex flex-col items-baseline flex-wrap lg:flex-nowrap gap-2.5 flex-1">
            <x-form.label.default>
                Durum
            </x-form.label.default>
            <div class="w-full">
                <x-form.select.default name="status" value="">
                    @foreach(\App\Enums\Task\StatusEnum::cases() as $typeEnum)
                        <option value="{{$typeEnum->value}}" {{ $typeEnum->value === \App\Enums\Task\StatusEnum::PROCESSING->value ? 'selected' : '' }}>{{ \App\Enums\Task\StatusEnum::getLabel($typeEnum->value) }}</option>
                    @endforeach
                </x-form.select.default>
            </div>
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
                                              data-kt-section="{{ \App\Enums\Group\SectionEnum::TASK->value }}"
                                              data-kt-type="{{ \App\Enums\Group\TypeEnum::TASK_CATEGORY->value }}"
                >
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
                                              data-kt-section="{{ \App\Enums\Group\SectionEnum::TASK->value }}"
                                              data-kt-type="{{ \App\Enums\Group\TypeEnum::TASK_SG1->value }}"
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
                                              data-kt-section="{{ \App\Enums\Group\SectionEnum::TASK->value }}"
                                              data-kt-type="{{ \App\Enums\Group\TypeEnum::TASK_SG2->value }}">
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
                                              data-kt-section="{{ \App\Enums\Group\SectionEnum::TASK->value }}"
                                              data-kt-type="{{ \App\Enums\Group\TypeEnum::TASK_SG3->value }}">
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
                                              data-kt-section="{{ \App\Enums\Group\SectionEnum::TASK->value }}"
                                              data-kt-type="{{ \App\Enums\Group\TypeEnum::TASK_SG4->value }}">
                </x-form.select.choices-select>
            </div>
        </div>
    </div>
</form>
