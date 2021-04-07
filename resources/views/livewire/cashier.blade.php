<div class="container-fluid">
    <div class="row">
        <div class="col-5 pr-2">
            <div class="card">
                <div class="card-body">
                    <h5>List Produk</h5>
                    <hr>
                    <table class="table table-bordered m-0">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Jumlah Pembelian</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->price }}</td>
                                <td>{{ $product->quantity }}</td>
                                <td>
                                    <input class="form-control" type="number" min="0" max="{{ $product->quantity + (isset($tempCart[$product->id]) && $tempCart[$product->id] ? $tempCart[$product->id] : 0) }}" wire:model="tempCart.{{ $product->id }}" wire:change="saveCart({{ $product }})">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-7 pl-1">
            <div class="card">
                <div class="card-body">
                    <h5>Keranjang</h5>
                    <hr>
                    <table class="table table-bordered m-0">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Kuantitas</th>
                                <th>Harga</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cart as $item)
                            <tr>
                                <td>{{ $item->product->name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ $item->price }}</td>
                                <td>{{ $item->quantity * $item->price }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="h4 text-right" colspan="3">Total Pembelian :</th>
                                <th class="h4">{{ $total }}</th>
                            </tr>
                        </tfoot>
                    </table>
                    <hr>
                    <form wire:submit.prevent="checkout">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label class="col-sm-4 m-auto">Nama Pembeli</label>
                                    <div class="col-sm-8">
                                        <input class="form-control" type="text" wire:model="customerName" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label class="col-sm-4 m-auto">Pembayaran</label>
                                    <div class="col-sm-8">
                                        <input class="form-control" type="text" wire:model="payment" wire:input="$emit('calculate')" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h4 class="text-right">
                            Kembalian : {{ $payment >= $total ? $change : 'Pembayaran Kurang' }}
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