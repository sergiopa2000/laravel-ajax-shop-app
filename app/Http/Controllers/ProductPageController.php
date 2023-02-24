<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Tag;
use App\Models\Category;
use App\Models\Color;
use App\Models\Image;

use Illuminate\Support\Facades\DB;
use App\Classes\QueryHelper;

class ProductPageController extends Controller
{
    const DEFAULT_SORT_BY = 'product.name';
    const DEFAULT_SORT_TYPE = 'asc';
    const ITEMS_PER_PAGE = 12;
    
    function getData(Request $request){
                // Possible sort by
        $sortByParams = [
            'product.name' => '1',
            'product.price' => '2',
            'product.created_at' => '3',
        ];
        
        // Possible sort types
        $sortTypeParams = [
            'asc' => '1',
            'desc' => '2',
        ];
        
        // Possible price filters
        $priceFilterParams = [
            '0&50' => '1',
            '50&100' => '2',
            '100&150' => '3',
            '150&200' => '4',
            '200' => '5',
        ];
        
        // Get possible tags
        $tagFilterParams = [];
        $tags = Tag::all();
        $cont = 1;
        foreach($tags as $tag){
            $tagFilterParams[$tag->name] = $cont;
            $cont++;
        }
        
        // Get possible categories
        $categoryFilterParams = [];
        $categories = Category::all();
        $cont = 1;
        foreach($categories as $category){
            $categoryFilterParams[$category->name] = $cont;
            $cont++;
        }
        
        // Get possible colors
        $colorFilterParams = [];
        $colors = Color::all();
        $cont = 1;
        foreach($colors as $color){
            $colorFilterParams[$color->name] = $cont;
            $cont++;
        }
        
        // Get serach query
        $search = $request->input('q');
        
        // Make sure there is no sql injection
        $sortBy = QueryHelper::checkParameterIn($sortByParams, $request->input('sortby'), self::DEFAULT_SORT_BY, false);
        $sortType = QueryHelper::checkParameterIn($sortTypeParams, $request->input('sorttype'), self::DEFAULT_SORT_TYPE, false);
        $filterprice = QueryHelper::checkParameterIn($priceFilterParams, $request->input('price'), null, true, '&');
        $filtercolor = QueryHelper::checkParameterIn($colorFilterParams, explode(',', $request->input('color')), null, false);
        $filtertag = QueryHelper::checkParameterIn($tagFilterParams, explode(',', $request->input('tag')), null, false);
        $filtercategory = QueryHelper::checkParameterIn($categoryFilterParams, $request->input('category'), null, false);
        
        // Query strings
        $queryString = [
            'sortby' => $request->input('sortby'), 
            'sorttype' => $request->input('sorttype'), 
            'price' => $request->input('price'), 
            'color' => $request->input('color'), 
            'tag' => $request->input('tag'),
            'category' => $request->input('category'),
            'q' => $request->input('q')
        ];
        
        // Generate Urls
        $urls = [];
        $urls['sortby'] = QueryHelper::getUrls('sortby','product.page.index', $sortByParams, $queryString);
        $urls['sorttype'] = QueryHelper::getUrls('sorttype','product.page.index', $sortTypeParams, $queryString);
        $urls['price'] = QueryHelper::getUrls('price','product.page.index', $priceFilterParams, $queryString);
        $urls['color'] = QueryHelper::getUrls('color','product.page.index', $colorFilterParams, $queryString, true, ',');
        $urls['tag'] = QueryHelper::getUrls('tag','product.page.index', $tagFilterParams, $queryString, true, ',');
        $urls['category'] = QueryHelper::getUrls('category','product.page.index', $categoryFilterParams, $queryString);
        
        
        $products = Product::select('product.*')
                    ->join('category','category.id','=','product.idCategory')
                    ->leftJoin('product_tag','product_tag.idProduct','=','product.id')
                    ->leftJoin('product_color','product_color.idProduct','=','product.id')
                    ->leftJoin('tag','tag.id','=','product_tag.idTag')
                    ->leftJoin('color','color.id','=','product_color.idColor');
                    
        // Sorting
        $products = $products->orderBy($sortBy, $sortType);
        
        // If filtering by product color
        if($filtercolor){
            $products->where(function ($query) use ($filtercolor){
                foreach ($filtercolor as $index => $color) {
                    if($index == 0) {
                        $query = $query->where('color.name', 'LIKE', $color);
                    }else{
                        $query = $query->orWhere('color.name', 'LIKE', $color);
                    }
                }
            });
        }
        
        // If filtering by product tag
        if($filtertag){
            $products->where(function ($query) use ($filtertag){
                foreach ($filtertag as $index => $tag) {
                    if($index == 0) {
                        $query = $query->where('tag.name', 'LIKE', $tag);
                    }else{
                        $query = $query->orWhere('tag.name', 'LIKE', $tag);                    
                    }
                }
            });
        }
        
        // If filtering by product category
        if($filtercategory){
            $products = $products->where('category.name', 'LIKE', $filtercategory);
        }
        
        // If filtering by product price
        if($filterprice){
            if(is_array($filterprice)){
                $products = $products->where('product.price', '>', $filterprice[0])
                            ->where('product.price', '<', $filterprice[1]);
            }else{
                $products->where('product.price', '>', $filterprice);
            }
        }

        // If searching for something
        if($search != ''){
            $products->where(function ($query) use ($search){
                $query = $query->where('product.name', 'like', '%'.$search .'%')
                        ->orWhere('product.price', 'like', '%'.$search .'%')
                        ->orWhere('product.description', 'like', '%'.$search .'%')
                        ->orWhere('category.name', 'like', '%'.$search .'%')
                        ->orWhere('tag.name', 'like', '%'.$search .'%')
                        ->orWhere('color.name', 'like', '%'.$search .'%');
            });
        }
        
        // Paginate
        $products = $products->groupBy('product.id')->paginate(self::ITEMS_PER_PAGE)->withQueryString();
        
        // Tag param
        $tagparam = QueryHelper::getCompoundParam($tagFilterParams, $filtertag, ',');
        
        // Color param
        $colorparam = QueryHelper::getCompoundParam($colorFilterParams, $filtercolor, ',');
        
        foreach ($products as $product) {
            $product['images'] = $product->images;
            $product['tags'] = $product->tags;
            $product['colors'] = $product->colors;
        }
        
        foreach($filtercolor as $index => $color){
            $filtercolor[$index] = $colorFilterParams[$color];
        }
        
        foreach($filtertag as $index => $tag){
            $filtertag[$index] = $tagFilterParams[$tag];
        }
        
        return ['products' => $products, 
                'urls' => $urls, 
                'tags' => $tags, 
                'categories' => $categories, 
                'colors' => $colors,
                'queryString' => $queryString,
                'params' => [
                    'sortby' => ['selected' => $sortBy, 'params' => $sortByParams],
                    'sorttype' => ['selected' => $sortType, 'params' => $sortTypeParams],
                    'price' => ['selected' => array_search($request->input('price'), $priceFilterParams), 'params' => $priceFilterParams],
                    'color' => ['selected' => $filtercolor, 'params' => $colorFilterParams],
                    'tag' => ['selected' => $filtertag, 'params' => $tagFilterParams],
                    'category' => $categoryFilterParams,
                    ],
                'csrf' => csrf_token()
                ];
    }
    
    function fetchData(Request $request) {
        return response()->json($this->getData($request));
    }
    
    function loadmore(Request $request){
        $products = Product::paginate(self::ITEMS_PER_PAGE);
        // $profucts = $products->paginate(10)->withQueryString();
        return view('loadmore', ['products' => $products]);
    }
    
    // Version load more
    function index(Request $request){
        return view('index', $this->getData($request));
    }
    
    function getProductImages(Product $product){
        $images = Image::where('idProduct', $product->id)->get();
        return response()->json($images);
    }
}
