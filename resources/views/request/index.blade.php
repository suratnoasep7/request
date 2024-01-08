@extends('layouts.main')

@section('title', 'Permintaan')

@section('content')
    <div id="flash-data" data-flashdata="{{ session('message') }}"></div>

    <div class="d-flex my-3 justify-content-between">
        <a href="{{ route('request.create') }}" class="btn btn-primary">Tambah Permintaan</a>
    </div>

    <div class="table-responsive" id="table-container">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">NIK</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Departemen</th>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($request as $requests)
                    <tr>
                        <th scope="row">{{ ++$no }}</th>
                        <td>{{ $requests->worker->id_worker }}</td>
                        <td>{{ $requests->worker->name }}</td>
                        <td>{{ $requests->worker->department->name }}</td>
                        <td>{{ date("d F Y", strtotime($requests->request_date)) }}</td>
                        <td>
                            <a href="{{ route('request.show', $requests->id) }}" class="btn btn-primary btn-sm">Detail</a>
                        </td>
                    </tr>
                @empty
                    <td colspan="5">Records not found</td>
                @endforelse
            </tbody>
        </table>
        {{ $request->links() }}
    </div>
@endsection

@push('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="{{ asset('js/main.js') }}"></script>
@endpush