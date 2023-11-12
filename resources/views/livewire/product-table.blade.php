

<div>
    <x-layouts.app>

    @livewireStyles
@livewireScripts

{{-- Edit modal --------------------- --}}
 @if($editProductId)
    <div class="modal-backdrop">
        <div class="edit-modal bg-gray-700 text-white p-6 rounded-lg">
            <div class="modal-header mb-4">
                <h2 class="text-xl font-bold">Edit Product</h2>
            </div>
            <div class="modal-body mb-4">
                <input type="text" wire:model="title" placeholder="Title" class="modal-input mb-2">
                <input type="text" wire:model="description" placeholder="Description" class="modal-input mb-2">
                <input type="number" wire:model="price" placeholder="Price" class="modal-input mb-2">
            </div>
            <div class="modal-footer">
                <button wire:click="updateProduct" class="btn-update text-white font-bold py-3 px-6 rounded">Update</button>
            </div>
        </div>
    </div>
@endif

{{-- Delete modal --------------------- --}}
@if($showDeleteConfirmation)
    <div class="modal-backdrop">
        <div class="delete-modal bg-gray-700 text-white p-6 rounded-lg">
            <div class="modal-body mb-4">
                <p>Product deleted successfully.</p>
            </div>
            <div class="modal-footer">
                <button wire:click="closeDeleteConfirmation" class="btn-close text-white font-bold py-3 px-6 rounded">OK</button>
            </div>
        </div>
    </div>
@endif

{{-- Create modal --------------------- --}}
@if($showCreateModal)
    <div class="modal-backdrop">
        <div class="create-modal bg-gray-700 text-white p-6 rounded-lg">
            <div class="modal-header mb-4">
                <h2 class="text-xl font-bold">Create New Product</h2>
            </div>
            <div class="modal-body mb-4">
                {{-- Error Messages --}}
                @if($errors->any() && empty($successMessage))
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $error)
                            {{ $error }}<br>
                        @endforeach
                    </div>
                @endif

                {{-- Success Message --}}
                @if($successMessage)
                    <div id="successMessage" class="alert alert-success">
                        {{ $successMessage }}
                    </div>
                    <script>
                        setTimeout(function () {
                            var successMessage = document.getElementById('successMessage');
                            if (successMessage) {
                                successMessage.style.display = 'none';
                            }
                        }, 3000);
                    </script>
                @endif

                <input type="text" wire:model="newTitle" placeholder="Title" class="modal-input mb-2">
                <input type="text" wire:model="newDescription" placeholder="Description" class="modal-input mb-2">
                <input type="number" wire:model="newPrice" placeholder="Price" class="modal-input mb-2">
            </div>
            <div class="modal-footer">
                <button wire:click="createProduct" class="btn-createnew text-white font-bold py-3 px-6 rounded">Create</button>
                <button wire:click="closeCreateModal" class="btn-close text-white font-bold py-3 px-6 rounded">Close</button>
            </div>
        </div>
    </div>
@endif


        <!-- Table and Other Content -->
       <div class="mb-4 flex justify-between items-center bg-gray-800 text-white p-4">
            <div class="spacer"></div>
            <div class="heading-container">
                <h1 class="text-3xl font-bold text-center">Product Table</h1>
                 <button wire:click="openCreateModal" class="btn-create text-white font-bold py-2 px-4 rounded">
                 Create New Product
                </button>
            </div>
            
</div>

        <table class="table bg-gray-800 text-white">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th class="action-column">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr x-data="{ isOpen: false }" class="border-t border-gray-700">

                        <td class="py-2 px-4">{{ $product->title }}</td>

                        <td class="py-2 px-4">{{ $product->description }}</td>

                        <td class="py-2 px-4 text-center price">
                            {{ $product->price }}
                        </td>

                        <td class="py-2 space-x-2 text-center action">
                        <div class="button-container">
                            <button x-on:click="isOpen = true" wire:click="editProduct({{ $product->id }})"
                                class="btn-edit text-white font-bold py-1 px-2 rounded">
                                Edit
                            </button>
                            <button wire:click="deleteProduct({{ $product->id }})" class="btn-delete text-white font-bold py-1 px-2 rounded">
                                Delete
                            </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </x-layouts.app>
</div>
