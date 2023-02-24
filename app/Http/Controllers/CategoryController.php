<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        return view('admin.category.index', ['categories' => $categories, 'categoryActive' => true]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string'],
        ]);
        $category = new Category($request->all());
        try{
            $category->save();
            return redirect('admin/category')->with('categoryCreated', 'Your category has been successfully created.');
        }catch(\Exception $e){
            return back()->withErrors(['categoryCreateError' => 'An error ocurred while creating your category.'])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        try{
            $category->delete();
            return back()->with('categoryDeleteSuccess', 'Your category has been successfully deleted');
        }catch(\Exception $e){
            return back()->withErrors(['categoryDeleteError' => 'An error occured deleting your category']);
        }
    }
}
