<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Color;
use App\Models\Tag;
use App\Models\Image;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Response;

use Carbon\Carbon;

use DB;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('displayImage');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        return view('admin.product.index', ['products' => $products, 'productActive' => true, 'categories' => Category::all(), 'colors' => Color::all(), 'tags' => Tag::all()]);
    }
    
    public function fetchAdminProducts(){
        $products = Product::all();
        foreach ($products as $product) {
            $product['category'] = Category::find($product->idCategory);
            $product['images'] = $product->images;
            $product['tags'] = $product->tags;
            $product['colors'] = $product->colors;
        }
        return response()->json(['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = Tag::all();
        $colors = Color::all();
        $categories = Category::all();
        return view('admin.product.create', ['tags' => $tags, 'colors' => $colors, 'categories' => $categories]);
    }
    
    public function displayImage($name, $name2)
    {
        if (!Storage::exists($name . '/' . $name2)) {
            return Response::make('File no found.', 404);
        }

        $file = Storage::get($name . '/' . $name2);
        $type = Storage::mimeType($name . '/' . $name2);
        $response = Response::make($file, 200)->header("Content-Type", $type);

        return $response;
    }
    
    public function deleteImage(Image $image){
        Storage::delete($image->path);
        try{
            $image->delete();
            return back();
        }catch(\Exception $e){
            return back()->withErrors(['imageDeleteError' => 'An error occured deleting your image']);
        }
    }
    
    private function saveImages($product, $image){
        $extension = explode('/', mime_content_type($image))[1];
        $name = Carbon::now()->format('YmdHisv') . '.' . $extension;
        $path = 'imagesProduct-' . $product->id;
        
        $completePath = Storage::disk('local')->putFileAs(
            $path,
            $image,
            $name
        );
        $storageImage = new Image();
        $storageImage->path = $completePath;
        $storageImage->idProduct = $product->id;
        $storageImage->save();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return response()->json(json_decode($request->colors[0]));
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'min:8', 'max:20'],
            'price' => ['required', 'integer'],
            'description' => ['required', 'string', 'min:15'],
        ]);
        if ($validator->fails()) {
            response()->json(['error' => 'The data entered is not valid']);
        }
        
        if(!Category::where('id', $request->idCategory)->exists()){
           return response()->json(['error' => 'The selected category is invalid']);
        }
        
        $product = new Product($request->all());
        try{
            $product->save();
            if($request->tags){
                foreach ($request->tags as $tag) {
                    $tag = json_decode($tag);
                    if($tag->value == "1"){
                        DB::table('product_tag')->insert(['idProduct' => $product->id, 'idTag' => $tag->id]);
                    }
                }
            }
            if($request->colors){
                foreach ($request->colors as $color) {
                    $color = json_decode($color);
                    if($color->value == "1"){
                        DB::table('product_color')->insert(['idProduct' => $product->id, 'idColor' => $color->id]);
                    }
                }
            }
            
            foreach ($request->images as $index => $image){
                // return response()->json(['test' => $image]);
                $this->saveImages($product, $image);
            }
            return response()->json(['success' => 'Your product has been successfully created.']);
        }catch(\Exception $e){
            return response()->json(['error' => 'An error ocurred while creating your product.']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $productTags = [];
        foreach ($product->tags as $tag) {
            $productTags[] = $tag->id;
        }
        
        $productColors = [];
        foreach ($product->colors as $color) {
            $productColors[] = $color->id;
        }
        $tags = Tag::all();
        $colors = Color::all();
        $categories = Category::all();
        return view('admin.product.edit', 
                    [
                        'product' => $product, 
                        'categories' => $categories, 
                        'tags' => $tags, 
                        'colors' => $colors,
                        'productTags' => $productTags,
                        'productColors' => $productColors
                    ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'min:8', 'max:20'],
            'price' => ['required', 'integer'],
            'description' => ['required', 'string', 'min:15'],
        ]);
        if ($validator->fails()) {
            return back()
            ->withErrors($validator);
        }
        
        if(!Category::where('id', $request->idCategory)->exists()){
           return back()->withErrors(['category' => 'The selected category is invalid']);
        }
        
        try{
            $product->update($request->all());
            if($request->tags){
                foreach ($request->tags as $tag => $active) {
                    if($active == "1" && !DB::table('product_tag')->where('idProduct', '=', $product->id)->where('idTag', '=', $tag)->exists()){
                        $test = DB::table('product_tag')->insert(['idProduct' => $product->id, 'idTag' => $tag]);
                    }else if($active == "0"){
                        DB::table('product_tag')->where('idProduct', '=', $product->id)->where('idTag', '=', $tag)->delete();
                    }
                }
            }
            if($request->colors){
                foreach ($request->colors as $color => $active) {
                    if($active == "1" && !DB::table('product_color')->where('idProduct', '=', $product->id)->where('idColor', '=', $color)->exists()){
                        DB::table('product_color')->insert(['idProduct' => $product->id, 'idColor' => $color]);
                    }else if($active == "0"){
                        DB::table('product_color')->where('idProduct', '=', $product->id)->where('idColor', '=', $color)->delete();
                    }
                }
            }
            
            if($request->images){
                foreach ($request->images as $index => $image){
                    $rules['images.' . $index] = 'required|mimes:png,jpeg,jpg|max:2048';
                    $validator = Validator::make($request->all(), $rules);
                    if ($validator->fails()) {
                        return back()
                        ->withErrors(['images' => 'The images failed to upload.']);
                    }else{
                        $this->saveImages($product, $image);
                    }
                }
            }
            return redirect('admin/product')->with('productUpdateSuccess', 'Your product has been successfully updated.');
        }catch(\Exception $e){
            return back()->withErrors(['productUpdateError' => 'An error ocurred while updating your product.'])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        Storage::deleteDirectory('imagesProduct-' . $product->id);
        try{
            $product->delete();
            return response()->json(['success' => 'Your product has been successfully deleted']);
        }catch(\Exception $e){
            return response()->json(['error' => 'An error occured deleting your product']);
        }
    }
}
