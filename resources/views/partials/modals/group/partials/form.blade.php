@php
    $id = $id ?? unique_code();
@endphp
<form class="" id="{{ $id }}">
    @csrf
    <div class="flex gap-2.5">
        <div class="flex flex-col items-baseline flex-wrap lg:flex-nowrap gap-2.5 flex-1">
            <x-form.label.default>
                Bölüm
            </x-form.label.default>
            <div class="w-full">
                <x-form.select.default name="section" value="">
                    @foreach(\App\Enums\Group\SectionEnum::cases() as $groupSection)
                        <option value="{{$groupSection->value}}" {{ (isset($group)) && $group->section == $groupSection->value ? 'selected' : '' }}>{{ \App\Enums\Group\SectionEnum::getLabel($groupSection->value) }}</option>
                    @endforeach
                </x-form.select.default>
            </div>
        </div>
        <div class="flex flex-col items-baseline flex-wrap lg:flex-nowrap gap-2.5 flex-1">
            <x-form.label.default>
                Tip
            </x-form.label.default>
            <div class="w-full">
                <x-form.select.default name="type">
                </x-form.select.default>
            </div>
        </div>
    </div>
    <x-separator.default/>
    <div class="flex gap-2.5">
        <div class="flex flex-col items-baseline flex-wrap lg:flex-nowrap gap-2.5 w-full">
            <x-form.label.default>
                Başlık
            </x-form.label.default>
            <div class="w-full">
                <x-form.input.default placeholder="Başlık..." name="title" type="text"
                                      value="{{isset($group) ? $group->name : ''}}"/>
            </div>
        </div>
        <div class="flex flex-col items-baseline flex-wrap lg:flex-nowrap gap-2.5">
            <x-form.label.default>
                Sıra
            </x-form.label.default>
            <div class="w-full">
                <x-form.input.default placeholder="Sıra..." name="order" type="text"
                                      value="{{isset($group) ? $group->order : ''}}"/>
            </div>
        </div>
    </div>
</form>
