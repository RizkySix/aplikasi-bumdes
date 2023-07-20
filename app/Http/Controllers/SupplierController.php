<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\Models\Barang;
use App\Models\Pembelian;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Supplier $supplier)
    {
        $suppliers = $supplier::orderBy('created_at' , 'DESC');
       
        if(request()->search){
            $suppliers = $supplier::where('nama_supplier' , 'like' , '%' . request()->search . '%');
        }
       return view('dashboard.supplier.view_supplier', [
            "title" => "Data Supplier",
            "suppliers" => $suppliers->paginate(10)->withQueryString()
       ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.supplier.create_supplier' , [
            "title" => "Tambah Data Supplier"
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSupplierRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSupplierRequest $request)
    {
        $validatedData = $request->validate([
            'nama_supplier' => 'required|min:3',
            'pemilik' => 'required|min:3',
            'alamat' => 'required|min:5',
            'no_hp' => 'required|min:11|max:17'
        ]);

        Supplier::create($validatedData);
        return redirect('/suppliers')->with('success' , 'Supplier Baru Berhasil Ditambah');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit(Supplier $supplier)
    {
        return view('dashboard.supplier.view_edit', [
            "title" => "Edit Data Supplier",
            "supplier" => $supplier
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSupplierRequest  $request
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSupplierRequest $request, Supplier $supplier)
    {
        $validatedData = $request->validate([
            'nama_supplier' => 'required|min:3',
            'pemilik' => 'required|min:3',
            'alamat' => 'required|min:5',
            'no_hp' => 'required|min:11|max:17'
        ]);

        Supplier::where('id', $supplier->id)->update($validatedData);
        return redirect('/suppliers')->with('success' , 'Data Supplier Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier $supplier)
    {

    Barang::where('supplier_id', $supplier->id)->update(['supplier_id' => 0]);
    Pembelian::where('supplier_id', $supplier->id)->update(['supplier_id' => 0]);
       Supplier::destroy($supplier->id);
       return redirect('/suppliers')->with('success' , 'Data Supplier Berhasil Dihapus');
    }
}
