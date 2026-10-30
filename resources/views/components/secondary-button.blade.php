<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-6 py-3 bg-white border border-[#ded7cd] rounded-xl font-bold text-xs text-[#171615] uppercase tracking-widest shadow-sm hover:bg-[#eae3d8] focus:outline-none focus:ring-2 focus:ring-[#b58d56] focus:ring-offset-2 disabled:opacity-25 transition-all duration-300']) }}>
    {{ $slot }}
</button>
