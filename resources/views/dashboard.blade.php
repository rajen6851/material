<x-app-layout>
    <x-slot name="title">My Account - BuildMart</x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12" x-data="{ activeTab: '{{ auth()->user()->isProfessional() ? 'quotations' : 'dashboard' }}' }">
        
        <div class="flex flex-col lg:flex-row gap-10 items-start">
            
            <!-- Sidebar Navigation (Exactly as mockup) -->
            <aside class="w-full lg:w-64 bg-slate-900 text-slate-400 rounded-2xl p-6 shadow-md flex flex-col justify-between min-h-[600px] flex-shrink-0">
                <div class="space-y-6">
<!-- Brand Label -->
                            <div class="px-3 pb-4 border-b border-slate-800">
                                <span class="text-white font-black text-lg tracking-wide block">Customer Portal</span>
                                <span class="text-[10px] uppercase tracking-widest font-bold mt-1 inline-flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full {{ auth()->user()->isProfessional() ? 'bg-indigo-400' : 'bg-teal-400' }}"></span>
                                    <span class="{{ auth()->user()->isProfessional() ? 'text-indigo-300' : 'text-teal-300' }}">{{ auth()->user()->isProfessional() ? (ucfirst(auth()->user()->professional_type ?: 'Professional') . ' Account') : 'Homeowner Account' }}</span>
                                </span>
                            </div>

                    <nav class="space-y-1.5 font-semibold text-sm">
                        <button @click="activeTab = 'dashboard'" :class="activeTab === 'dashboard' ? 'bg-teal-700/30 text-white border-l-4 border-teal-500 pl-3' : 'hover:bg-slate-800 hover:text-white pl-4'" class="w-full text-left py-2.5 rounded-lg transition flex items-center gap-3">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                            <span>Dashboard</span>
                        </button>
                        
                        <button @click="activeTab = 'profile'" :class="activeTab === 'profile' ? 'bg-teal-700/30 text-white border-l-4 border-teal-500 pl-3' : 'hover:bg-slate-800 hover:text-white pl-4'" class="w-full text-left py-2.5 rounded-lg transition flex items-center gap-3">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            <span>Profile</span>
                        </button>

                        <button @click="activeTab = 'orders'" :class="activeTab === 'orders' ? 'bg-teal-700/30 text-white border-l-4 border-teal-500 pl-3' : 'hover:bg-slate-800 hover:text-white pl-4'" class="w-full text-left py-2.5 rounded-lg transition flex items-center gap-3">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            <span>My Orders</span>
                        </button>

                        <button @click="activeTab = 'quotations'" :class="activeTab === 'quotations' ? 'bg-teal-700/30 text-white border-l-4 border-teal-500 pl-3' : 'hover:bg-slate-800 hover:text-white pl-4'" class="w-full text-left py-2.5 rounded-lg transition flex items-center gap-3">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            <span>Quotations</span>
                        </button>

                        <button @click="activeTab = 'visits'" :class="activeTab === 'visits' ? 'bg-teal-700/30 text-white border-l-4 border-teal-500 pl-3' : 'hover:bg-slate-800 hover:text-white pl-4'" class="w-full text-left py-2.5 rounded-lg transition flex items-center gap-3">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            <span>Showroom Visits</span>
                        </button>

                        <button @click="activeTab = 'addresses'" :class="activeTab === 'addresses' ? 'bg-teal-700/30 text-white border-l-4 border-teal-500 pl-3' : 'hover:bg-slate-800 hover:text-white pl-4'" class="w-full text-left py-2.5 rounded-lg transition flex items-center gap-3">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                            <span>Address Book</span>
                        </button>

                        <button @click="activeTab = 'project'" :class="activeTab === 'project' ? 'bg-teal-700/30 text-white border-l-4 border-teal-500 pl-3' : 'hover:bg-slate-800 hover:text-white pl-4'" class="w-full text-left py-2.5 rounded-lg transition flex items-center gap-3">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span>Project Management</span>
                        </button>
                    </nav>
                </div>

                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}" class="pt-4 border-t border-slate-800">
                    @csrf
                    <button type="submit" class="w-full text-left pl-4 py-2.5 rounded-lg hover:bg-red-950/40 hover:text-red-400 transition text-sm flex items-center gap-3 font-semibold">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        <span>Logout</span>
                    </button>
                </form>
            </aside>

            <!-- Right Workspace Area -->
            <div class="flex-grow w-full bg-white border border-slate-200 rounded-3xl p-6 md:p-8 shadow-sm min-h-[600px]">
                
                <!-- Tab: My Quotations (Matches mockup exactly) -->
                <div x-show="activeTab === 'quotations'" class="space-y-8">
                    <!-- Title & Profile Header -->
                    <div class="flex flex-col sm:flex-row justify-between sm:items-start border-b pb-6 gap-6">
                        <div>
                            <h2 class="text-3xl font-black text-slate-900">My Quotations</h2>
                        </div>
                        
                        <!-- Mini profile badge -->
                        <div class="flex items-center gap-3 text-xs bg-slate-50 border p-3 rounded-xl">
                            <div class="w-10 h-10 bg-slate-300 rounded-full flex items-center justify-center text-slate-600 font-bold text-sm">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <div class="space-y-0.5 text-slate-600 font-semibold">
                                <p class="text-slate-800 font-bold text-sm">Name: {{ auth()->user()->name }}</p>
                                <p class="capitalize">Professional Type: {{ auth()->user()->professional_type ?: 'Retailer' }}</p>
                                <p>Company: {{ auth()->user()->company_name ?: 'Individual' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Active Quotations Grid -->
                    <div>
                        <h3 class="font-extrabold text-slate-800 text-lg mb-4">Active Quotations</h3>
                        
                        @if($quotations->isEmpty())
                            <p class="text-slate-400 text-sm py-4">No active quotations.</p>
                        @else
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach($quotations as $quote)
                                    <div class="border rounded-2xl p-5 bg-white space-y-4 hover:border-slate-300 transition relative">
                                        <!-- Header row -->
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <span class="text-[10px] text-slate-400 font-bold uppercase block">Quotation ID</span>
                                                <span class="font-bold text-slate-800 font-mono text-sm">Q-{{ 10000 + $quote->id }}</span>
                                            </div>
                                            <!-- Status badge -->
                                            <span class="text-[9px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-full {{ $quote->status === 'approved' ? 'bg-emerald-100 text-emerald-800' : ($quote->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-amber-100 text-amber-800') }}">
                                                {{ $quote->status === 'pending' ? 'Pending Admin' : $quote->status }}
                                            </span>
                                        </div>

                                        <div class="text-xs font-semibold text-slate-600 space-y-2">
                                            <div class="flex justify-between">
                                                <span class="text-slate-400">Date Requested</span>
                                                <span class="text-slate-800">{{ $quote->created_at->format('d/m/Y') }}</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-slate-400">Project Name</span>
                                                <span class="text-slate-800 italic">Project Purchase</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-slate-400">Expiry Date</span>
                                                <span class="text-slate-800">{{ $quote->created_at->addDays(30)->format('d/m/Y') }}</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-slate-400">Total Items</span>
                                                <span class="text-slate-800">1</span>
                                            </div>
                                        </div>

                                        <!-- Approved Actions -->
                                        @if($quote->status === 'approved')
                                            <div class="pt-3 flex gap-2 border-t">
                                                <a href="/checkout?quote_id={{ $quote->id }}" class="flex-1 bg-teal-700 hover:bg-teal-800 text-white font-bold py-2 rounded-lg text-center text-[10px] transition shadow-sm">View &amp; Accept</a>
                                                <a href="#" class="flex-1 border border-teal-600 text-teal-700 hover:bg-teal-50 font-bold py-2 rounded-lg text-center text-[10px] transition">Download PDF</a>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Past Quotations -->
                    <div class="pt-6 border-t">
                        <h3 class="font-extrabold text-slate-800 text-lg mb-4">Past Quotations</h3>
                        
                        <div class="bg-white border rounded-xl overflow-hidden shadow-sm">
                            <table class="w-full text-sm text-left border-collapse text-xs">
                                <thead>
                                    <tr class="border-b bg-slate-50 text-slate-500 font-bold uppercase">
                                        <th class="py-3 px-4">Quotation ID</th>
                                        <th class="py-3 px-4">Date Requested</th>
                                        <th class="py-3 px-4">Expiry Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="border-b hover:bg-slate-50/50 transition">
                                        <td class="py-3.5 px-4 font-mono font-bold text-slate-800">Q-10024</td>
                                        <td class="py-3.5 px-4 text-slate-600">08/Jan/2022</td>
                                        <td class="py-3.5 px-4 text-slate-600">01/09/2023</td>
                                    </tr>
                                    <tr class="border-b hover:bg-slate-50/50 transition">
                                        <td class="py-3.5 px-4 font-mono font-bold text-slate-800">Q-10045</td>
                                        <td class="py-3.5 px-4 text-slate-600">09/May/2023</td>
                                        <td class="py-3.5 px-4 text-slate-600">01/09/2023</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Tab: Dashboard Summary -->
                <div x-show="activeTab === 'dashboard'" class="space-y-6" x-cloak>
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between border-b pb-6 gap-4">
                        <div>
                            <h2 class="text-2xl font-black text-slate-900">Welcome back, {{ auth()->user()->name }}!</h2>
                            <p class="text-slate-500 text-sm mt-1">
                                @if(auth()->user()->isProfessional())
                                    Manage your trade quotations, project materials, and showroom appointments.
                                @else
                                    Track your orders, wishlist, and shop trending materials.
                                @endif
                            </p>
                        </div>
                        <div class="text-xs bg-slate-50 border p-3 rounded-xl font-semibold text-slate-600 capitalize">
                            {{ auth()->user()->isProfessional() ? (auth()->user()->professional_type ?: 'Professional') : 'Homeowner' }}
                        </div>
                    </div>

                    @if(auth()->user()->isProfessional())
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <a href="{{ route('quotation.create') }}" class="bg-slate-900 text-white rounded-2xl p-5 hover:bg-slate-800 transition">
                                <span class="text-lg">📋</span>
                                <p class="font-black mt-2">Request Bulk Quotation</p>
                                <p class="text-[11px] text-slate-300 mt-1">Send your material list &amp; address for trade pricing.</p>
                            </a>
                            <a href="{{ route('showroom.book') }}" class="bg-indigo-600 text-white rounded-2xl p-5 hover:bg-indigo-500 transition">
                                <span class="text-lg">🏬</span>
                                <p class="font-black mt-2">Book Trade Showroom Visit</p>
                                <p class="text-[11px] text-indigo-100 mt-1">Sample inspection &amp; bulk pricing consultation.</p>
                            </a>
                            <a href="/products" class="bg-white border border-slate-200 rounded-2xl p-5 hover:border-teal-500 transition">
                                <span class="text-lg">🔎</span>
                                <p class="font-black mt-2 text-slate-900">Explore Catalog</p>
                                <p class="text-[11px] text-slate-400 mt-1">Browse all tiles, sanitary &amp; fittings.</p>
                            </a>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <a href="/products" class="bg-teal-600 text-white rounded-2xl p-5 hover:bg-teal-700 transition">
                                <span class="text-lg">🛒</span>
                                <p class="font-black mt-2">Continue Shopping</p>
                                <p class="text-[11px] text-teal-100 mt-1">Explore fresh arrivals &amp; bestsellers.</p>
                            </a>
                            <button @click="activeTab = 'orders'" class="bg-white border border-slate-200 rounded-2xl p-5 hover:border-teal-500 transition text-left w-full">
                                <span class="text-lg">📦</span>
                                <p class="font-black mt-2 text-slate-900">Track My Orders</p>
                                <p class="text-[11px] text-slate-400 mt-1">Check the status of your purchases.</p>
                            </button>
                            <a href="{{ route('showroom.book') }}" class="bg-white border border-slate-200 rounded-2xl p-5 hover:border-teal-500 transition">
                                <span class="text-lg">🏬</span>
                                <p class="font-black mt-2 text-slate-900">Visit Our Showroom</p>
                                <p class="text-[11px] text-slate-400 mt-1">See &amp; feel the range before you decide.</p>
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Tab: Profile -->
                <div x-show="activeTab === 'profile'" class="space-y-6" x-cloak>
                    <h2 class="text-xl font-bold text-slate-800 border-b pb-4">My Profile</h2>
                    <p class="text-slate-500 text-sm">Update your contact information and passwords here.</p>
                </div>

                <!-- Tab: My Orders -->
                <div x-show="activeTab === 'orders'" class="space-y-6" x-cloak>
                    <h2 class="text-xl font-bold text-slate-800 border-b pb-4">My Orders</h2>
                    @if($orders->isEmpty())
                        <p class="text-slate-400 text-sm py-4">No orders placed yet.</p>
                    @else
                        <div class="space-y-4">
                            @foreach($orders as $ord)
                                <div class="border rounded-xl p-4 flex justify-between items-center">
                                    <div>
                                        <span class="font-bold text-slate-800 font-mono">{{ $ord->order_number }}</span>
                                        <span class="text-xs text-slate-400 block">{{ $ord->created_at->format('M d, Y') }}</span>
                                    </div>
                                    <span class="font-bold text-slate-900">₹{{ number_format($ord->total, 2) }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Tab: Showroom Visits -->
                <div x-show="activeTab === 'visits'" class="space-y-6" x-cloak>
                    <h2 class="text-xl font-bold text-slate-800 border-b pb-4">Showroom Visits</h2>
                    <p class="text-slate-500 text-sm">Manage scheduled showroom visit times.</p>
                </div>

                <!-- Tab: Address Book -->
                <div x-show="activeTab === 'addresses'" class="space-y-6" x-cloak>
                    <h2 class="text-xl font-bold text-slate-800 border-b pb-4">Address Book</h2>
                    <p class="text-slate-500 text-sm">Manage defaults and additional delivery site locations.</p>
                </div>

                <!-- Tab: Project Management -->
                <div x-show="activeTab === 'project'" class="space-y-6" x-cloak>
                    <h2 class="text-xl font-bold text-slate-800 border-b pb-4">Project Management</h2>
                    <p class="text-slate-500 text-sm">Track architectural project specs and documents here.</p>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
