<?php

namespace App\Http\Controllers\Items;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\URL;
class ItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('items.index.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('items.create.create');
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
                "item_price" => "required|numeric|max:1000000000",
                "item_description" => "nullable|string|max:2000",
                "img"=>"nullable|string|max:254"
            ],
            [
            ]
        );

        $item = new Item();
        $item->name = $request->name;
        $item->item_price = $request->item_price;
        $item->item_description = $request->item_description;

        if(!empty($request->img))
        {
            $item->img = $request->img;
        }
        else
        {
            $item->img = "img/item_default.jpg";
        }
        $item->save();

        $item->item_img = $item->img;

        return response()->json(["status" => "success", "message" => "Item successfully saved", "item" => $item]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('items.view.view',compact("id"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('items.edit.edit',compact("id"));
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
                "item_price" => "required|numeric|max:1000000000",
                "item_description" => "nullable|string|max:2000",
                "img"=>"nullable|string|max:254"
            ],
            [
            ]
        );

        $item = Item::findOrFail($id);
        $item->name = $request->name;
        $item->item_price = $request->item_price;
        $item->item_description = $request->item_description;

        if(!empty($request->img))
        {
            $item->img = $request->img;
        }
        $item->save();

        return response()->json(["status" => "success", "message" => "Item Successfully Updated",
        "url" => URL::route("items.index")
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
        $item_del = Item::where("id",$id)->delete();
        return response()->json(["status" => "success", "message" => "Item Successfully Deleted"]);
    }

    public function uploadFile(Request $request)
    {
        // return $request->all();
        // return $request->file('file');
        $request->validate(
            ["file" => "required|mimes:jpeg,bmp,gif,png,jpg,pdf"],
            [
                "file.mimes"=>"File must be an image of type: jpeg, bmp, gif, png, jpg",
                "file.required"=>"Image is required"
            ]
        );
        
        if ($request->hasFile("file")) {
            //Get the filename and extension
            $fileNameWithExt = $request->file("file")->getClientOriginalName();
            //Get just filename
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            //Get just extension
            $extension = $request->file("file")->getClientOriginalExtension();
            //filename to store
            $filenameToStore =  $filename . "_" . time() . "." . $extension;
            //Upload the file
            $path = $request->file("file")->storeAs(
                "img",
                $filenameToStore,
                ['disk' => 'public']
            );

            return response()->json([ "item_img" => 'img/' . $filenameToStore ]);
        }else{
            return  response()->json(["status"=>"error"]);
        }
    }

    public function paginate(Request $request)
    {
        $search_key = $request->search['value'] ?? '';

        $query = Item::select("id","name","item_price","item_description","created_at")
            ->orderBy("name", "ASC");
            
        if(!empty($search_key))
        {
            $query->where(function ($k) use ($search_key) {
                $k->where('name', 'like', '%'.$search_key.'%')
                    ->orWhere('item_description', 'like', '%'.$search_key.'%')
                    ;
            });
        }
    
        return Datatables::of(
            $query
        )
        
            ->editColumn('created_at', function (Item $item) {
                return date2sql($item->created_at);
            })
            ->editColumn('item_description', function (Item $item) {
                return truncate_string($item->item_description, 40);
            })
            ->addColumn('actions', function () {
                return null;
            })
            ->setRowId(function ($item) {
                return $item->id;
            })
            ->make(true);
    }

    public function json($id)
    {
        $item = Item::select('id','name','item_description','img as item_img','item_price')
        ->where('id',$id)
        ->firstOrFail($id);
        return response()->json(["item" => $item]);
    }


}
