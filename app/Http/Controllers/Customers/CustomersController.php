<?php

namespace App\Http\Controllers\Customers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Yajra\Datatables\Datatables;
class CustomersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('customers.index.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customers.create.create');
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
                "name" => "required|string|max:200",
                "phone" => "nullable|string|max:20",
                "email" => "nullable|string|email|max:100",
                "address" => "nullable|string:max:200",
            ],
            [
            ]
        );

        $customer = new Customer();
        $customer->name = $request->name;
        $customer->phone = $request->phone;
        $customer->email = $request->email;
        $customer->address = $request->address;

        $customer->save();

        return response()->json(["status" => "success", "message" => "Customer successfully saved", "customer" => $customer]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('customers.view.view',compact("id"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('customers.edit.edit',compact("id"));
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
        
        $request->validate(
            [
                "name" => "required|string|max:200",
                "phone" => "nullable|string|max:20",
                "email" => "nullable|string|email|max:100",
                "address" => "nullable|string:max:200",
            ],
            [
            ]
        );

        $customer = Customer::findOrFail($id);
        $customer->name = $request->name;
        $customer->phone = $request->phone;
        $customer->email = $request->email;
        $customer->address = $request->address;
        $customer->save();

        return response()->json(["status" => "success", "message" => "Customer Successfully Updated",
        "url" => URL::route("customers.index")
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer_del = Customer::where("id",$id)->delete();
        return response()->json(["status" => "success", "message" => "Customer Successfully Deleted"]);
        
    }

    public function paginate(Request $request)
    {
        $search_key = $request->search['value'] ?? '';

        $query = Customer::select("id","name","phone","email","address","created_at")
            ->orderBy("name", "ASC");
            
        if(!empty($search_key))
        {
            $query->where(function ($k) use ($search_key) {
                $k->where('name', 'like', '%'.$search_key.'%')
                    ->orWhere('phone', 'like', '%'.$search_key.'%')
                    ->orWhere('email', 'like', '%'.$search_key.'%')
                    ->orWhere('address', 'like', '%'.$search_key.'%')
                    ;
            });
        }
    
        return Datatables::of(
            $query
        )
        
            ->editColumn('created_at', function (Customer $customer) {
                return date2sql($customer->created_at);
            })
            ->editColumn('address', function (Customer $customer) {
                return truncate_string($customer->address, 40);
            })
            ->addColumn('actions', function () {
                return null;
            })
            ->setRowId(function ($customer) {
                return $customer->id;
            })
            ->make(true);
    }

    public function json($id)
    {
        $customer = Customer::select("id","name","phone","email","address")
        ->where('id',$id)
        ->firstOrFail();
        return response()->json(["customer" => $customer]);
    }
}
