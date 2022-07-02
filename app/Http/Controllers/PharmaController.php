<?php

namespace App\Http\Controllers;

use App\MainCategory;
use App\SubCategory;
use App\Drug;
use App\Product1;
use App\Category;
use App\Traits\ScrapesWeb;
use Illuminate\Http\Request;

class PharmaController extends Controller
{
    use ScrapesWeb;


    public function __construct(Request $request)
    {
        
    }

    public function HomeView()
    {
        $cat = Category::all();
        $prod = Product1::all();
        return view('home')->with(['category'=>$cat,'products'=>$prod]);
    }

    public function ScrapeMainCategory()
    {
        $record = [];
        $table = 'App\\MainCategory';

        $url = "https://www.medplusmart.com/drugsCategory/MEDICINES/Topical-Antibiotics/10140/10141";
        // $page = $this->httpGet($url);
        $page = $this->curl_get_contents($url);
    
        $f = 1;
        $r = 1;
        for ($i=1; $i <= 2; $i++) { 
            $f = stripos($page, "inline-list margin-none", $f) + strlen("inline-list margin-none");
            $l = stripos($page, "</ul>", $f);
            $page1 = str_replace("\n", "", substr($page, $f, $l - $f));
            $b = explode("title", $page1);
            $f = $l + 1;
            $f1 = 1;
            $f2 = 1;
            for ($j=1; $j < count($b); $j++) { 
                $r = $r + 1;
                $f1 = stripos($page1, "/drugsCategory", $f1 + 1);
                $l1 = stripos($page1, '"', $f1);
                $urlpath = str_replace("\n", "", substr($page1, $f1, $l1 - $f1));

                $record['category_id'] = substr($urlpath, strlen($urlpath) - 11, 5);
                $record['parent_category'] = substr($urlpath, 15, 9);
                $record['url'] = $urlpath;
                
                $f1 = stripos($page1, "title", $f1 + 1) + 7;
                $l1 = stripos($page1, '"', $f1);
                $record['category'] = str_replace("\n", "", substr($page1, $f1, $l1 - $f1));
                $f1 = $l1 + 1;
                $table::create($record);
            }
        }

        return view('main_categories')->with(['table' => $table::paginate(10)]);
    }

    public function ScrapeSubCategory()
    {
        \Log::Info('ScrapeSubCategory');
        $record = [];
        $MCAT = 'App\\MainCategory';
        $table = 'App\\SubCategory';

        $url = "https://www.medplusmart.com/drugsCategory/MEDICINES/Topical-Antibiotics/10140/10141";
        $page = $this->curl_get_contents($url);

        $f = 1;
        $r = 1;
        for ($i=1; $i <= 30; $i++) { 
            $id = 'id="CAT_' . $MCAT::findOrFail($i)->category_id . "SubCategories";
            $f = stripos($page, $id, $f) + strlen($id);
            $l = stripos($page, "</div>", $f);
            $page1 = str_replace("\n", "", substr($page, $f, $l - $f));
            $b = explode("title", $page1);
            $f = $l + 1;
            $f1 = 1;
            $f2 = 1;
            for ($j=1; $j < count($b); $j++) { 
                $r = $r + 1;
                $f1 = stripos($page1, "/drugsCategory", $f1 + 1);
                $l1 = stripos($page1, '"', $f1);
                $urlpath = str_replace("\n", "", substr($page1, $f1, $l1 - $f1));

                $record['sub_category_id'] = substr($urlpath, strlen($urlpath) - 5, 5);
                $record['category_id'] = substr($urlpath, strlen($urlpath) - 11, 5);
                $record['parent_category'] = strtoupper(substr($urlpath, 15, 9));
                // $record['url'] = $urlpath;
                
                $f1 = stripos($page1, "title", $f1 + 1) + 7;
                $l1 = stripos($page1, '"', $f1);
                $record['sub_category'] = str_replace("\n", "", substr($page1, $f1, $l1 - $f1));

                $turl = ucfirst(str_replace(['&', ' ', ','],['n','-',''], $record['sub_category']));
                $record['url'] = "/drugsCategory/".$record['parent_category']."/".$turl."/".$record['category_id']."/".$record['sub_category_id'];

                $f1 = $l1 + 1;
                $table::create($record);
                // \Log::Info($record);
            }
        }

        return view('sub_categories')->with(['table' => $table::paginate(10)]);
    }

    public function ScrapeDrug()
    {
        $record = [];
        $MCAT = 'App\\MainCategory';
        $SCAT = 'App\\SubCategory';
        $table = 'App\\Drug';

        $r = 1;
        for ($i=1; $i <= 185; $i++) { 
            if(in_array($i,[27,65,75,91,95,96,106,108,115,122,134,143,144,145,147,148,152,155,156,166,168,169,170,171,172,176,181])){continue;}
            $subCatId = "CAT_" . $SCAT::findOrFail($i)->category_id;
            $pCat = $SCAT::findOrFail($i)->parent_category;

            $url = "https://www.medplusmart.com" . $SCAT::findOrFail($i)->url;

            $page = $this->httpGet($url);
            $f = 1;

            $f = stripos($page, "productIdString", $f) + strlen("productIdString");
            $f = stripos($page, "value", $f) + 7;
            $l = stripos($page, "'", $f);
            $productIdString = substr($page, $f, $l - $f);

            $f = stripos($page, "totalProductFound", $f) + strlen("totalProductFound");
            $f = stripos($page, "value", $f) + 7;
            $l = stripos($page, "'", $f);
            $totalProductFound = substr($page, $f, $l - $f);

            $productCategoryId = "CAT_" . $SCAT::findOrFail($i)->sub_category_id;

            $SCAT::findOrFail($i)->update(['no_of_drugs'=>$totalProductFound]);

            for ($j=0; $j < $totalProductFound; $j = $j + 25) { 
                $startIndex = $j;
                $url1 = "https://www.medplusmart.com/loadMorePharmacyProducts.mart";

                $param = [];
                $param["startIndex"] = $startIndex;
                $param["productIdString"] = $productIdString;
                $param["totalProductFound"] = $totalProductFound;
                $param["productCategoryId"] = $productCategoryId;
                $param["subCatId"] = $subCatId;
                $param["pCat"] = $pCat;
                $param["isPharmacyCatProdRqrd"] = "Y";
                
                $page1 = $this->httpPost($url1, $param);
                
                $arr = explode("<td", $page1);
                for ($k=1; $k < count($arr); $k = $k + 5) { 
                    $r = $r + 1;
                    $f1 = 1;

                    $f1 = stripos($arr[$k], "href", $f1 + 1) + 6;
                    $l1 = stripos($arr[$k], '"', $f1 + 1);
                    $urlpath = str_replace("\n", "", substr($arr[$k], $f1, $l1 - $f1));
                    $record['url'] = $urlpath;
                    $record['parent_category'] = $pCat;
                    $record['category_id'] = $SCAT::findOrFail($i)->category_id;
                    $record['sub_category_id'] = $SCAT::findOrFail($i)->sub_category_id;
                    $record['drug_code'] = substr($urlpath, strlen($urlpath) - 8, 8);
                    $record['drug'] = str_replace("-", " ", substr($urlpath, 9, strlen($urlpath) - 18));

                    $f1 = stripos($arr[$k], "title", $f1 + 1) + 7;
                    $l1 = stripos($arr[$k], '"', $f1);
                    $record['composition'] = str_replace("\n", "", substr($arr[$k], $f1, $l1 - $f1));

                    $f1 = stripos($arr[$k], "Form:", $f1 + 1) + 15;
                    $l1 = stripos($arr[$k], '<', $f1);
                    $record['form_of_drug'] = str_replace("\n", "", substr($arr[$k], $f1, $l1 - $f1));

                    $f1 = stripos($arr[$k+1], ">",  1) + 1;
                    $l1 = stripos($arr[$k+1], '<', $f1);
                    $record['manufacturer'] = str_replace("\n", "", substr($arr[$k+1], $f1, $l1 - $f1));

                    $f1 = stripos($arr[$k+2], ">",  1) + 1;
                    $l1 = stripos($arr[$k+2], '<', $f1);
                    $record['pack_size'] = str_replace("\n", "", substr($arr[$k+2], $f1, $l1 - $f1));

                    $f1 = stripos($arr[$k+3], "/i>",  1) + 3;
                    $l1 = stripos($arr[$k+3], '<', $f1);
                    $record['mrp'] = str_replace("\n", "", substr($arr[$k+3], $f1, $l1 - $f1));

                    $table::create($record);
                    // \Log::Info($record);
                }
            }
        }

        return view('drugs_list')->with(['table' => $table::paginate(10)]);
    }

    public function MainCategoryView()
    {
        $table = 'App\\MainCategory';
        return view('main_categories')->with(['table' => $table::paginate(10)]);
    }

    public function SubCategoryView()
    {
        $table = 'App\\SubCategory';
        return view('sub_categories')->with(['table' => $table::paginate(10)]);
    }

    public function DrugView()
    {
        $table = 'App\\Drug';
        return view('drugs_list')->with(['table' => $table::paginate(10)]);
    }
}