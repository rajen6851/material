<x-app-layout>
    <x-slot name="title">Request Custom Quotation - MaterialDeck</x-slot>

    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        
        <div class="bg-white border rounded-2xl p-6 md:p-8 shadow-sm space-y-6">
            <div class="border-b pb-4">
                <h1 class="text-2xl font-extrabold text-slate-900">Request Bulk Quotation</h1>
                <p class="text-slate-500 text-sm mt-1">Submit your requirements and our commercial partners will propose discounted bulk pricing.</p>
            </div>

            <form action="{{ route('quotation.store') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Product -->
                <div>
                    <label for="product_id" class="block text-xs font-bold text-slate-500 uppercase mb-1">Select Product</label>
                    <select id="product_id" name="product_id" required class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                        <option value="">-- Choose Product --</option>
                        @foreach($products as $prod)
                            <option value="{{ $prod->id }}" {{ ($selectedProduct && $selectedProduct->id === $prod->id) ? 'selected' : '' }}>
                                {{ $prod->name }} (SKU: {{ $prod->sku }}, MRP: ₹{{ $prod->mrp }})
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('product_id')" class="mt-1" />
                </div>

                <!-- Quantity -->
                <div>
                    <label for="quantity" class="block text-xs font-bold text-slate-500 uppercase mb-1">Required Quantity (Boxes / Units)</label>
                    <input type="number" id="quantity" name="quantity" min="1" value="10" required class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                    <x-input-error :messages="$errors->get('quantity')" class="mt-1" />
                    <p class="text-[10px] text-slate-400 mt-1">Bulk quotes are typically processed for quantities of 10 boxes/units or more.</p>
                </div>

                <!-- Shipping Address -->
                <div>
                    <label for="address" class="block text-xs font-bold text-slate-500 uppercase mb-1">Delivery Site Address</label>
                    <textarea id="address" name="address" rows="3" required placeholder="Enter the complete site delivery address..." class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3"></textarea>
                    <x-input-error :messages="$errors->get('address')" class="mt-1" />
                </div>

                <!-- Remarks -->
                <div>
                    <label for="remarks" class="block text-xs font-bold text-slate-500 uppercase mb-1">Additional Requirements / Remarks (Optional)</label>
                    <textarea id="remarks" name="remarks" rows="2" placeholder="e.g. need fast shipping, matching grout requested, thickness specifications..." class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3"></textarea>
                    <x-input-error :messages="$errors->get('remarks')" class="mt-1" />
                </div>

                <!-- Actions -->
                <div class="pt-4 flex gap-4">
                    <a href="/dashboard" class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold py-3.5 rounded-xl text-center text-sm transition">Cancel</a>
                    <button type="submit" class="flex-grow bg-teal-600 hover:bg-teal-700 text-white font-bold py-3.5 rounded-xl shadow-md transition text-sm">Submit Request</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
