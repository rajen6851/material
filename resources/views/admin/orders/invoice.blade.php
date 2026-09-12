<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tax Invoice - {{ $order->order_number }} - Pristo Enterprises</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Playfair+Display:wght@700&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #171615;
            background-color: #f5f3ef;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        .font-mono-custom {
            font-family: 'Space Mono', monospace;
        }
        .font-serif-pristo {
            font-family: 'Playfair Display', Georgia, serif;
        }

        @media print {
            body {
                background: #ffffff !important;
                padding: 0 !important;
            }
            .no-print {
                display: none !important;
            }
            .invoice-container {
                border: none !important;
                box-shadow: none !important;
                width: 100% !important;
                max-width: 100% !important;
                padding: 0 !important;
                margin: 0 !important;
            }
            @page {
                size: A4;
                margin: 12mm 12mm 12mm 12mm;
            }
        }
    </style>
</head>
<body class="py-10 px-4 sm:px-6">

    <!-- Top Floating Actions Bar (Hidden in Print) -->
    <div class="max-w-4xl mx-auto mb-6 flex items-center justify-between no-print">
        <a href="{{ route('admin.orders.show', $order->id) }}" class="inline-flex items-center gap-2 text-xs font-bold text-slate-600 hover:text-slate-900 transition bg-white px-4 py-2.5 rounded-xl border border-slate-200 shadow-xs">
            <span>← Back to Order Management</span>
        </a>

        <div class="flex items-center gap-3">
            <button onclick="window.print()" class="bg-[#171615] hover:bg-[#c09b5a] text-white text-xs font-bold px-6 py-2.5 rounded-xl transition shadow-md flex items-center gap-2">
                <span>🖨️ Print / Save as PDF</span>
            </button>
        </div>
    </div>

    <!-- Invoice Paper Container (A4 Printable Layout) -->
    <div class="invoice-container max-w-4xl mx-auto bg-white border border-[#ded7cd] p-8 sm:p-12 shadow-md rounded-2xl">
        
        <!-- Header: Seller & Tax Invoice Title -->
        <div class="flex justify-between items-start border-b-2 border-[#171615] pb-6 gap-6">
            <div class="space-y-1.5 max-w-md">
                <div class="flex items-center gap-2.5 mb-2">
                    <img src="{{ asset('images/logo.jpeg') }}" alt="PRISTO Logo" class="h-10 w-auto object-contain rounded border border-slate-200">
                    <div>
                        <span class="font-serif-pristo text-2xl font-bold tracking-[0.15em] text-[#171615] leading-none block">PRISTO</span>
                        <span class="text-[9px] uppercase tracking-[0.25em] font-bold text-[#c09b5a] block">ENTERPRISES</span>
                    </div>
                </div>
                <p class="text-xs text-[#55504a] leading-tight font-medium">
                    Architectural Porcelain Slabs, Vitrified Surfaces &amp; Luxury Sanitaryware
                </p>
                <p class="text-[11px] text-[#78716c] leading-relaxed pt-1">
                    Central Distribution &amp; Experience Studio, Bangalore, Karnataka, India<br>
                    <strong>GSTIN:</strong> 29AAACP1234F1Z8 &bull; <strong>State Code:</strong> 29 (Karnataka)<br>
                    <strong>Email:</strong> pristoenterprises@gmail.com &bull; <strong>Phone:</strong> +91 63623 46660
                </p>
            </div>

            <div class="text-right space-y-2">
                <span class="inline-block bg-[#171615] text-[#f7f4ef] text-sm font-black px-4 py-1.5 uppercase tracking-widest rounded-md">
                    TAX INVOICE
                </span>
                <p class="text-[10px] text-[#78716c] uppercase tracking-wider font-bold">ORIGINAL FOR RECIPIENT</p>
                
                <div class="text-xs font-mono-custom space-y-0.5 pt-2">
                    <p><strong>Invoice No:</strong> <span class="text-[#171615] font-bold">PE-{{ $order->order_number }}</span></p>
                    <p><strong>Invoice Date:</strong> {{ $order->created_at->format('d/m/Y') }}</p>
                    <p><strong>Order Ref:</strong> {{ $order->order_number }}</p>
                    <p><strong>Place of Supply:</strong> 29 - Karnataka</p>
                </div>
            </div>
        </div>

        <!-- Bill To / Ship To Grid -->
        <div class="grid grid-cols-2 gap-8 py-6 border-b border-slate-200 text-xs">
            <div class="space-y-1.5">
                <span class="text-[10px] uppercase font-bold tracking-wider text-[#c09b5a] block">BILLED TO (CUSTOMER):</span>
                <p class="font-extrabold text-sm text-[#171615]">{{ $order->name }}</p>
                <p class="text-[#55504a]"><strong>Phone:</strong> {{ $order->phone }}</p>
                <p class="text-[#55504a]"><strong>Email:</strong> {{ $order->email }}</p>
                @if($order->gst_number)
                    <p class="text-[#171615] font-bold mt-1 bg-slate-50 p-1.5 rounded inline-block border border-slate-200 font-mono-custom">
                        Customer GSTIN: {{ $order->gst_number }}
                    </p>
                @endif
                <p class="text-[11px] text-[#78716c]">
                    Category: {{ $order->user && $order->user->isProfessional() ? 'B2B Trade Commercial' : 'B2C Homeowner Retail' }}
                </p>
            </div>

            <div class="space-y-1.5">
                <span class="text-[10px] uppercase font-bold tracking-wider text-[#c09b5a] block">SHIPPED TO (DELIVERY DESTINATION):</span>
                <div class="text-[#55504a] font-mono-custom leading-relaxed whitespace-pre-line bg-slate-50/70 p-2.5 rounded-lg border border-slate-100 text-[11px]">
                    {{ $order->shipping_address }}
                </div>
                <p class="text-[11px] text-[#78716c] pt-1">
                    <strong>Payment Mode:</strong> {{ strtoupper($order->payment_method) }} &bull; 
                    <span class="{{ $order->payment_status === 'paid' ? 'text-emerald-700 font-bold' : 'text-amber-700 font-bold' }}">
                        {{ strtoupper($order->payment_status) }}
                    </span>
                </p>
            </div>
        </div>

        <!-- Line Items Table -->
        <div class="py-6">
            <table class="w-full text-xs text-left border border-slate-200 border-collapse">
                <thead>
                    <tr class="bg-[#171615] text-white text-[10px] font-bold uppercase tracking-wider">
                        <th class="py-2.5 px-3 w-10 text-center border-r border-slate-700">#</th>
                        <th class="py-2.5 px-3 border-r border-slate-700">Description of Goods / Vitrified Surface</th>
                        <th class="py-2.5 px-3 w-20 text-center border-r border-slate-700">HSN</th>
                        <th class="py-2.5 px-3 w-14 text-center border-r border-slate-700">Qty</th>
                        <th class="py-2.5 px-3 w-24 text-right border-r border-slate-700">Unit Rate (₹)</th>
                        <th class="py-2.5 px-3 w-24 text-right border-r border-slate-700">GST (18%)</th>
                        <th class="py-2.5 px-3 w-28 text-right">Total (₹)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 font-medium">
                    @foreach($order->items as $idx => $item)
                        @php
                            $hsnCode = '6907'; // Glazed vitrified tiles
                            if (stripos($item->product->name ?? '', 'wc') !== false || stripos($item->product->name ?? '', 'basin') !== false || stripos($item->product->name ?? '', 'tub') !== false) {
                                $hsnCode = '6910'; // Ceramic sanitaryware
                            } elseif (stripos($item->product->name ?? '', 'mixer') !== false || stripos($item->product->name ?? '', 'faucet') !== false || stripos($item->product->name ?? '', 'shower') !== false) {
                                $hsnCode = '8481'; // Taps, valves & sanitary fittings
                            }
                        @endphp
                        <tr class="hover:bg-slate-50/50">
                            <td class="py-3 px-3 text-center border-r border-slate-200 text-[#78716c]">{{ $idx + 1 }}</td>
                            <td class="py-3 px-3 border-r border-slate-200">
                                <span class="font-extrabold text-[#171615] block">{{ $item->product->name ?? 'Product #' . $item->product_id }}</span>
                                @if($item->product && $item->product->sku)
                                    <span class="text-[10px] text-[#78716c] font-mono-custom block">Code: {{ $item->product->sku }}</span>
                                @endif
                            </td>
                            <td class="py-3 px-3 text-center border-r border-slate-200 font-mono-custom text-[#78716c]">{{ $hsnCode }}</td>
                            <td class="py-3 px-3 text-center border-r border-slate-200 font-bold text-[#171615]">{{ $item->quantity }}</td>
                            <td class="py-3 px-3 text-right border-r border-slate-200 font-mono-custom">₹{{ number_format($item->price, 2) }}</td>
                            <td class="py-3 px-3 text-right border-r border-slate-200 font-mono-custom text-[#78716c]">₹{{ number_format($item->tax, 2) }}</td>
                            <td class="py-3 px-3 text-right font-black font-mono-custom text-[#171615]">₹{{ number_format($item->total, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Calculations Summary & Terms -->
        <div class="grid grid-cols-12 gap-6 pt-2 border-t-2 border-slate-200 items-start">
            
            <!-- Left 7 cols: Notes, Delivery Disclaimer & Bank Details -->
            <div class="col-span-7 space-y-4 text-xs">
                
                <!-- Shipping Charges Policy Clause -->
                <div class="bg-[#faf8f5] border border-[#ded7cd] p-3 rounded-xl space-y-1">
                    <span class="text-[10px] uppercase font-bold text-[#c09b5a] block">Freight &amp; Delivery Policy</span>
                    <p class="text-[11px] text-[#55504a] leading-relaxed">
                        Consignments are heavy architectural vitrified loads. Transit and pallet freight charges are calculated <strong>at actuals based on weight and distance</strong> to ground-level curbside.
                    </p>
                </div>

                <!-- Terms & Conditions -->
                <div class="space-y-1 text-[10px] text-[#78716c] leading-relaxed">
                    <span class="font-bold text-[#171615] uppercase tracking-wider block">Terms of Sale:</span>
                    <ol class="list-decimal list-inside space-y-0.5">
                        <li>Natural tone and shade nuances are inherent to kiln-fired ceramics. Verify box batch numbers before fixing.</li>
                        <li>Transit damage must be photographed and reported within 48 hours of delivery prior to any cutting or adhesive fixing.</li>
                        <li>Subject to Bangalore (Bengaluru) jurisdiction only.</li>
                    </ol>
                </div>

                <!-- Bank NEFT/RTGS Coordinates -->
                <div class="p-3 bg-slate-50 border border-slate-200 rounded-xl text-[10px] space-y-0.5 font-mono-custom text-[#55504a]">
                    <p class="font-bold text-[#171615]">Bank Transfer Details:</p>
                    <p>A/C Name: Pristo Enterprises &bull; Bank: HDFC Bank Ltd</p>
                    <p>A/C No: 50200084920194 &bull; IFSC: HDFC0000123 &bull; Branch: Indiranagar, Bangalore</p>
                </div>
            </div>

            <!-- Right 5 cols: Totals -->
            <div class="col-span-5 space-y-2 text-xs">
                <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 space-y-2 font-mono-custom">
                    <div class="flex justify-between items-center text-[#55504a]">
                        <span>Subtotal:</span>
                        <span>₹{{ number_format($order->subtotal, 2) }}</span>
                    </div>

                    @if($order->discount > 0)
                        <div class="flex justify-between items-center text-emerald-700">
                            <span>Discount:</span>
                            <span>- ₹{{ number_format($order->discount, 2) }}</span>
                        </div>
                    @endif

                    <!-- Tax breakdown CGST + SGST (9% each in intra-state KA) -->
                    @php
                        $halfTax = $order->tax / 2;
                    @endphp
                    <div class="flex justify-between items-center text-[#78716c] text-[11px] pt-1 border-t border-slate-200">
                        <span>CGST (9%):</span>
                        <span>₹{{ number_format($halfTax, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center text-[#78716c] text-[11px]">
                        <span>SGST (9%):</span>
                        <span>₹{{ number_format($halfTax, 2) }}</span>
                    </div>

                    <div class="flex justify-between items-center text-amber-800 text-[11px] pt-1 border-t border-slate-200">
                        <span>Freight / Shipping:</span>
                        <span class="font-bold text-[10px]">Charges Applicable</span>
                    </div>

                    <div class="flex justify-between items-center text-sm font-black text-[#171615] pt-2 border-t-2 border-[#171615]">
                        <span class="font-sans font-bold">Grand Total (INR):</span>
                        <span class="text-base text-[#c09b5a]">₹{{ number_format($order->total, 2) }}</span>
                    </div>
                </div>

                <!-- Signatory Box -->
                <div class="pt-8 text-center space-y-1">
                    <div class="border-b border-slate-300 w-40 mx-auto"></div>
                    <p class="text-[10px] font-bold text-[#171615] uppercase tracking-wider">For Pristo Enterprises</p>
                    <p class="text-[9px] text-[#78716c]">Authorised Signatory</p>
                </div>
            </div>

        </div>

    </div>

</body>
</html>
