@extends('layouts.main')

@section('title', 'Detail Permintaan')

@section('content')
    <div class="card my-4">
        <div class="row g-0">
            <div class="col-lg-12">
                <div class="card-body">
                    <p>NIK : {{ $request->worker->id_worker }}</p>
                    <hr>
                    <p>Nama : {{ $request->worker->name }}</p>
                    <hr>
                    <p>Department : {{ $request->worker->department->name }}</p>
                    <hr>
                    <p>Tanggal : {{ date("d F Y", strtotime($request->request_date)) }}</p>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Barang</th>
                                <th scope="col">Lokasi</th>
                                <th scope="col">Stok</th>
                                <th scope="col">Qty</th>
                                <th scope="col">Satuan</th>
                                <th scope="col">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($request->requestsDetail as $requests)
                            
                                <tr>
                                    <th scope="row">{{ $loop->index + 1 }}</th>
                                    <td>{{ $requests->product->name }}</td>
                                    <td>{{ $requests->product->location->name }}</td>
                                    <td>{{ $requests->product->stock }}</td>
                                    <td>{{ $requests->request_stock }}</td>
                                    <td>{{ $requests->product->unit->name }}</td>
                                    <td>{{ $requests->description }}</td>
                                </tr>
                            @empty
                                <td colspan="7">Records not found</td>
                            @endforelse
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection