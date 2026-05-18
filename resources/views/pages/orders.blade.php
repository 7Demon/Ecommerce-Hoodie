@extends('layouts.app')
@section('title', 'Orders')
@section('content')
<div class="flex flex-col min-w-0 overflow-hidden bg-background p-5 sm:p-8">
    <div class="flex justify-between items-end mb-10">
        <div>
            <h1 class="font-headline-md text-headline-md text-primary mb-2">Orders</h1>
            <p class="font-body-md text-body-md text-on-surface-variant">Manage and track customer orders.</p>
        </div>
        <div class="flex gap-4">
            <button class="flex items-center gap-2 px-4 py-2 border border-outline-variant rounded text-on-surface hover:border-primary hover:text-primary transition-colors font-label-md text-label-md">
                <span class="material-symbols-outlined text-sm">filter_list</span>
                Filter
            </button>
            <button class="flex items-center gap-2 px-4 py-2 border border-outline-variant rounded text-on-surface hover:border-primary hover:text-primary transition-colors font-label-md text-label-md">
                <span class="material-symbols-outlined text-sm">sort</span>
                Sort
            </button>
        </div>
    </div>
    
    <div class="bg-surface rounded-xl shadow-[0_20px_40px_rgba(62,39,35,0.05)] flex-1 flex flex-col overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-outline-variant/30 text-on-surface-variant font-label-sm text-label-sm uppercase tracking-wider bg-surface-container-low/50">
                        <th class="py-5 px-6 font-semibold">Order ID</th>
                        <th class="py-5 px-6 font-semibold">Date</th>
                        <th class="py-5 px-6 font-semibold">Customer Name</th>
                        <th class="py-5 px-6 font-semibold">Category</th>
                        <th class="py-5 px-6 font-semibold">Status</th>
                        <th class="py-5 px-6 font-semibold text-right">Total Amount</th>
                        <th class="py-5 px-6 font-semibold text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="font-body-md text-body-md text-on-surface divide-y divide-outline-variant/20">
                    <tr class="hover:bg-surface-container-low/30 transition-colors group">
                        <td class="py-4 px-6 font-medium">#ORD-7429</td>
                        <td class="py-4 px-6 text-on-surface-variant">Oct 24, 2023</td>
                        <td class="py-4 px-6 flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-secondary-container text-primary flex items-center justify-center font-label-md text-label-md">AT</div>
                            Alexander Thorne
                        </td>
                        <td class="py-4 px-6 text-on-surface-variant">Outerwear</td>
                        <td class="py-4 px-6">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-[#e8e0d5] text-[#6b5b4e]">Pending</span>
                        </td>
                        <td class="py-4 px-6 text-right font-medium">$370.00</td>
                        <td class="py-4 px-6 text-center">
                            <button class="text-on-surface-variant hover:text-primary p-2 rounded-full hover:bg-surface-container transition-colors" title="View Details">
                                <span class="material-symbols-outlined text-xl">visibility</span>
                            </button>
                        </td>
                    </tr>
                    
                    <tr class="hover:bg-surface-container-low/30 transition-colors group">
                        <td class="py-4 px-6 font-medium">#ORD-7428</td>
                        <td class="py-4 px-6 text-on-surface-variant">Oct 23, 2023</td>
                        <td class="py-4 px-6 flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-secondary-container text-primary flex items-center justify-center font-label-md text-label-md">ER</div>
                            Elena Rostova
                        </td>
                        <td class="py-4 px-6 text-on-surface-variant">Knitwear</td>
                        <td class="py-4 px-6">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-[#e6dfd1] text-[#7a6b4b]">Processing</span>
                        </td>
                        <td class="py-4 px-6 text-right font-medium">$1,250.00</td>
                        <td class="py-4 px-6 text-center">
                            <button class="text-on-surface-variant hover:text-primary p-2 rounded-full hover:bg-surface-container transition-colors" title="View Details">
                                <span class="material-symbols-outlined text-xl">visibility</span>
                            </button>
                        </td>
                    </tr>
                    
                    <tr class="hover:bg-surface-container-low/30 transition-colors group">
                        <td class="py-4 px-6 font-medium">#ORD-7427</td>
                        <td class="py-4 px-6 text-on-surface-variant">Oct 22, 2023</td>
                        <td class="py-4 px-6 flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-secondary-container text-primary flex items-center justify-center font-label-md text-label-md">MK</div>
                            Marcus Sterling
                        </td>
                        <td class="py-4 px-6 text-on-surface-variant">Accessories</td>
                        <td class="py-4 px-6">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-[#d8ddd3] text-[#4a5c41]">Completed</span>
                        </td>
                        <td class="py-4 px-6 text-right font-medium">$890.00</td>
                        <td class="py-4 px-6 text-center">
                            <button class="text-on-surface-variant hover:text-primary p-2 rounded-full hover:bg-surface-container transition-colors" title="View Details">
                                <span class="material-symbols-outlined text-xl">visibility</span>
                            </button>
                        </td>
                    </tr>
                    
                    <tr class="hover:bg-surface-container-low/30 transition-colors group">
                        <td class="py-4 px-6 font-medium">#ORD-7426</td>
                        <td class="py-4 px-6 text-on-surface-variant">Oct 21, 2023</td>
                        <td class="py-4 px-6 flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-secondary-container text-primary flex items-center justify-center font-label-md text-label-md">SC</div>
                            Sarah Chen
                        </td>
                        <td class="py-4 px-6 text-on-surface-variant">Basics</td>
                        <td class="py-4 px-6">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-surface-variant text-on-surface-variant">Cancelled</span>
                        </td>
                        <td class="py-4 px-6 text-right font-medium">$450.00</td>
                        <td class="py-4 px-6 text-center">
                            <button class="text-on-surface-variant hover:text-primary p-2 rounded-full hover:bg-surface-container transition-colors" title="View Details">
                                <span class="material-symbols-outlined text-xl">visibility</span>
                            </button>
                        </td>
                    </tr>
                    
                    <tr class="hover:bg-surface-container-low/30 transition-colors group">
                        <td class="py-4 px-6 font-medium">#ORD-7425</td>
                        <td class="py-4 px-6 text-on-surface-variant">Oct 20, 2023</td>
                        <td class="py-4 px-6 flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-secondary-container text-primary flex items-center justify-center font-label-md text-label-md">JD</div>
                            James Donovan
                        </td>
                        <td class="py-4 px-6 text-on-surface-variant">Outerwear</td>
                        <td class="py-4 px-6">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-[#d8ddd3] text-[#4a5c41]">Completed</span>
                        </td>
                        <td class="py-4 px-6 text-right font-medium">$2,100.00</td>
                        <td class="py-4 px-6 text-center">
                            <button class="text-on-surface-variant hover:text-primary p-2 rounded-full hover:bg-surface-container transition-colors" title="View Details">
                                <span class="material-symbols-outlined text-xl">visibility</span>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div class="mt-auto border-t border-outline-variant/30 py-4 px-6 flex items-center justify-between bg-surface-container-lowest">
            <span class="font-body-md text-body-md text-on-surface-variant">Showing 1 to 10 of 124 entries</span>
            <div class="flex gap-2">
                <button class="px-3 py-1 border border-outline-variant/50 rounded text-on-surface-variant hover:border-primary hover:text-primary transition-colors font-label-md text-label-md disabled:opacity-50 disabled:cursor-not-allowed">Prev</button>
                <button class="px-3 py-1 bg-primary text-on-primary rounded font-label-md text-label-md">1</button>
                <button class="px-3 py-1 border border-outline-variant/50 rounded text-on-surface-variant hover:border-primary hover:text-primary transition-colors font-label-md text-label-md">2</button>
                <button class="px-3 py-1 border border-outline-variant/50 rounded text-on-surface-variant hover:border-primary hover:text-primary transition-colors font-label-md text-label-md">3</button>
                <span class="px-2 py-1 text-on-surface-variant">...</span>
                <button class="px-3 py-1 border border-outline-variant/50 rounded text-on-surface-variant hover:border-primary hover:text-primary transition-colors font-label-md text-label-md">13</button>
                <button class="px-3 py-1 border border-outline-variant/50 rounded text-on-surface-variant hover:border-primary hover:text-primary transition-colors font-label-md text-label-md">Next</button>
            </div>
        </div>
    </div>
</div>
@endsection
