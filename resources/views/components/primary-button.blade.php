<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-6 py-3 bg-[#171615] border border-transparent rounded-xl font-bold text-xs text-white uppercase tracking-widest hover:bg-[#b58d56] focus:bg-[#b58d56] active:bg-[#b58d56] focus:outline-none focus:ring-2 focus:ring-[#b58d56]/50 focus:ring-offset-2 transition-all duration-300 shadow-sm']) }}>
    {{ $slot }}
</button>
