@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-[#ded7cd] bg-white text-[#171615] focus:border-[#b58d56] focus:ring-[#b58d56]/50 rounded-xl shadow-sm text-sm font-semibold transition-colors duration-200']) }}>
