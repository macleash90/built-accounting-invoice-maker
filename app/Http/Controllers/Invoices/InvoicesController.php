<?php

namespace App\Http\Controllers\Invoices;

use App\Http\Controllers\Controller;
use App\Models\InvoiceItem;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Yajra\Datatables\Datatables;

class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers =  Customer::select("id", "name")
            ->get();
        return view('invoices.index.index',compact("customers"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('invoices.create.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $request->validate(
            [
                "selected_customer" => "required",
                "sale_note" => "nullable|string|max:240",
                "invoice_date" => "required",
                "grandTotal" => "required",
                "item_invoices" => "required",
            ],
            [
            ]
        );

        DB::beginTransaction();
        $invoice = new Invoice();
        $invoice->total_amount = $request->grandTotal;
        $invoice->invoice_date = $request->invoice_date;
        $invoice->created_by = Auth::id();
        $invoice->customer_id = $request->selected_customer['id'];
        $invoice->save();

        foreach ($request->item_invoices as $key => $item_sale) {
            # code...
            $invoiceDetail = new InvoiceItem();
            $invoiceDetail->invoice_id = $invoice->id;
            $invoiceDetail->item_id = $item_sale["id"];
            $invoiceDetail->item_qty = $item_sale["qty"];
            $invoiceDetail->invoice_date = $invoice->invoice_date;
            $invoiceDetail->item_price_per_unit = $item_sale["item_price"];
            $invoiceDetail->item_name = $item_sale["name"];
            $invoiceDetail->sub_total_price = to_2dp($invoiceDetail->item_price_per_unit * $invoiceDetail->item_qty);
            $invoiceDetail->save();
        }

        DB::commit();

        $url = URL::route("invoices.show", $invoice->invoice_number);

        return response()->json(["status" => "success", "message" => "Invoice Successfully Saved", "url" => $url]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoice = Invoice::where("invoice_number", $id)
        ->with('invoice_items')->firstOrFail();

        return view('invoices.show.show',compact("invoice"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();

        $invoice_del = Invoice::where("invoice_number",$id)->firstOrFail();

        InvoiceItem::where("id",$invoice_del->id)->delete();

        $invoice_del->delete();
        
        DB::commit();

        return response()->json(["status" => "success", "message" => "Invoice Successfully Deleted"]);
    }

    public function createJson()
    {

        $items = Item::select("id", "name", "item_price", "img as item_img", "item_description")
            ->orderBy("id", "ASC")
            ->get();
        $customer = Customer::firstOrCreate(
            ['name' => 'Guest'],
            ['phone' => "No phone #"]
        );
        $customers =  Customer::select("id", "name", "phone")
            ->get();
        return response()->json(["items" => $items, "customers" => $customers, "customer" => $customer]);
    }

    public function paginate(Request $request)
    {
        $search_key = $request->search['value'] ?? '';

        $query = Invoice::select("id","invoice_number","total_amount","invoice_date","customer_id","created_at")
        ->with('customer:id,name')
        ->orderBy("id", "ASC");
            
        if (!empty($request->start_date)) {
            $query = $query->whereDate("invoice_date", ">=", $request->start_date);
        }

        if (!empty($request->end_date)) {
            $query = $query->whereDate("invoice_date", "<=", $request->end_date);
        }

        if (!empty($request->customers)) {
            $query = $query->whereIn("customer_id", $request->customers);
        }

        if(!empty($search_key))
        {
            $query->where(function ($k) use ($search_key) {
                $k->where('invoice_number', 'like', '%'.$search_key.'%')
                    ->orWhere('total_amount', 'like', '%'.$search_key.'%')
                    ->orWhere('invoice_date', 'like', '%'.$search_key.'%')
                    ;
            });
        }
    
        return Datatables::of(
            $query
        )
        
            ->editColumn('created_at', function (Invoice $invoice) {
                return date2sql($invoice->created_at);
            })
            ->addColumn('customer_name', function (Invoice $invoice) {
                return $invoice->customer->name;
            })
            ->addColumn('actions', function () {
                return null;
            })
            ->setRowId(function ($invoice) {
                return $invoice->invoice_number;
            })
            ->make(true);
    }
}
