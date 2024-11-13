@php
    $id = $id ?? unique_code();
@endphp
<form class="" id="{{ $id }}">
    @csrf
    <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
        <x-form.label.default>
            Adı
        </x-form.label.default>
        <div class="w-full">
            <x-form.input.default placeholder="Başlık..." name="name" type="text" value="{{isset($role) ? $role->name : ''}}"/>
        </div>
    </div>
    <x-separator.default />
    <div class="flex flex-1">
        <x-form.label.default>
            Grup
        </x-form.label.default>
        <div class="flex gap-2 px-3">
            @foreach (['group-list' => 'Listele', 'group-create' => 'Ekle', 'group-edit' => 'Düzenle', 'group-destroy' => 'Sil'] as $value => $label)
                <x-form.label.checkbox-group>
                    <x-form.checkbox.default name="permissions[]" value="{{ $value }}" :checked="isset($role) && $role->hasPermissionTo($value)" />
                    <span class="checkbox-label">
                        {{ $label }}
                    </span>
                </x-form.label.checkbox-group>
            @endforeach
        </div>
    </div>
</form>
