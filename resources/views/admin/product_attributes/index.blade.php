<x-admin-layout>
    <x-slot name="title">Variant Options - Admin</x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="flex justify-between items-center border-b pb-4 mb-8">
            <div>
                <h1 class="text-3xl font-black text-slate-900">Variant Options Manager</h1>
                <p class="text-slate-500 text-sm">Add, edit or disable dropdown options for Product forms (Collection, Material, Finish, etc.)</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 items-start">

            <!-- Left: Add New Option -->
            <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm space-y-4 lg:sticky lg:top-8">
                <h3 class="font-extrabold text-slate-900 text-lg border-b pb-3">Add Variant Option</h3>
                <form action="{{ route('admin.product-attributes.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Attribute Type</label>
                        <select name="type" required class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                            @foreach($types as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Option Value</label>
                        <input type="text" name="value" required placeholder="e.g. Glossy, Ceramic, GVT..." class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                    </div>
                    <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white font-bold py-3 rounded-xl transition text-sm">+ Add Option</button>
                </form>
            </div>

            <!-- Right: All Variant Options grouped by type -->
            <div class="lg:col-span-2 space-y-6">
                @foreach($types as $typeKey => $typeLabel)
                <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm">
                    <h3 class="font-extrabold text-slate-900 text-lg border-b pb-3 mb-4 flex items-center justify-between">
                        <span>{{ $typeLabel }}</span>
                        <span class="text-xs font-mono bg-slate-100 text-slate-500 px-2 py-1 rounded">{{ $typeKey }}</span>
                    </h3>

                    @if(isset($attributes[$typeKey]) && $attributes[$typeKey]->count())
                    <div class="overflow-x-auto text-xs">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b bg-slate-50 text-slate-500 font-bold uppercase">
                                    <th class="py-2.5 px-4">#</th>
                                    <th class="py-2.5 px-4">Value</th>
                                    <th class="py-2.5 px-4">Status</th>
                                    <th class="py-2.5 px-4 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                @foreach($attributes[$typeKey] as $idx => $attr)
                                <tr class="hover:bg-slate-50/50 transition {{ !$attr->is_active ? 'opacity-40' : '' }}">
                                    <td class="py-2.5 px-4 text-slate-400 font-mono">{{ $idx + 1 }}</td>
                                    <td class="py-2.5 px-4 font-bold text-slate-800 text-sm">{{ $attr->value }}</td>
                                    <td class="py-2.5 px-4">
                                        <form action="{{ route('admin.product-attributes.toggle', $attr->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="px-2.5 py-1 rounded-full text-[10px] font-bold transition {{ $attr->is_active ? 'bg-teal-50 text-teal-700 hover:bg-teal-100' : 'bg-red-50 text-red-600 hover:bg-red-100' }}">
                                                {{ $attr->is_active ? '● Active' : '○ Inactive' }}
                                            </button>
                                        </form>
                                    </td>
                                    <td class="py-2.5 px-4 text-right">
                                        <div class="flex justify-end gap-2">
                                            <!-- Inline Edit -->
                                            <form action="{{ route('admin.product-attributes.update', $attr->id) }}" method="POST" class="flex items-center gap-1">
                                                @csrf
                                                <input type="text" name="value" value="{{ $attr->value }}" class="border-slate-200 rounded-lg text-xs p-1.5 w-28 focus:border-teal-500 focus:ring-0">
                                                <button type="submit" class="bg-slate-100 hover:bg-teal-50 hover:text-teal-700 text-slate-700 font-bold px-2 py-1.5 rounded-lg transition text-[10px]">Save</button>
                                            </form>
                                            <!-- Delete -->
                                            <form action="{{ route('admin.product-attributes.delete', $attr->id) }}" method="POST" onsubmit="return confirm('Delete variant option \'{{ $attr->value }}\'?');">
                                                @csrf
                                                <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-600 font-bold px-2 py-1.5 rounded-lg transition text-[10px]">Del</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <p class="text-slate-400 text-sm py-4 text-center">No options yet. Add one using the form.</p>
                    @endif
                </div>
                @endforeach
            </div>

        </div>
    </div>
</x-admin-layout>
