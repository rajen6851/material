<x-admin-layout>

    <x-slot name="title">Add Spotlight</x-slot>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Header --}}
        <div class="mb-8">

            <a
                href="{{ route('admin.spotlights.index') }}"
                class="inline-flex items-center gap-2 text-sm
                       text-slate-500 hover:text-indigo-600 mb-4"
            >
                ← Back to Spotlights
            </a>

            <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">
                Add Spotlight
            </h1>

            <p class="text-sm text-slate-500 mt-1">
                Create a new homepage spotlight section.
            </p>

        </div>


        {{-- Form --}}
        <form
            action="{{ route('admin.spotlights.store') }}"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf


            <div class="bg-white border border-slate-200
                        rounded-3xl shadow-sm p-6 md:p-8 space-y-7">


                {{-- Label --}}
                <div>

                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Label
                    </label>

                    <input
                        type="text"
                        name="label"
                        value="{{ old('label') }}"
                        placeholder="e.g. BATHROOM SPOTLIGHT"
                        class="w-full rounded-xl border border-slate-300
                               px-4 py-3
                               focus:border-indigo-500
                               focus:ring-indigo-500"
                    >

                    @error('label')
                        <p class="text-xs text-red-600 mt-1">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Title --}}
                <div>

                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Title <span class="text-red-500">*</span>
                    </label>

                    <textarea
                        name="title"
                        rows="3"
                        required
                        placeholder="Everything for&#10;Your Perfect Bathroom"
                        class="w-full rounded-xl border border-slate-300
                               px-4 py-3
                               focus:border-indigo-500
                               focus:ring-indigo-500"
                    >{{ old('title') }}</textarea>

                    <p class="text-xs text-slate-400 mt-1">
                        New line use kar sakte ho. Homepage par line break show hoga.
                    </p>

                    @error('title')
                        <p class="text-xs text-red-600 mt-1">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Description --}}
                <div>

                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Description
                    </label>

                    <textarea
                        name="description"
                        rows="4"
                        placeholder="From sanitaryware to accessories..."
                        class="w-full rounded-xl border border-slate-300
                               px-4 py-3
                               focus:border-indigo-500
                               focus:ring-indigo-500"
                    >{{ old('description') }}</textarea>

                    @error('description')
                        <p class="text-xs text-red-600 mt-1">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Category + Button --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    {{-- Category --}}
                    <div>

                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Category Slug
                        </label>

                        <input
                            type="text"
                            name="category_slug"
                            value="{{ old('category_slug') }}"
                            placeholder="e.g. sanitary-ware"
                            class="w-full rounded-xl border border-slate-300
                                   px-4 py-3
                                   focus:border-indigo-500
                                   focus:ring-indigo-500"
                        >

                        <p class="text-xs text-slate-400 mt-1">
                            Button isi category ke products page par jayega.
                        </p>

                        @error('category_slug')
                            <p class="text-xs text-red-600 mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- Button Text --}}
                    <div>

                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Button Text
                        </label>

                        <input
                            type="text"
                            name="button_text"
                            value="{{ old('button_text', 'EXPLORE BATHROOM') }}"
                            placeholder="EXPLORE BATHROOM"
                            class="w-full rounded-xl border border-slate-300
                                   px-4 py-3
                                   focus:border-indigo-500
                                   focus:ring-indigo-500"
                        >

                        @error('button_text')
                            <p class="text-xs text-red-600 mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                </div>


                {{-- Image --}}
                <div>

                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Spotlight Image
                    </label>

                    <input
                        type="file"
                        name="image"
                        accept="image/jpeg,image/png,image/webp"
                        class="w-full rounded-xl border border-slate-300
                               px-4 py-3
                               file:mr-4 file:rounded-lg
                               file:border-0 file:bg-indigo-50
                               file:px-4 file:py-2
                               file:text-sm file:font-semibold
                               file:text-indigo-700"
                    >

                    <p class="text-xs text-slate-400 mt-2">
                        JPG, JPEG, PNG or WEBP — maximum 4MB.
                    </p>

                    @error('image')
                        <p class="text-xs text-red-600 mt-1">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Order + Active --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    {{-- Sort Order --}}
                    <div>

                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Sort Order
                        </label>

                        <input
                            type="number"
                            name="sort_order"
                            value="{{ old('sort_order', 0) }}"
                            min="0"
                            class="w-full rounded-xl border border-slate-300
                                   px-4 py-3
                                   focus:border-indigo-500
                                   focus:ring-indigo-500"
                        >

                        <p class="text-xs text-slate-400 mt-1">
                            Smaller number = upper position.
                        </p>

                    </div>


                    {{-- Active --}}
                    <div>

                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Status
                        </label>

                        <label class="flex items-center gap-3
                                      border border-slate-300
                                      rounded-xl px-4 py-3 cursor-pointer">

                            <input
                                type="checkbox"
                                name="is_active"
                                value="1"
                                {{ old('is_active', true) ? 'checked' : '' }}
                                class="w-5 h-5 rounded
                                       text-indigo-600
                                       focus:ring-indigo-500"
                            >

                            <span class="text-sm font-medium text-slate-700">
                                Active
                            </span>

                        </label>

                    </div>

                </div>


                {{-- Buttons --}}
                <div class="pt-5 border-t border-slate-200
                            flex flex-col sm:flex-row
                            gap-3 sm:justify-end">

                    <a
                        href="{{ route('admin.spotlights.index') }}"
                        class="inline-flex items-center justify-center
                               px-5 py-3 rounded-xl
                               border border-slate-300
                               text-slate-700 font-semibold
                               hover:bg-slate-50"
                    >
                        Cancel
                    </a>

                    <button
                        type="submit"
                        class="inline-flex items-center justify-center
                               px-6 py-3 rounded-xl
                               bg-indigo-600 hover:bg-indigo-700
                               text-white font-semibold
                               shadow-sm transition"
                    >
                        Save Spotlight
                    </button>

                </div>

            </div>

        </form>

    </div>

</x-admin-layout>