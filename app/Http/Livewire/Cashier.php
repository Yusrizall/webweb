<?php

namespace App\Http\Livewire;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Cashier extends Component
{
    public $products,
        $tempCart,
        $cart,
        $total,
        $customerName,
        $payment,
        $change;

    protected $rules = [
        'customerName' => 'required',
        'payment' => 'required',
    ];

    public function saveCart(Product $product)
    {
        $cart = Cart::query()->where('product_id', $product->id)->first();

        $quantity = $this->tempCart[$product->id];

        if ($cart) {
            if (($product->quantity + $cart->quantity) - $quantity < 0) {
                $this->tempCart[$product->id] = ($product->quantity + $cart->quantity);
                return;
            }

            if ($quantity > 0) {
                $cart->quantity = $quantity;

                $cart->save();
            } else {
                $this->tempCart[$product->id] = 0;
                $cart->delete();
            }
        } else {
            if ($product->quantity - $quantity < 0) {
                $this->tempCart[$product->id] = 0;
                return;
            }

            if ($quantity > 0) {
                $cart = new Cart();

                $cart->product_id = $product->id;
                $cart->quantity = $quantity;
                $cart->price = $product->price;

                $cart->save();
            } else {
                $this->tempCart[$product->id] = 0;
            }
        }
    }

    public function checkout()
    {
        DB::beginTransaction();

        $transaction = new Transaction();

        $transaction->customer_name = $this->customerName;
        $transaction->total = $this->total;
        $transaction->payment = $this->payment;

        $transaction->save();

        $cart = Cart::all();

        foreach ($cart as $item) {
            TransactionDetail::query()->create([
                'transaction_id' => $transaction->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->price,
            ]);
        }

        Cart::query()->delete();

        $this->customerName = null;
        $this->payment = null;
        $this->change = null;
        $this->tempCart = null;

        DB::commit();

        return redirect('/checkout/' . $transaction->id);
    }

    public function mount()
    {
        $this->change = 0;
    }

    public function render()
    {
        $this->products = Product::all();
        $this->cart = Cart::with('product')->get();
        $this->total = 0;

        foreach ($this->cart as $cart) {
            $this->tempCart[$cart->product_id] = $this->tempCart[$cart->product_id] ?? $cart->quantity;
            $this->total += $cart->quantity * $cart->price;
        }

        if ($this->payment > $this->total)
            $this->change = $this->payment - $this->total;
        else
            $this->change = 0;

        return view('livewire.cashier');
    }
}
