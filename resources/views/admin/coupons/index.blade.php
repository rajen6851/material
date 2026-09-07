<x-admin-layout>
    <x-slot name="title">Manage Coupons &amp; Promos - Admin</x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="flex justify-between items-center mb-8 border-b pb-4">
            <div>
                <h1 class="text-3xl font-black text-slate-900">Coupons &amp; Promos</h1>
                <p class="text-slate-500 text-sm">Create discount codes customers can apply at checkout.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 items-start">
            <!-- Left: Add Coupon Form -->
            <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm space-y-4 lg:sticky lg:top-8">
                <h3 class="font-extrabold text-slate-900 text-lg border-b pb-3">Create Coupon</h3>

                <form action="{{ route('admin.coupons.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Coupon Code</label>
                        <input type="text" name="code" required placeholder="e.g. DECK10" class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3 uppercase">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Type</label>
                            <select name="type" required class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                                <option value="percentage">Percentage (%)</option>
                                <option value="fixed">Fixed (₹)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Value</label>
                            <input type="number" name="value" step="0.01" min="0" required placeholder="e.g. 10" class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Minimum Order Amount</label>
                        <input type="number" name="min_order_amount" step="0.01" min="0" placeholder="e.g. 1000 (0 = no minimum)" class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Expires On</label>
                        <input type="date" name="expires_at" placeholder="Leave blank for no expiry" class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                    </div>
                    <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white font-bold py-3 rounded-xl transition text-sm">Save Coupon</button>
                </form>
            </div>

            <!-- Right: Coupons List -->
            <div class="lg:col-span-2 bg-white border border-slate-200 rounded-3xl p-6 shadow-sm">
                <h3 class="font-extrabold text-slate-900 text-lg border-b pb-3 mb-4">All Coupons</h3>

                @if($coupons->isEmpty())
                    <p class="text-center py-12 text-slate-400 text-sm">No coupons yet. Create your first promo code.</p>
                @else
                    <div class="overflow-x-auto text-xs">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b bg-slate-50 text-slate-500 font-bold uppercase">
                                    <th class="py-3 px-4">Code</th>
                                    <th class="py-3 px-4">Value</th>
                                    <th class="py-3 px-4">Min. Order</th>
                                    <th class="py-3 px-4">Expires</th>
                                    <th class="py-3 px-4">Status</th>
                                    <th class="py-3 px-4 text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                @foreach($coupons as $coupon)
                                    <tr class="hover:bg-slate-50/50 transition">
                                        <td class="py-3 px-4">
                                            <span class="font-mono font-bold text-slate-800 bg-slate-100 px-2 py-1 rounded">{{ $coupon->code }}</span>
                                        </td>
                                        <td class="py-3 px-4 font-bold text-slate-800">
                                            {{ $coupon->type === 'percentage' ? $coupon->value . '%' : '₹' . number_format((float)$coupon->value, 0) }}
                                        </td>
                                        <td class="py-3 px-4 text-slate-500">₹{{ number_format((float)$coupon->min_order_amount, 0) }}</td>
                                        <td class="py-3 px-4 text-slate-500">
                                            @if($coupon->expires_at)
                                                {{ $coupon->expires_at->format('d M Y') }}
                                                @if($coupon->expires_at->isPast()) <span class="text-red-500 font-bold">(Expired)</span> @endif
                                            @else
                                                <span class="text-slate-400">Never</span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-4">
                                            @if($coupon->is_active)
                                                <span class="bg-teal-50 text-teal-700 font-bold px-2.5 py-1 rounded-full text-[10px]">Active</span>
                                            @else
                                                <span class="bg-slate-100 text-slate-500 font-bold px-2.5 py-1 rounded-full text-[10px]">Inactive</span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-4 text-right">
                                            <div class="flex justify-end gap-2">
                                                <form action="{{ route('admin.coupons.toggle', $coupon->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="bg-slate-100 hover:bg-teal-50 hover:text-teal-700 text-slate-700 font-bold px-3 py-1.5 rounded-lg transition">
                                                        {{ $coupon->is_active ? 'Deactivate' : 'Activate' }}
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.coupons.delete', $coupon->id) }}" method="POST" onsubmit="return confirm('Delete coupon \'{{ $coupon->code }}\'?');">
                                                    @csrf
                                                    <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-600 font-bold px-3 py-1.5 rounded-lg transition">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-admin-layout>