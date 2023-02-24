<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;

use Illuminate\Support\Facades\Validator;

class TagController extends Controller
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
        $categories = Tag::all();
        return view('admin.tag.index', ['tags' => $categories, 'tagActive' => true]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.tag.create');
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
        $category = new Tag($request->all());
        try{
            $category->save();
            return redirect('admin/tag')->with('tagCreated', 'Your tag has been successfully created.');
        }catch(\Exception $e){
            return back()->withErrors(['tagCreateError' => 'An error ocurred while creating your tag.'])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        try{
            $tag->delete();
            return back()->with('tagDeleteSuccess', 'Your tag has been successfully deleted');
        }catch(\Exception $e){
            return back()->withErrors(['tagDeleteError' => 'An error occured deleting your tag']);
        }
    }
}
