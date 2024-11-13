<select {{ $attributes->merge(['class' => 'choice-select']) }} placeholder="Seçiniz...">
    {{ $slot }}
</select>
