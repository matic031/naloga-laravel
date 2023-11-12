<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;

class ProductTable extends Component
{
    protected $listeners = ['refreshProductTable' => 'refreshTable'];


    public $products, $editProductId, $title, $description, $price;
    public $showDeleteConfirmation = false;

    public $showCreateModal = false; // For showing create modal
    public $newTitle, $newDescription, $newPrice; // New product data
    public $successMessage = '';

    public function render()
    {
        $this->products = Product::all();

        return view('livewire.product-table');
    }

    public function openCreateModal()
    {
        $this->resetCreateForm();
        $this->showCreateModal = true;
    }

    public function closeCreateModal()
    {
        $this->showCreateModal = false;
    }

    public function createProduct()
    {
        $this->validate([
            'newTitle' => 'required',
            'newDescription' => 'required',
            'newPrice' => 'required|numeric|between:0,9999.99'
        ]);

        Product::create([
            'title' => $this->newTitle,
            'description' => $this->newDescription,
            'price' => $this->newPrice
        ]);

        $this->successMessage = 'Product created successfully.';

        // Resetting the form and clearing errors
        $this->resetErrorBag();
        $this->resetCreateForm();
        $this->resetValidation();

        $this->refreshTable();
    }


    private function resetCreateForm()
    {
        $this->newTitle = '';
        $this->newDescription = '';
        $this->newPrice = '';
    }

    public function deleteProduct($productId)
    {
        $product = Product::find($productId);
    
        if ($product) {
            $product->delete();
            $this->showDeleteConfirmation = true;
            $this->refreshTable();
        }
    }

    public function closeDeleteConfirmation()
    {
        $this->showDeleteConfirmation = false; // Set to false to close the modal
    }

    public function editProduct($productId)
{
    $product = Product::find($productId);

    if ($product) {
        $this->editProductId = $product->id;
        $this->title = $product->title;
        $this->description = $product->description;
        $this->price = $product->price;
    }
}

public function updateProduct()
{
    $this->validate([
        'title' => 'required',
        'description' => 'required',
        'price' => 'required|numeric|between:0,9999.99'
    ]);

    if ($this->editProductId) {
        $product = Product::find($this->editProductId);
        if ($product) {
            $product->update([
                'title' => $this->title,
                'description' => $this->description,
                'price' => $this->price
            ]);

            $this->editProductId = null;
            $this->title = '';
            $this->description = '';
            $this->price = '';

            $this->refreshTable();
        }
    }
}
    public function refreshTable()
    {
        $this->products = Product::all();
    }
}