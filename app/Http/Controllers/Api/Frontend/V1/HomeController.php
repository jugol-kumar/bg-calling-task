<?php

namespace App\Http\Controllers\Api\Frontend\V1;

use App\Http\Controllers\Api\V1\BusinessSettingController;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\PageRequest;
use App\Http\Resources\V1\PageResource;
use App\Http\Resources\V1\SliderResource;
use App\Http\Resources\V1\Category\CategoryListResource;
use App\Http\Resources\V1\HomeSectionResource;
use App\Http\Resources\V1\FooterResource;
use App\Models\Location;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\HomeSection;
use App\Models\Product;
use App\Models\Slider;
use App\Models\Page;
use App\Models\Footer;

use function App\Http\Helpers\getSetting;

class HomeController extends Controller
{

    public function getSliders(): \Illuminate\Http\JsonResponse
    {
        $sliders = Slider::query()->select('image')->latest('order_number')->get();
        return response()->json($sliders);
    }

    public function getSelectedCategoryProducts()
    {
        $data = Category::query()
            ->where('status', 1)
            ->with(['products' => function ($query) {
                $query->select('id', 'title', 'cover_image', 'price', 'category_id'); // Don't forget to include the foreign key (e.g., 'category_id')
            }])
            ->select(['id', 'name'])
            ->take(10)->get();

        return response()->json($data);
    }

    public function getHeaderSetting()
    {
        $categoryIds = json_decode(getSetting('header_categories'));
        $categories = [];
        if ($categoryIds !== null && count($categoryIds) > 0) {
            $categories = Category::whereIn('id', $categoryIds ?? [])->with('children', 'products')->where('parent_id', 0)->get();
        }

        $pageIds = json_decode(getSetting('header_pages'));
        $pages = [];
        if ($pageIds !== null && count($pageIds) > 0) {
            $pages = Page::whereIn('id', $pageIds ?? [])->get();
        }

        $setting = [
            'header_categories' => $categories,
            'header_pages' => $pages,
        ];

        return response()->json($setting);
    }


    public function getHeroSlider()
    {
        $sliders = Slider::query()
            ->where('status', 1)
            ->orderBy('order_number')
            ->get();

        return SliderResource::collection($sliders);
    }

    public function getHomeSection()
    {
        $homeSection = HomeSection::query()->get();

        foreach ($homeSection as $section) {

            if ($section->categories) {
                $categoryIds = json_decode($section->categories);
                $section['categories'] = Category::query()->whereIn('id', $categoryIds)->select('slug', 'name', 'icon')->get();
            }

            if ($section->products) {
                $productIds = json_decode($section->products);
                $products = Product::query()->whereIn('id', $productIds)->select('slug', 'title', 'cover_image', 'key_features', 'price', 'discount_price')->get();
                foreach ($products as $product) {
                    $product->key_features = json_decode($product->key_features);
                }
                $section['products'] = $products;
            }
        }

        return HomeSectionResource::collection($homeSection);
    }

    public function getHomeContent()
    {
        $categoryIds = json_decode(getSetting('discover_categories'));
        $categories = [];
        if ($categoryIds !== null && count($categoryIds) > 0) {
            $categories = Category::whereIn('id', $categoryIds ?? [])->get();
        }
        $settings = [
            'discover_categories' => $categories,
            'home_content' => getSetting('home_content')
        ];

        return response()->json($settings);

    }

    public function getCustomPage($slug)
    {
        $page = Page::where('slug', $slug)->first();

        return PageResource::make($page);
    }

    public function getFooter()
    {
        $columns = Footer::query()->orderBy('order_number')->get();

        foreach ($columns as $column) {
            $pageIds = json_decode($column->pages);
            $pages = Page::query()->whereIn('id', $pageIds)->get();

            $column['pages'] = $pages;
        }

        return FooterResource::make($columns);
    }


    public function getAllSettings(): \Illuminate\Http\JsonResponse
    {
        $data = request()->all();
        $response = [];
        foreach (explode(',', $data['name']) as $item) {
            $response[$item] = json_decode(getSetting($item));
        }
        return response()->json($response);
    }

    public function getBusinessLocations()
    {
        $localtions = Location::all();
        return response()->json($localtions);
    }

    public function categories()
    {
        $cats = Category::query()->whereHas('products')->select(['id', 'name'])->get();
        return response($cats);
    }
    public function allCategories()
    {
        $cats = Category::query()->select(['id', 'name'])->get();
        return response($cats);
    }
    public function filterProducts(Request $request)
    {
        $products = Product::query()
            ->with(['category'])
            ->when($request->input('category'), function ($query, $search){
                $query->where('category_id', $search);
            })
            ->when($request->input('location'), function ($query, $search){
                $query->where('location_id', $search);
            })
            ->when(\Illuminate\Support\Facades\Request::input('priceRange'), function ($query, $search){
                $query->whereBetween('price', [$search['min'], $search['max']]);
            })
            ->when(\Illuminate\Support\Facades\Request::input('search'), function ($query, $search){
                $query->where('title', 'like', "%{$search}%");
            })
            ->select(['id', 'title', 'cover_image', 'price'])->latest();


        if($request->has('onlyData')){
            $products = $products->latest()->get();
        }else{
            $products = $products->simplePaginate($request->input('perPage') ?? 30)
                ->withQueryString();
        }

        return response()->json($products, 200);
    }

    public function getAllpages()
    {
        $pages = Page::query()->get();
        return response()->json([
            'page' => $pages
        ]);
    }
    public function getSinglePage($id)
    {
        $page = Page::query()->findOrFail($id);

        return response()->json($page);
    }
}