<x-admin-layout>
    <x-slot name="title">Bulk Import Products - Admin Dashboard</x-slot>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8">
        
        {{-- Top Bar --}}
        <div class="flex items-center justify-between border-b border-slate-200/80 pb-6">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-teal-100 text-teal-800 border border-teal-200">Catalog Operations</span>
                    <span class="text-xs font-semibold text-slate-400">&bull; High Speed Importer</span>
                </div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">Bulk Product Import</h1>
                <p class="text-slate-500 text-xs mt-1">Upload 1000+ tile and material items at once using CSV spreadsheets.</p>
            </div>
            <a href="{{ route('admin.products') }}" class="bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-bold text-xs px-4 py-2.5 rounded-xl shadow-xs transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                <span>Back to Inventory</span>
            </a>
        </div>

        {{-- Flash Feedback Messages --}}
        @if(session('success'))
            <div class="bg-emerald-500/10 border border-emerald-500/30 text-emerald-900 p-6 rounded-3xl shadow-sm space-y-3">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-emerald-500 text-white rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-extrabold text-sm text-emerald-950">{{ session('success') }}</h4>
                        @if(session('created_count') !== null)
                            <div class="flex items-center gap-4 text-xs text-emerald-800 mt-1 font-semibold">
                                <span class="bg-emerald-100 px-2.5 py-0.5 rounded-full text-emerald-900 font-bold">Created: {{ session('created_count') }}</span>
                                <span class="bg-teal-100 px-2.5 py-0.5 rounded-full text-teal-900 font-bold">Updated: {{ session('updated_count') }}</span>
                                <span class="bg-slate-100 px-2.5 py-0.5 rounded-full text-slate-700 font-bold">Skipped: {{ session('failed_count') }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                @if(session('import_errors') && count(session('import_errors')) > 0)
                    <div class="mt-4 border-t border-emerald-200/80 pt-3">
                        <span class="text-[11px] font-black text-emerald-950 uppercase tracking-wider">Skipped Row Details:</span>
                        <ul class="list-disc list-inside text-xs text-emerald-800 space-y-1 mt-1 max-h-44 overflow-y-auto font-mono">
                            @foreach(session('import_errors') as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-500/10 border border-red-500/30 text-red-900 p-5 rounded-3xl text-xs font-extrabold flex items-center gap-3 shadow-sm">
                <div class="w-8 h-8 bg-red-500 text-white rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        {{-- Upload & Instructions Card --}}
        <div class="bg-white border border-slate-200/80 rounded-3xl p-6 md:p-8 shadow-sm space-y-8">

            {{-- Download Template Banner --}}
            <div class="bg-gradient-to-r from-slate-900 to-[#1e344d] text-white rounded-2xl p-6 flex flex-col md:flex-row items-center justify-between gap-5 shadow-md">
                <div class="space-y-1">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-teal-400"></span>
                        <h3 class="font-extrabold text-sm text-white">Need the official CSV spreadsheet template?</h3>
                    </div>
                    <p class="text-xs text-slate-300">Download our pre-formatted CSV template containing all 28 tile spec columns and sample rows.</p>
                </div>
                <a href="{{ route('admin.products.import.sample') }}" class="bg-teal-500 hover:bg-teal-400 text-slate-950 font-black text-xs px-5 py-3 rounded-xl shadow-lg shadow-teal-500/20 transition-all inline-flex items-center gap-2 whitespace-nowrap">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    <span>Download Sample CSV</span>
                </a>
            </div>

            {{-- Form Upload Area --}}
            <form action="{{ route('admin.products.import.process') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-2">Upload CSV File *</label>
                    <div class="border-2 border-dashed border-slate-300 hover:border-teal-500 transition-all rounded-3xl p-10 text-center bg-slate-50/50 hover:bg-teal-50/30 group cursor-pointer relative">
                        <input type="file" id="csvFileInput" name="csv_file" accept=".csv,.txt,.xlsx,.xls" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                        <div class="space-y-4">
                            <div class="w-16 h-16 bg-teal-100/80 text-teal-700 rounded-3xl flex items-center justify-center mx-auto group-hover:scale-110 group-hover:bg-teal-600 group-hover:text-white transition duration-300 shadow-sm">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                            </div>
                            <div>
                                <p class="text-sm font-black text-slate-900" id="fileTitleText">Click to browse or drag and drop your CSV file</p>
                                <p class="text-xs text-slate-400 mt-1 font-semibold" id="fileSubText">Supports .CSV up to 20MB (1000+ products recommended)</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <a href="{{ route('admin.products') }}" class="px-5 py-3 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-50 transition">Cancel</a>
                    <button type="submit" class="bg-gradient-to-r from-teal-600 to-emerald-600 hover:from-teal-700 hover:to-emerald-700 text-white font-extrabold text-xs px-7 py-3 rounded-xl shadow-lg shadow-teal-600/20 transition-all inline-flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        <span>Start Bulk Import</span>
                    </button>
                </div>
            </form>

            {{-- Supported Columns Reference Grid --}}
            <div class="border-t border-slate-100 pt-6">
                <div class="flex items-center justify-between mb-3">
                    <h4 class="text-xs font-extrabold text-slate-800 uppercase tracking-wider">Supported Column Headers (28 Specs)</h4>
                    <span class="text-[10px] font-bold text-teal-600 bg-teal-50 px-2 py-0.5 rounded-md">Auto-Matched</span>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-2 text-[11px] font-mono text-slate-600">
                    <div class="bg-slate-50 border border-slate-200/80 p-2 rounded-xl">Tile Name *</div>
                    <div class="bg-slate-50 border border-slate-200/80 p-2 rounded-xl">SKU / Product Code</div>
                    <div class="bg-slate-50 border border-slate-200/80 p-2 rounded-xl">Category</div>
                    <div class="bg-slate-50 border border-slate-200/80 p-2 rounded-xl">Sub Category</div>
                    <div class="bg-slate-50 border border-slate-200/80 p-2 rounded-xl">Collection</div>
                    <div class="bg-slate-50 border border-slate-200/80 p-2 rounded-xl">Finish</div>
                    <div class="bg-slate-50 border border-slate-200/80 p-2 rounded-xl">Width (mm)</div>
                    <div class="bg-slate-50 border border-slate-200/80 p-2 rounded-xl">Height (mm)</div>
                    <div class="bg-slate-50 border border-slate-200/80 p-2 rounded-xl">Size (mm)</div>
                    <div class="bg-slate-50 border border-slate-200/80 p-2 rounded-xl">Thickness (mm)</div>
                    <div class="bg-slate-50 border border-slate-200/80 p-2 rounded-xl">Size (Inch)</div>
                    <div class="bg-slate-50 border border-slate-200/80 p-2 rounded-xl">Area/Tile (sq.ft)</div>
                    <div class="bg-slate-50 border border-slate-200/80 p-2 rounded-xl">Pattern Types</div>
                    <div class="bg-slate-50 border border-slate-200/80 p-2 rounded-xl">Edge Type</div>
                    <div class="bg-slate-50 border border-slate-200/80 p-2 rounded-xl">Pieces per Box</div>
                    <div class="bg-slate-50 border border-slate-200/80 p-2 rounded-xl">Coverage per Box</div>
                    <div class="bg-slate-50 border border-slate-200/80 p-2 rounded-xl">Weight per Box</div>
                    <div class="bg-slate-50 border border-slate-200/80 p-2 rounded-xl">Price per Box</div>
                    <div class="bg-slate-50 border border-slate-200/80 p-2 rounded-xl">Price per Sq.Ft</div>
                    <div class="bg-slate-50 border border-slate-200/80 p-2 rounded-xl">Application Area</div>
                    <div class="bg-slate-50 border border-slate-200/80 p-2 rounded-xl">Stock Status</div>
                    <div class="bg-slate-50 border border-slate-200/80 p-2 rounded-xl">Tile Image</div>
                    <div class="bg-slate-50 border border-slate-200/80 p-2 rounded-xl">SEO Meta Description</div>
                    <div class="bg-slate-50 border border-slate-200/80 p-2 rounded-xl">URL Slug</div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('csvFileInput');
            const title = document.getElementById('fileTitleText');
            const sub = document.getElementById('fileSubText');

            if (input) {
                input.addEventListener('change', function(e) {
                    if (e.target.files.length > 0) {
                        const file = e.target.files[0];
                        title.textContent = "Selected: " + file.name;
                        title.classList.add('text-teal-700');
                        sub.textContent = "File Size: " + (file.size / 1024).toFixed(1) + " KB — Ready to upload!";
                        sub.classList.add('text-emerald-600');
                    }
                });
            }
        });
    </script>
</x-admin-layout>
