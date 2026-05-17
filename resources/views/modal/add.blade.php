<div id="productModal" class="fixed inset-0 bg-black/60 hidden z-50 flex items-center justify-center backdrop-blur-sm transition-all">
    
    <div class="bg-white w-full max-w-lg rounded-xl shadow-2xl p-6 relative">
        
        <div class="flex justify-between items-center mb-6 border-b pb-4">
            <h2 class="text-2xl font-serif text-stone-900">Add New Product</h2>
            <button onclick="closeModal()" class="text-stone-400 hover:text-red-500 transition-colors">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-stone-700 mb-1">Product Name</label>
                    <input type="text" name="name" required class="w-full border border-stone-300 rounded-lg p-2.5 focus:border-stone-900 focus:ring-1 focus:ring-stone-900 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-stone-700 mb-1">Description</label>
                    <input type="text" name="description" required class="w-full border border-stone-300 rounded-lg p-2.5 focus:border-stone-900 focus:ring-1 focus:ring-stone-900 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-stone-700 mb-1">Size</label>
                    <input type="text" name="size" required class="w-full border border-stone-300 rounded-lg p-2.5 focus:border-stone-900 focus:ring-1 focus:ring-stone-900 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-stone-700 mb-1">Price (Rp)</label>
                    <input type="number" name="price" required class="w-full border border-stone-300 rounded-lg p-2.5 focus:border-stone-900 focus:ring-1 focus:ring-stone-900 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-stone-700 mb-1">Initial Stock</label>
                    <input type="number" name="stock" required class="w-full border border-stone-300 rounded-lg p-2.5 focus:border-stone-900 focus:ring-1 focus:ring-stone-900 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-stone-700 mb-1">Reserved Stock</label>
                    <input type="number" name="reserved_stock"  class="w-full border border-stone-300 rounded-lg p-2.5 focus:border-stone-900 focus:ring-1 focus:ring-stone-900 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-stone-700 mb-1">Product Image</label>
                    <input type="file" name="image" required class="w-full border border-stone-300 rounded-lg p-2.5 focus:border-stone-900 focus:ring-1 focus:ring-stone-900 outline-none">
                </div>
            </div>

            <div class="mt-8 flex justify-end gap-3">
                <button type="button" onclick="closeModal()" class="px-5 py-2.5 text-sm font-bold text-stone-600 border border-stone-300 rounded-lg hover:bg-stone-50">
                    Cancel
                </button>
                <button type="submit" class="px-5 py-2.5 text-sm font-bold text-white bg-stone-900 rounded-lg hover:bg-stone-700">
                    Save Product
                </button>
            </div>
        </form>

    </div>
</div>
@push('scripts')
<script>
    function openModal() {
        document.getElementById('productModal').classList.remove('hidden');
    }
    function closeModal() {
        document.getElementById('productModal').classList.add('hidden');
    }
    window.onclick = function(event) {
        const modal = document.getElementById('productModal');
        if (event.target === modal) {
            closeModal();
        }
    }
</script>
@endpush