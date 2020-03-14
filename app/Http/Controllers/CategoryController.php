<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Session\TokenMismatchException;
use DataTables;

class CategoryController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $category = Category::where('parent_id','0')->pluck('category_name','id')->toArray();
        return view('category.view_category_list', compact('category'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       $category = Category::where('parent_id','0')->pluck('category_name','id')->toArray();
         return view('category.add_category', compact('category')); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {       
       
         $this->validate($request, array(
            'category_name' => 'required',
            'parent_id' => 'required'
        ));

        $category = new Category();
        $category->category_name = $request->category_name;
        $category->parent_id = $request->parent_id;
        $category->is_deleted = 0;
        $category->save();

         return redirect('/category-list')->with('message', 'Category Added Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::where('parent_id','0')->pluck('category_name','id')->toArray();   
        $category_get = Category::where('id', $id)->first();
        return view('category.edit_category', compact('category_get','category'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         $this->validate($request, array(
            'category_name' => 'required',
            'parent_id' => 'required'
        ));

            $category = Category::where('id',$id)->first();
            $category->category_name = $request->category_name;
            $category->parent_id = $request->parent_id;
            $category->save();

            return redirect('category-list')->with('message', 'Successfully Category Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {    
        Category::find($id)->delete();
        return redirect('category-list')->with('message', 'Successfully Category Delete!');
    }

      /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function categoryDatatable(Request $request)
    {
         
        if ($request->ajax()) {
      
        $data = Category::select(['id','category_name','parent_id'])->orderBy('id', 'DESC')
        ->where('parent_id','!=','0')
        ->where('is_deleted','=','0')
        ->with('children')->newQuery();
        
         return Datatables::of($data)
                ->addIndexColumn()
                 ->filter(function ($instance) use ($request) {

                    $category_name = $request->category_name;
                    if ($category_name && !empty($category_name)) {
                        $instance->where(function ($query) use ($category_name) {
                            return $query->where('category_name','=', $category_name);
                        });
                    }

                    $parent_id = $request->parent_id;
                    if ($parent_id && !empty($parent_id)) {
                        $instance->where(function ($query) use ($parent_id) {
                            return $query->where('parent_id','=', $parent_id);
                        });
                    }

                
                })
                 ->editColumn('parent_id', function($row){
                    $parent_id = $row->children[0]->category_name;
                    return $parent_id;
                })
                ->addColumn('action', function($row){
                     $btn = '<a href="' . route('categoryEdit', $row->id) .'" class="btn btn-primary btn-flat">EDIT</a>
                     <a href="' . route('categoryDelete', $row->id) .'" class="btn btn-danger btn-flat">DELETE</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
          }
    }

   
}