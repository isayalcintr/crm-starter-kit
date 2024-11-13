@php
    $id = $id ?? unique_code();
@endphp
<form class="" id="{{ $id }}">
    @csrf
    <div class="flex gap-2.5">
        <div class="flex-1 flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
            <x-form.label.default>
                Adı / Soyadı
            </x-form.label.default>
            <div class="w-full">
                <x-form.input.default placeholder="Ad..." name="name" type="text" value="{{isset($user) ? $user->name : ''}}"/>
            </div>
            <div class="w-full">
                <x-form.input.default placeholder="Soyadı..." name="surname" type="text" value="{{isset($user) ? $user->surname : ''}}"/>
            </div>
        </div>
        <div class="flex-1 flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
            <x-form.label.default>
                e-Posta
            </x-form.label.default>
            <div class="w-full">
                <x-form.input.default placeholder="e-Posta..." name="email" type="email" value="{{isset($user) ? $user->email : ''}}"/>
            </div>
        </div>
    </div>
    <x-separator.default />
    <div class="flex gap-2.5">
        <div class="flex-1 flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
            <x-form.label.default>
                Durum / Erişim Yetkisi
            </x-form.label.default>
            <div class="min-w-20">
                <x-form.select.default name="status">
                    <option value="1" {{ (isset($user)) && $user->status ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ (isset($user)) && !$user->status ? 'selected' : '' }}>Pasif</option>
                </x-form.select.default>
            </div>
            <div class="w-full">
                <x-form.select.default name="role_id">
                    @foreach($_pageData["roleList"] as $roleItem)
                        <option value="{{ $roleItem->id }}" {{ (isset($user)) && $roleItem->id == $user->role_id ? 'selected' : '' }}>{{ $roleItem->text }}</option>
                    @endforeach
                </x-form.select.default>
            </div>
        </div>
        <div class="flex-1 flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
            <x-form.label.default>
                Şifre
            </x-form.label.default>
            <div class="flex flex-col w-full">
                <div class="input input-sm w-full" data-toggle-password="true">
                    <input  name="password" placeholder="Şifre..." type="password" value=""  data-error-target=".password-error-message-content"/>
                    <button class="btn btn-icon" data-toggle-password-trigger="true" type="button">
                        <i class="ki-filled ki-eye text-gray-500 toggle-password-active:hidden">
                        </i>
                        <i class="ki-filled ki-eye-slash text-gray-500 hidden toggle-password-active:block">
                        </i>
                    </button>
                </div>
                <div class="password-error-message-content"></div>
            </div>
        </div>
    </div>
</form>
