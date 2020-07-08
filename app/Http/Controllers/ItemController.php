<?php

namespace App\Http\Controllers;

use App\Item;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Auth;

class ItemController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function getItem($id){
      return response()->json(Item::find($id));
    }

    // public function getItem($id){
    //   // return response()->json(Item::find($id));
    //   $item = Item::where('items.id', $id)
    //       ->leftJoin('users', 'users.id', '=', 'items.user_id')
    //       ->leftJoin('categories', 'categories.id', '=', 'items.category_id')
    //       ->leftJoin('statuses', 'statuses.id', '=', 'items.status_id')
    //       ->select(
    //           'items.*',
    //           'users.firstname as user_firstname',
    //           'users.lastname as user_lastname',
    //           'categories.name as category_name',
    //           'statuses.name as status_name',
    //   )
    //   ->first();
    //   return response()->json($item);
    //
    // }

    public function getItems(Request $getItemsRequest){

      $this->validate($getItemsRequest, [
        'status_id' => 'integer|exists:statuses,id',
        'category_id' => 'integer|exists:categories,id',
       ]);

      $categoryId = $getItemsRequest->input('category_id');
      $statusId = $getItemsRequest->input('status_id');

      $filters = array();
      $filtersString = '';

      if($categoryId){
        $filters[] = "category_id = $categoryId";
      }
      if($statusId){
        $filters[] = "status_id = $statusId";
      }

      if(count($filters)){
        $filtersString = " WHERE ".implode(" AND ", $filters)." ";
      }

      $users = DB::select("SELECT * FROM items ".$filtersString);

      return response()->json($users);
    }

    public function addItem(Request $addRequest){
        $this->validate($addRequest, [
          'name' => 'required',
          'description' => '',
          'datetime' => 'required|date|after:now|date_format:Y-m-d H:i',
          'category_id' => 'required|integer|exists:categories,id'
         ]);
        $data = $addRequest->all();
        $data["user_id"] = Auth::user()->id;

        if(Item::create($data)){
            return response()->json(['status' => 'success']);
        }
        return response()->json(['status' => 'failed']);
    }

    public function updateItem(Request $updateRequest, $id){
        $this->validate($updateRequest, [
          'name' => 'filled',
          'description' => 'filled',
          'datetime' => 'filled|date|after:now|date_format:Y-m-d H:i',
          'category_id' => 'filled|integer|exists:categories,id'
         ]);

        $item = Item::find($id);
        if($item->fill($updateRequest->all())->save()){
           return response()->json(['status' => 'success']);
        }
        return response()->json(['status' => 'failed']);
    }

    public function deleteItem($id){
        if(Item::destroy($id)){
           return response()->json(['status' => 'success']);
        }
        return response()->json(['status' => 'failed']);
    }

    //
}
