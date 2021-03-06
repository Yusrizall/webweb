<div class="container-fluid">
    <div class="row">
        <div class="col-6 pr-2">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <h5 class="my-auto">List Produk</h5>
                        <a class="btn btn-primary ml-auto" href="/products">Master Produk</a>
                    </div>
                    <hr>
                    <table class="table table-bordered m-0">
                        <thead class="thead-light">
                            <tr>
                                <th>Gambar</th>
                                <th>Nama</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th class="fit">Jumlah Pembelian</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($products) > 0)
                            @foreach ($products as $product)
                            <tr>
                                <td class="fit">
                                    @if (strlen($product->image_url) > 0)
                                    <img src="{{ asset('storage/' . $product->image_url) }}" alt="">
                                    @else
                                    -
                                    @endif
                                </td>
                                <td>{{ $product->name }}</td>
                                <td class="text-right">{{ number_format($product->price) }}</td>
                                <td>{{ $product->quantity }}</td>
                                <td>
                                    <input class="form-control" type="number" min="0" max="{{ $product->quantity + (isset($tempCart[$product->id]) && $tempCart[$product->id] ? $tempCart[$product->id] : 0) }}" wire:model="tempCart.{{ $product->id }}" wire:change="saveCart({{ $product }})">
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td class="text-center" colspan="5">Tidak ada produk yang siap dijual</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-6 pl-1">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <h5 class="my-auto">Keranjang</h5>
                        <button class="btn btn-danger ml-auto" wire:click="clearCart()">Kosongi Keranjang</button>
                    </div>
                    <hr>
                    <table class="table table-bordered m-0">
                        <thead class="thead-light">
                            <tr>
                                <th>Nama</th>
                                <th>Kuantitas</th>
                                <th>Harga</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($cart) > 0)
                            @foreach ($cart as $item)
                            <tr>
                                <td>{{ $item->product->name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td class="text-right">{{ number_format($item->price) }}</td>
                                <td class="text-right">{{ number_format($item->quantity * $item->price) }}</td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td class="text-center" colspan="4">Keranjang Kosong</td>
                            </tr>
                            @endif
                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="h4 text-right" colspan="3">Total Pembelian :</th>
                                <th class="h4 text-right">{{ number_format($total) }}</th>
                            </tr>
                        </tfoot>
                    </table>
                    <hr>
                    <form wire:submit.prevent="checkout">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group row">
                                    <label class="col-sm-4 m-auto">Nama Pembeli</label>
                                    <div class="col-sm-8">
                                        <input class="form-control" type="text" wire:model="customerName">
                                        @error('customerName') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group row">
                                    <label class="col-sm-4 m-auto">Pembayaran</label>
                                    <div class="col-sm-8">
                                        <input class="form-control text-right" type="text" wire:model="payment">
                                        @error('payment') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h4 class="text-right">
                            Kembalian : {{ $payment >= $total ? number_format($change) : 'Pembayaran Kurang' }}
                        </h4>
                        <hr>
                        <div class="d-flex">
                            <button class="btn btn-success ml-auto" type="submit">Checkout</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>