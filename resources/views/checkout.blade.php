@extends('layouts.app')

@section('content')
<div class="container">

    <div class="card">
        <div class="card-body">
            <h4>Pembelian Berhasil</h4>
            <hr>
            <table class="mb-3">
                <tr>
                    <th>Nama Customer</th>
                    <th>:</th>
                    <td>{{ $transaction->customer_name }}</td>
                </tr>
                <tr>
                    <th>Tanggal Transaksi</th>
                    <th>:</th>
                    <td>{{ $transaction->created_at }}</td>
                </tr>
            </table>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama Item</th>
                        <th>Quantity</th>
                        <th>Harga</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transaction->details as $detail)
                    <tr>
                        <td>{{ $detail->product->name }}</td>
                        <td>{{ $detail->quantity }}</td>
                        <td>{{ number_format($detail->price) }}</td>
                        <td>{{ number_format($detail->quantity * $detail->price) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="h4">
                        <td class="text-right" colspan="3">Total Pembelian</td>
                        <td>{{ number_format($transaction->total) }}</td>
                    </tr>
                    <tr>
                        <td class="text-right" colspan="3">Total Pembayaran</td>
                        <td>{{ number_format($transaction->payment) }}</td>
                    </tr>
                    <tr>
                        <td class="text-right" colspan="3">Total Kembalian</td>
                        <td>{{ number_format($transaction->payment - $transaction->total) }}</td>
                    </tr>
                </tfoot>
            </table>
            <hr>
            <div class="d-flex">
                <a class="btn btn-primary ml-auto" href="/">Buat Transaksi Baru</a>
            </div>
        </div>
    </div>
</div>
@endsection