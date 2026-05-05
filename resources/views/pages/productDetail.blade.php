@extends('layouts.app')
@section('title', 'product detail')
@section('content')
<main class="flex-grow pt-[140px] pb-section-gap px-gutter w-full max-w-container-max mx-auto">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-gutter">
        <!-- Left: Image Gallery (Editorial Stack) -->
        <div class="lg:col-span-7 flex flex-col gap-4">
            <div class="w-full aspect-[4/5] bg-surface-container-high relative overflow-hidden">
                <img alt="Model wearing premium oversized chocolate brown hoodie in a minimalist concrete studio setting, soft natural lighting" class="w-full h-full object-cover" data-alt="Model wearing premium oversized chocolate brown hoodie in a minimalist concrete studio setting, soft natural lighting" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBaQ2DQxZHrBjo960OqxDPnO3hjQWKMpS0stz9-sQCe9ZPbMPYqiCNfo5mGjLsOU5hzvkL1iC6OavW7dv2tp-0bO_pVgpP-IkxWYxVuLt0zBX0vPNplhnDTN80BtSw1lXqBvqpB19IXdwRcVOJR44FwQdZqsxqVd1kYMw_tKl2PPqYpMH6puBq8qUHJV9P_nUg-MgBGcIvHr4cGGj4AB3Vyl2igBqulOLosbJpGZTUVfmB6J1Pa5Ini_Ypc8F1b40bJapU0w3WX4ts"/>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="w-full aspect-square bg-surface-container-high relative overflow-hidden">
                    <img alt="Close up texture shot of heavy weight organic cotton fabric in deep chocolate brown" class="w-full h-full object-cover" data-alt="Close up texture shot of heavy weight organic cotton fabric in deep chocolate brown" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDH-yFfBG17YpNB30dUbEDjug1oXmdPHz0_rdMaCv5vo7QAcbJpYpabVlPWgoQI72jwdxCsn0F8v8xXMu3N68EX76ngkFy7bkzRbnL5OnXf6TefIEK_en4y47jAOfvCuyynn3mXTBQA9qjqJDjDQ-pDRB05Kn7fyy55VVVSs55gzbwJJslfEtW3uI8jyY4XOYcBeNKkilWpuYS_7-OJhqKhT9Uiz2hwuqvT_yIagyop4lUGuqY7QMP63upUFOLLcOnsBu-7djQBZbE"/>
                </div>
                <div class="w-full aspect-square bg-surface-container-high relative overflow-hidden">
                    <img alt="Back view of model wearing oversized chocolate brown hoodie showing relaxed drop shoulder fit" class="w-full h-full object-cover" data-alt="Back view of model wearing oversized chocolate brown hoodie showing relaxed drop shoulder fit" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBd_7fhVbJ2MCkTsDMaiaTPvWkmgfKmhEkfmXVbZTB8FhtQTGCQvMsaBvhVIUvj-TCALwc-R6sqHnRQe539ualqnTKLwNiH7Vvyvxcbm22Th45I6TwD6QffHzAnOhuIajr-lYKSsJ3Xy9b_Wk7CqxmX7JxSfFwDnRZtH9154Lar7Coe41UyKYqFbLbSbWQZTxihI_FcKB-_aV7xc2sJzA0NYKHPar6rYiuweOTmiasKQj_Bvl_MPAmFstzg2xjVZx_9dRUUHRpDzZQ"/>
                </div>
            </div>
        </div>
        <!-- Right: Product Details (Sticky) -->
        <div class="lg:col-span-5 relative">
            <div class="sticky top-[140px] flex flex-col gap-10">
                <!-- Header -->
                <div class="flex flex-col gap-2">
                    <h1 class="font-display-lg text-display-lg text-on-background">Essential Oversized Hoodie</h1>
                    <p class="font-body-lg text-body-lg text-on-surface-variant">$185.00</p>
                </div>
                <!-- Color Selector -->
                <div class="flex flex-col gap-4">
                    <span class="font-label-sm text-label-sm text-on-surface-variant">COLOR: DEEP CHOCOLATE</span>
                    <div class="flex gap-4">
                        <!-- Active Swatch -->
                        <button aria-label="Deep Chocolate" class="w-8 h-8 rounded-full bg-primary ring-1 ring-offset-2 ring-offset-background ring-primary transition-all"></button>
                        <!-- Inactive Swatches -->
                        <button aria-label="Warm Stone" class="w-8 h-8 rounded-full bg-secondary-fixed-dim border border-outline-variant hover:border-outline transition-all"></button>
                        <button aria-label="Midnight" class="w-8 h-8 rounded-full bg-tertiary border border-outline-variant hover:border-outline transition-all"></button>
                    </div>
                </div>
                <!-- Size Selector -->
                <div class="flex flex-col gap-4">
                    <div class="flex justify-between items-center">
                        <span class="font-label-sm text-label-sm text-on-surface-variant">SIZE</span>
                        <button class="font-label-sm text-label-sm text-outline hover:text-primary underline decoration-outline-variant underline-offset-4 transition-colors">SIZE GUIDE</button>
                    </div>
                    <div class="grid grid-cols-4 gap-3">
                        <button class="py-3 border border-outline-variant rounded-lg font-label-md text-label-md text-on-surface hover:border-outline hover:bg-surface-container transition-all">S</button>
                        <!-- Active Size -->
                        <button class="py-3 bg-primary border border-primary rounded-lg font-label-md text-label-md text-on-primary shadow-sm transition-all">M</button>
                        <button class="py-3 border border-outline-variant rounded-lg font-label-md text-label-md text-on-surface hover:border-outline hover:bg-surface-container transition-all">L</button>
                        <button class="py-3 border border-outline-variant rounded-lg font-label-md text-label-md text-on-surface hover:border-outline hover:bg-surface-container transition-all">XL</button>
                    </div>
                </div>
                <!-- Action -->
                <div class="pt-4">
                    <button class="w-full py-4 px-8 bg-primary text-on-primary font-label-md text-label-md rounded-DEFAULT hover:opacity-90 transition-opacity flex justify-center items-center gap-2">
                    ADD TO CART</button>
                    <p class="font-body-md text-body-md text-center text-on-surface-variant mt-4 text-sm">Free shipping and returns on all domestic orders.</p>
                </div>
                <!-- Details Accordion/List -->
                <div class="mt-4 border-t border-outline-variant pt-8 flex flex-col gap-8">
                    <div class="flex flex-col gap-3">
                        <h3 class="font-label-md text-label-md text-on-background">THE DETAILS</h3>
                        <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed">
                                                        Crafted from custom-milled 400GSM organic cotton, this piece offers substantial weight and exceptional softness. The dropped shoulder, relaxed body, and double-lined hood create a structural silhouette without feeling restrictive. Designed for quiet confidence.
                                                    </p>
                    </div>
                    <div class="flex flex-col gap-3">
                        <h3 class="font-label-md text-label-md text-on-background">FABRIC &amp; CARE</h3>
                        <ul class="font-body-md text-body-md text-on-surface-variant list-disc pl-5 space-y-2">
                            <li>100% Organic Cotton (GOTS Certified)</li>
                            <li>Heavyweight 400GSM French Terry</li>
                            <li>Machine wash cold with like colors</li>
                            <li>Lay flat to dry to preserve structure</li>
                            <li>Made responsibly in Portugal</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>