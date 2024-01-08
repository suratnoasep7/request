<?php

namespace App\Http\Controllers;


use App\Models\Product;
use App\Models\Requests;
use App\Models\RequestsDetail;
use App\Models\Worker;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $limit = 10;
        $request = Requests::with('worker')->paginate($limit);
        $no = $limit * ($request->currentPage() - 1);

        return view('request.index', compact('request', 'no'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product = Product::all();

        $worker = Worker::all();

        return view('request.create', compact('product','worker'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'worker_id'         => 'required',
            'request_date'      => 'required'
        ]);
        $product_id = $request->input('product_id');
        $qty = $request->input('qty');
        $keterangan = $request->input('keterangan');
        $request = Requests::create([
            'worker_id'      => $request->input('worker_id'),
            'request_date'   => $request->input('request_date') . " " . date("H:i:s") 
        ]);

        for($count = 0; $count < count($product_id); $count++) {
            $data = array(
                'request_id' => $request->id,
                'product_id'  => $product_id[$count],
                'request_stock'  => $qty[$count],
                'description'  => $keterangan[$count],
            );
            RequestsDetail::create($data);
        }
        return redirect()->route('request.index')->with('message', 'Product has been created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $request = Requests::with('worker', 'requestsDetail')->find($id);

        return view('request.show', compact('request'));
    }

    public function search(Request $request)
    {
    	$worker = [];

        if($request->has('q')){
            $search = $request->q;
            $worker =Worker::with('department')
            		->where('name', 'LIKE', "%$search%")
            		->get();
        }
        return response()->json($worker);
    }

    public function searchProduct(Request $request)
    {
    	$worker = [];

        if($request->has('q')){
            $search = $request->q;
            $worker =Product::with('location','unit')
            		->where('name', 'LIKE', "%$search%")
            		->get();
        }
        return response()->json($worker);
    }
}
