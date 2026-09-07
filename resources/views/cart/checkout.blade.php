<x-app-layout>
    <x-slot name="title">Checkout - MaterialDeck</x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16" x-data="{ addressType: 'saved' }">
        <h1 class="text-3xl font-extrabold text-slate-900 mb-6">Checkout</h1>

        <!-- Bangalore Delivery Note -->
        <div class="bg-teal-50 border border-teal-200 text-teal-800 rounded-2xl p-4 mb-8 flex items-start gap-3 shadow-sm">
            <svg class="w-5 h-5 text-teal-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            <div>
                <p class="text-sm font-bold">We currently deliver only within Bangalore city</p>
                <p class="text-xs text-teal-700 mt-0.5">
                    Please make sure your delivery PIN code is a Bangalore city pincode (e.g. 560001, 560034, 560103).
                    Orders placed with any other pincode cannot be processed.
                </p>
            </div>
        </div>

        <form action="{{ route('checkout.place') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 items-start">
                
                <!-- Left: Shipping & Payment details -->
                <div class="lg:col-span-2 space-y-8">
                    
                    <!-- Address Section -->
                    <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm space-y-6">
                        <div class="flex items-center justify-between border-b pb-4">
                            <h3 class="font-extrabold text-slate-900 text-lg">Shipping Address</h3>
                            @if($addresses->count() > 0)
                                <div class="flex gap-2">
                                    <button type="button" @click="addressType = 'saved'" :class="addressType === 'saved' ? 'bg-teal-600 text-white' : 'bg-slate-100 text-slate-700'" class="text-xs font-bold px-3 py-1.5 rounded-lg transition">Saved Address</button>
                                    <button type="button" @click="addressType = 'new'" :class="addressType === 'new' ? 'bg-teal-600 text-white' : 'bg-slate-100 text-slate-700'" class="text-xs font-bold px-3 py-1.5 rounded-lg transition">New Address</button>
                                </div>
                            @else
                                <span class="text-xs font-semibold text-slate-400">Add shipping details below</span>
                            @endif
                        </div>

                        <!-- Saved Address Grid -->
                        @if($addresses->count() > 0)
                            <div x-show="addressType === 'saved'" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($addresses as $address)
                                    <label class="border rounded-xl p-4 flex gap-3 cursor-pointer hover:border-teal-500 hover:bg-slate-50/50 transition">
                                        <input type="radio" name="address_id" value="{{ $address->id }}" {{ $address->is_default || $loop->first ? 'checked' : '' }} class="mt-1 text-teal-600 focus:ring-teal-500">
                                        <div class="text-xs space-y-1 text-slate-600">
                                            <div class="font-bold text-slate-900 text-sm flex items-center gap-2">
                                                <span>{{ $address->name }}</span>
                                                <span class="bg-slate-100 text-slate-500 text-[10px] px-2 py-0.5 rounded uppercase font-medium">{{ $address->type }}</span>
                                            </div>
                                            <p>{{ $address->address_line_1 }}</p>
                                            @if($address->address_line_2)
                                                <p>{{ $address->address_line_2 }}</p>
                                            @endif
                                            <p>{{ $address->city }}, {{ $address->state }} - {{ $address->postal_code }}</p>
                                            <p class="font-medium text-slate-800">Phone: {{ $address->phone }}</p>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        @endif

                        <!-- New Address Form -->
                        <div x-show="addressType === 'new' || {{ $addresses->count() === 0 ? 'true' : 'false' }}" class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Full Name</label>
                                    <input type="text" name="new_address[name]" value="{{ old('new_address.name', auth()->user()->name) }}" class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Phone Number</label>
                                    <input type="text" name="new_address[phone]" value="{{ old('new_address.phone', auth()->user()->phone) }}" class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Address Line 1</label>
                                <input type="text" name="new_address[address_line_1]" class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Address Line 2 (Optional)</label>
                                <input type="text" name="new_address[address_line_2]" class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                            </div>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                <div class="col-span-2 md:col-span-1">
                                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">City</label>
                                    <input type="text" name="new_address[city]" class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">State</label>
                                    <input type="text" name="new_address[state]" class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Pincode</label>
                                    <input type="text" name="new_address[postal_code]" class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                                    <p class="text-[10px] text-slate-400 mt-1.5">Delivery available only for Bangalore city PIN codes.</p>
                                    <p class="text-[10px] text-red-500 font-semibold mt-1 hidden" data-pincode-error></p>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Address Type</label>
                                    <select name="new_address[type]" class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                                        <option value="home">Home</option>
                                        <option value="office">Office</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method Section -->
                    <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm space-y-4">
                        <h3 class="font-extrabold text-slate-900 text-lg border-b pb-4">Payment Method</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <label class="border rounded-xl p-4 flex items-center gap-3 cursor-pointer hover:border-teal-500 hover:bg-slate-50/50 transition">
                                <input type="radio" name="payment_method" value="cod" checked class="text-teal-600 focus:ring-teal-500">
                                <div>
                                    <div class="font-bold text-slate-800 text-sm">Cash on Delivery (COD)</div>
                                    <div class="text-xs text-slate-500 mt-0.5">Pay in cash or UPI upon home delivery.</div>
                                </div>
                            </label>
                            
                            <label class="border rounded-xl p-4 flex items-center gap-3 cursor-pointer hover:border-teal-500 hover:bg-slate-50/50 transition">
                                <input type="radio" name="payment_method" value="card" class="text-teal-600 focus:ring-teal-500">
                                <div>
                                    <div class="font-bold text-slate-800 text-sm">Credit / Debit Card</div>
                                    <div class="text-xs text-slate-500 mt-0.5">Pay securely online (demo mock gateway).</div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Right: Summary Sidebar -->
                <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm space-y-6">
                    <h3 class="font-extrabold text-slate-900 text-base border-b pb-4">Order Items</h3>
                    
                    <div class="space-y-4 max-h-60 overflow-y-auto pr-2">
                        @foreach($cartItems as $item)
                            <div class="flex justify-between items-center gap-3 text-xs">
                                <span class="font-semibold text-slate-800 line-clamp-1 flex-1">{{ $item['name'] }} <span class="text-slate-400 text-[10px]">x{{ $item['quantity'] }}</span></span>
                                <span class="font-bold text-slate-900">₹{{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                            </div>
                        @endforeach
                    </div>

                    <div class="space-y-3.5 text-sm text-slate-600 border-t pt-4">
                        <div class="flex justify-between">
                            <span>Subtotal</span>
                            <span class="font-semibold text-slate-800">₹{{ number_format($subtotal, 2) }}</span>
                        </div>
                        
                        @if($discount > 0)
                            <div class="flex justify-between text-red-600 font-medium">
                                <span>Coupon Discount</span>
                                <span>-₹{{ number_format($discount, 2) }}</span>
                            </div>
                        @endif

                        <div class="flex justify-between">
                            <span>Shipping</span>
                            @if($shipping === 0)
                                <span class="font-bold text-teal-600 uppercase text-xs">Free</span>
                            @else
                                <span class="font-semibold text-slate-800">₹{{ number_format($shipping, 2) }}</span>
                            @endif
                        </div>

                        <div class="flex justify-between text-xs text-slate-400">
                            <span>GST Included</span>
                            <span>₹{{ number_format($totalTax, 2) }}</span>
                        </div>
                    </div>

                    @if(auth()->user()->gst_number)
                        <div class="bg-indigo-50 border border-indigo-100 p-3.5 rounded-xl text-xs text-indigo-900">
                            <p class="font-semibold">Registered Professional GST</p>
                            <p class="font-mono mt-0.5">{{ auth()->user()->company_name }} ({{ auth()->user()->gst_number }})</p>
                            <p class="text-[10px] text-indigo-700/80 mt-1">This order will receive a valid GST tax claim invoice.</p>
                        </div>
                    @endif

                    <div class="border-t pt-4 flex justify-between items-baseline">
                        <span class="font-extrabold text-slate-900 text-sm">Grand Total</span>
                        <span class="font-black text-slate-900 text-xl">₹{{ number_format($total, 2) }}</span>
                    </div>

                    <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white font-bold h-14 rounded-xl shadow-lg hover:shadow-teal-500/20 transition flex items-center justify-center gap-2">
                        <span>Place Order</span>
                    </button>
                </div>

            </div>
        </form>
    </div>

    <script>
        (function () {
            const allowed = @json(config('delivery.pincodes', []));
            const form = document.querySelector('form[action*="checkout/place"]');
            if (!form) return;

            form.addEventListener('submit', function (e) {
                const input = form.querySelector('input[name="new_address[postal_code]"]');
                const errorEl = form.querySelector('[data-pincode-error]');
                if (!input || !errorEl) return; // using a saved address — validated on the server

                const code = (input.value || '').trim();
                const valid = allowed.includes(code);
                errorEl.classList.toggle('hidden', valid);
                input.classList.toggle('border-red-500', !valid);
                if (valid) return;

                errorEl.textContent = 'Sorry, we deliver only within Bangalore city. This PIN code is not serviceable.';
                e.preventDefault();
            });
        })();
    </script>
</x-app-layout>
