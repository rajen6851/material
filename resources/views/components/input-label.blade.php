@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-bold text-xs uppercase tracking-wider text-[#736c63] mb-1']) }}>
    {{ $value ?? $slot }}
</label>
