{{-- Shared Add / Edit Product Modal --}}
<div id="productModal" class="fixed inset-0 bg-black/60 hidden z-50 flex items-start justify-center backdrop-blur-sm p-4 sm:p-6 overflow-y-auto">

    <div class="bg-white w-full max-w-lg rounded-xl shadow-2xl p-5 sm:p-7 relative my-auto">

        <div class="flex justify-between items-center mb-5 border-b pb-4">
            <h2 id="modalTitle" class="text-xl sm:text-2xl font-serif text-stone-900">Add New Product</h2>
            <button onclick="closeModal()" class="text-stone-400 hover:text-red-500 transition-colors">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <form id="productForm" action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            {{-- Hidden method field for PUT (edit mode) --}}
            <input type="hidden" id="formMethod" name="_method" value="POST">

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-stone-700 mb-1">Product Name</label>
                    <input type="text" id="fieldName" name="name" required
                        class="w-full border border-stone-300 rounded-lg p-2.5 focus:border-stone-900 focus:ring-1 focus:ring-stone-900 outline-none text-sm">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-stone-700 mb-1">Description</label>
                    <input type="text" id="fieldDescription" name="description" required
                        class="w-full border border-stone-300 rounded-lg p-2.5 focus:border-stone-900 focus:ring-1 focus:ring-stone-900 outline-none text-sm">
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-stone-700 mb-1">Size</label>
                        <input type="text" id="fieldSize" name="size" required
                            placeholder="e.g. S, M, L, XL"
                            class="w-full border border-stone-300 rounded-lg p-2.5 focus:border-stone-900 focus:ring-1 focus:ring-stone-900 outline-none text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-stone-700 mb-1">Color</label>
                        <input type="text" id="fieldColor" name="color"
                            placeholder="e.g. Deep Chocolate"
                            class="w-full border border-stone-300 rounded-lg p-2.5 focus:border-stone-900 focus:ring-1 focus:ring-stone-900 outline-none text-sm">
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-stone-700 mb-1">Price (Rp)</label>
                        <input type="number" id="fieldPrice" name="price" required
                            class="w-full border border-stone-300 rounded-lg p-2.5 focus:border-stone-900 focus:ring-1 focus:ring-stone-900 outline-none text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-stone-700 mb-1">Initial Stock</label>
                        <input type="number" id="fieldStock" name="stock" required
                            class="w-full border border-stone-300 rounded-lg p-2.5 focus:border-stone-900 focus:ring-1 focus:ring-stone-900 outline-none text-sm">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-stone-700 mb-1">Reserved Stock</label>
                    <input type="number" id="fieldReservedStock" name="reserved_stock"
                        class="w-full border border-stone-300 rounded-lg p-2.5 focus:border-stone-900 focus:ring-1 focus:ring-stone-900 outline-none text-sm">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-stone-700 mb-1">Product Image</label>
                    <p id="currentImageHint" class="text-xs text-stone-500 mb-1 hidden">Leave blank to keep the current image.</p>
                    <input type="file" id="fieldImage" name="image"
                        class="w-full border border-stone-300 rounded-lg p-2.5 focus:border-stone-900 focus:ring-1 focus:ring-stone-900 outline-none text-sm">
                </div>
            </div>

            <div class="mt-7 flex flex-col-reverse sm:flex-row justify-end gap-3">
                <button type="button" onclick="closeModal()"
                    class="w-full sm:w-auto px-5 py-2.5 text-sm font-bold text-stone-600 border border-stone-300 rounded-lg hover:bg-stone-50 transition-colors">
                    Cancel
                </button>
                <button type="submit" id="submitBtn"
                    class="w-full sm:w-auto px-5 py-2.5 text-sm font-bold text-white bg-stone-900 rounded-lg hover:bg-stone-700 transition-colors">
                    Save Product
                </button>
            </div>
        </form>

    </div>
</div>

@push('scripts')
<script>
    const storeUrl = "{{ route('admin.products.store') }}";

    function openModal() {
        // Reset to "Add" mode
        const form = document.getElementById('productForm');
        form.action = storeUrl;
        form.reset();
        document.getElementById('formMethod').value = 'POST';
        document.getElementById('modalTitle').textContent = 'Add New Product';
        document.getElementById('submitBtn').textContent = 'Save Product';
        document.getElementById('currentImageHint').classList.add('hidden');
        document.getElementById('fieldImage').required = true;
        document.getElementById('productModal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function openEditModal(product) {
        const form = document.getElementById('productForm');

        // Switch to "Edit" mode
        form.action = `/admin/products/${product.id}`;
        form.reset();
        document.getElementById('formMethod').value = 'PUT';
        document.getElementById('modalTitle').textContent = 'Edit Product';
        document.getElementById('submitBtn').textContent = 'Update Product';
        document.getElementById('currentImageHint').classList.remove('hidden');
        document.getElementById('fieldImage').required = false;

        // Populate fields
        document.getElementById('fieldName').value          = product.name          ?? '';
        document.getElementById('fieldDescription').value   = product.description   ?? '';
        document.getElementById('fieldSize').value          = product.size          ?? '';
        document.getElementById('fieldColor').value         = product.color         ?? '';
        document.getElementById('fieldPrice').value         = product.price         ?? '';
        document.getElementById('fieldStock').value         = product.stock         ?? '';
        document.getElementById('fieldReservedStock').value = product.reserved_stock ?? '';

        document.getElementById('productModal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeModal() {
        document.getElementById('productModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    window.addEventListener('click', function(event) {
        const modal = document.getElementById('productModal');
        if (event.target === modal) {
            closeModal();
        }
    });
</script>
@endpush