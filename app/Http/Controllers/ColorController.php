<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Color;

use Illuminate\Support\Facades\Validator;

class ColorController extends Controller
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
        $colors = Color::all();
        return view('admin.color.index', ['colors' => $colors, 'colorActive' => true]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.color.create');
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
            'color' => ['required', 'string'],
        ]);
        $color = new Color($request->all());
        try{
            $color->save();
            return redirect('admin/color')->with('colorCreated', 'Your color has been successfully created.');
        }catch(\Exception $e){
            return back()->withErrors(['colorCreateError' => 'An error ocurred while creating your color.'])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Color $color)
    {
        try{
            $color->delete();
            return back()->with('colorDeleteSuccess', 'Your color has been successfully deleted');
        }catch(\Exception $e){
            return back()->withErrors(['colorDeleteError' => 'An error occured deleting your color']);
        }
    }
}
