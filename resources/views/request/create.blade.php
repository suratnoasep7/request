@extends('layouts.main')

@section('title', 'Permintaan')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card my-4 shadow">
                <h5 class="card-header">Permintaan</h5>
                <div class="card-body">
                    <form action="{{ route('request.store') }}" method="POST" enctype="multipart/form-data" class="row g-3">
                        @csrf
                        <div class="col-md-4">
                            <label for="nik" class="form-label">NIK</label>
                            <select name="worker_id" id="worker_id" class="form-control"></select>
                            @error('worker_id')
                                <div id="worker_id" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" name="name" class="form-control " id="name" value="" disabled>
                        </div>
                        <div class="col-md-4">
                            <label for="department" class="form-label">Departemen</label>
                            <input type="text" name="department" class="form-control " id="department" value="" disabled>
                        </div>
                        <div class="col-md-4">
                            <label for="department" class="form-label">Tanggal</label>
                            <input type="date" name="request_date" class="form-control " id="department" value="">
                        </div>
                        <hr>
                        <div class="col-md-12">
                            <div id="row" class="row mb-3">
                                <div class="col-md-2 mb-3">
                                    <label for="barang" class="form-label">Barang</label>
                                    <select name="product_id[]" id="product_id" class="form-control"></select>
                                </div>
                                <div class="col-md-2">
                                    <label for="lokasi" class="form-label">Lokasi</label>
                                    <input type="text" name="lokasi" class="form-control " id="lokasi" value="" disabled>
                                </div>
                                <div class="col-md-2">
                                    <label for="stok" class="form-label">Stok</label>
                                    <input type="text" name="stok" class="form-control " id="stok" value="" disabled>
                                </div>
                                <div class="col-md-2">
                                    <label for="qty" class="form-label">Qty</label>
                                    <input type="number" name="qty[]" class="form-control " id="qty" value="">
                                </div>
                                <div class="col-md-2">
                                    <label for="satuan" class="form-label">Satuan</label>
                                    <input type="text" name="satuan" class="form-control " id="satuan" value="" disabled>
                                </div>
                                <div class="col-md-2">
                                    <label for="keterangan" class="form-label">Keterangan</label>
                                    <input type="text" name="keterangan[]" class="form-control " id="keterangan" value="">
                                </div>
                                <div class="col-md-12">
                                    <button class="btn btn-danger" id="DeleteRow" type="button" style="float: right;">
                                        Delete
                                    </button>
                                </div>
                            </div>
    
                            <div id="newinput"></div>
                            <div class="col-md-12">
                                <button id="rowAdder" type="button" class="btn btn-primary">
                                    Add
                                </button>
                            </div>
                            
                        </div>
                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="{{ route('request.index') }}" class="btn btn-danger">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function(){
            $('#worker_id').select2({
                placeholder: 'Pilih NIK',
                ajax: {
                    url: '/request-search',
                    dataType: 'json',
                    delay: 250,
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    text: item.id_worker + " " + item.name,
                                    id: item.id,
                                    name: item.name,
                                    department: item.department.name
                                }
                            })
                        };
                    },
                    cache: true
                }
            });

            $('#product_id').select2({
                placeholder: 'Pilih Product',
                ajax: {
                    url: '/request-product-search',
                    dataType: 'json',
                    delay: 250,
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    text: item.id_product + " " + item.name,
                                    id: item.id,
                                    stock: item.stock,
                                    location: item.location.name,
                                    unit: item.unit.name
                                }
                            })
                        };
                    },
                    cache: true
                }
            });

            $('#worker_id').on('select2:select', function (e) {
                var data = e.params.data;
                $('#name').val(data.name);
                $('#department').val(data.department);
            });
            $('#product_id').on('select2:select', function (e) {
                var data = e.params.data;
                $('#lokasi').val(data.location);
                $('#stok').val(data.stock);
                $('#satuan').val(data.unit);
            });
            var x = 1;
            $("#rowAdder").click(function () {
                newRowAdd =
                '<div id="row" class="row mb-3">'+
                    '<div class="col-md-2 mb-3">'+
                        '<label for="barang" class="form-label">Barang</label>'+
                        '<select name="product_id[]" id="product_id'+x+'" class="form-control"></select>'+
                    '</div>'+
                    '<div class="col-md-2">'+
                        '<label for="lokasi" class="form-label">Lokasi</label>'+
                        '<input type="text" name="lokasi" class="form-control " id="lokasi'+x+'" value="" disabled>'+
                    '</div>'+
                    '<div class="col-md-2">'+
                        '<label for="stok" class="form-label">Stok</label>'+
                        '<input type="text" name="stok" class="form-control " id="stok'+x+'" value="" disabled>'+
                    '</div>'+
                    '<div class="col-md-2">'+
                        '<label for="qty" class="form-label">Qty</label>'+
                        '<input type="number" name="qty[]" class="form-control " id="qty'+x+'" value="">'+
                    '</div>'+
                    '<div class="col-md-2">'+
                        '<label for="satuan" class="form-label">Satuan</label>'+
                        '<input type="text" name="satuan" class="form-control " id="satuan'+x+'" value="" disabled>'+
                    '</div>'+
                    '<div class="col-md-2">'+
                        '<label for="keterangan" class="form-label">Keterangan</label>'+
                        '<input type="text" name="keterangan[]" class="form-control " id="keterangan'+x+'" value="">'+
                    '</div>'+
                    '<div class="col-md-12">'+
                        '<button class="btn btn-danger" id="DeleteRow" type="button" style="float: right;">'+
                            'Delete'+
                        '</button>'+
                    '</div>'+
                '</div>';
                
                $('#newinput').append(newRowAdd);
                $('#product_id' + x).select2({
                    placeholder: 'Pilih Product',
                    ajax: {
                        url: '/request-product-search',
                        dataType: 'json',
                        delay: 250,
                        processResults: function (data) {
                            return {
                                results: $.map(data, function (item) {
                                    return {
                                        text: item.id_product + " " + item.name,
                                        id: item.id,
                                        stock: item.stock,
                                        location: item.location.name,
                                        unit: item.unit.name
                                    }
                                })
                            };
                        },
                        cache: true
                    }
                });
                $('#product_id' + x).on('select2:select', function (e) {
                    var data = e.params.data;
                    var number = x - 1;
                    $('#lokasi' + number).val(data.location);
                    $('#stok' + number).val(data.stock);
                    $('#satuan' + number).val(data.unit);
                });
                x++;
            });
            $("body").on("click", "#DeleteRow", function () {
                $(this).parents("#row").remove();
                x--;
            });
        });
    </script>
@endpush