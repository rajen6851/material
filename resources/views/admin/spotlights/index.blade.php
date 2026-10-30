<x-admin-layout>

    <x-slot name="title">Manage Spotlights</x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">

            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">
                    Spotlights
                </h1>

                <p class="text-sm text-slate-500 mt-1">
                    Manage homepage spotlight sections.
                </p>
            </div>

            <a href="{{ route('admin.spotlights.create') }}"
               class="inline-flex items-center justify-center gap-2
                      bg-indigo-600 hover:bg-indigo-700
                      text-white font-semibold
                      px-5 py-3 rounded-xl
                      transition shadow-sm">

                <span class="text-lg">+</span>
                Add Spotlight
            </a>

        </div>


        {{-- Success Message --}}
        @if(session('success'))
            <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                {{ session('success') }}
            </div>
        @endif


        {{-- Validation Errors --}}
        @if($errors->any())
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3">
                <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        {{-- Table --}}
        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">

            @if($spotlights->count())

                <div class="overflow-x-auto">

                    <table class="w-full text-sm">

                        <thead class="bg-slate-50 border-b border-slate-200">

                            <tr>

                                <th class="text-left px-5 py-4 font-semibold text-slate-600">
                                    Image
                                </th>

                                <th class="text-left px-5 py-4 font-semibold text-slate-600">
                                    Spotlight
                                </th>

                                <th class="text-left px-5 py-4 font-semibold text-slate-600">
                                    Category
                                </th>

                                <th class="text-center px-5 py-4 font-semibold text-slate-600">
                                    Order
                                </th>

                                <th class="text-center px-5 py-4 font-semibold text-slate-600">
                                    Status
                                </th>

                                <th class="text-right px-5 py-4 font-semibold text-slate-600">
                                    Actions
                                </th>

                            </tr>

                        </thead>


                        <tbody class="divide-y divide-slate-100">

                            @foreach($spotlights as $spotlight)

                                <tr class="hover:bg-slate-50 transition">

                                    {{-- Image --}}
                                    <td class="px-5 py-4">

                                        @if($spotlight->image)

                                            <img
                                                src="{{ asset('storage/' . $spotlight->image) }}"
                                                alt="{{ $spotlight->title }}"
                                                class="w-28 h-16 object-cover rounded-xl border border-slate-200"
                                            >

                                        @else

                                            <div class="w-28 h-16 rounded-xl bg-slate-100
                                                        flex items-center justify-center
                                                        text-xs text-slate-400">
                                                No Image
                                            </div>

                                        @endif

                                    </td>


                                    {{-- Details --}}
                                    <td class="px-5 py-4 min-w-[280px]">

                                        @if($spotlight->label)

                                            <div class="text-[10px] font-bold uppercase
                                                        tracking-widest text-amber-600 mb-1">
                                                {{ $spotlight->label }}
                                            </div>

                                        @endif

                                        <div class="font-semibold text-slate-900">
                                            {{ $spotlight->title }}
                                        </div>

                                        @if($spotlight->description)

                                            <div class="text-xs text-slate-500 mt-1 line-clamp-2">
                                                {{ $spotlight->description }}
                                            </div>

                                        @endif

                                        <div class="text-xs text-slate-400 mt-2">
                                            Button:
                                            <span class="font-medium text-slate-600">
                                                {{ $spotlight->button_text }}
                                            </span>
                                        </div>

                                    </td>


                                    {{-- Category --}}
                                    <td class="px-5 py-4">

                                        @if($spotlight->category_slug)

                                            <span class="inline-flex px-3 py-1 rounded-lg
                                                         bg-indigo-50 text-indigo-700
                                                         text-xs font-semibold">
                                                {{ $spotlight->category_slug }}
                                            </span>

                                        @else

                                            <span class="text-slate-400">
                                                —
                                            </span>

                                        @endif

                                    </td>


                                    {{-- Order --}}
                                    <td class="px-5 py-4 text-center">

                                        <span class="inline-flex w-9 h-9 items-center justify-center
                                                     rounded-lg bg-slate-100
                                                     font-semibold text-slate-700">
                                            {{ $spotlight->sort_order }}
                                        </span>

                                    </td>


                                    {{-- Status --}}
                                    <td class="px-5 py-4 text-center">

                                        @if($spotlight->is_active)

                                            <span class="inline-flex items-center gap-1.5
                                                         px-3 py-1.5 rounded-full
                                                         bg-green-50 text-green-700
                                                         text-xs font-semibold">

                                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>

                                                Active

                                            </span>

                                        @else

                                            <span class="inline-flex items-center gap-1.5
                                                         px-3 py-1.5 rounded-full
                                                         bg-red-50 text-red-700
                                                         text-xs font-semibold">

                                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>

                                                Inactive

                                            </span>

                                        @endif

                                    </td>


                                    {{-- Actions --}}
                                    <td class="px-5 py-4">

                                        <div class="flex items-center justify-end gap-2">

                                            {{-- Edit --}}
                                            <a
                                                href="{{ route('admin.spotlights.edit', $spotlight) }}"
                                                class="inline-flex items-center justify-center
                                                       w-9 h-9 rounded-lg
                                                       bg-indigo-50 text-indigo-600
                                                       hover:bg-indigo-100
                                                       transition"
                                                title="Edit"
                                            >
                                                ✎
                                            </a>


                                            {{-- Delete --}}
                                            <form
                                                action="{{ route('admin.spotlights.delete', $spotlight) }}"
                                                method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this spotlight?');"
                                            >

                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="inline-flex items-center justify-center
                                                           w-9 h-9 rounded-lg
                                                           bg-red-50 text-red-600
                                                           hover:bg-red-100
                                                           transition"
                                                    title="Delete"
                                                >
                                                    🗑
                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                {{-- Empty --}}
                <div class="py-16 text-center">

                    <div class="text-5xl mb-4">
                        🖼️
                    </div>

                    <h3 class="text-lg font-semibold text-slate-900">
                        No Spotlights Found
                    </h3>

                    <p class="text-sm text-slate-500 mt-1 mb-6">
                        Create your first homepage spotlight.
                    </p>

                    <a
                        href="{{ route('admin.spotlights.create') }}"
                        class="inline-flex items-center gap-2
                               bg-indigo-600 hover:bg-indigo-700
                               text-white font-semibold
                               px-5 py-3 rounded-xl"
                    >
                        + Add Spotlight
                    </a>

                </div>

            @endif

        </div>

    </div>

</x-admin-layout>