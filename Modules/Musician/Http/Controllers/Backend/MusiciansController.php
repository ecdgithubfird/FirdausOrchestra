<?php

namespace Modules\Musician\Http\Controllers\Backend;

use App\Authorizable;
use App\Http\Controllers\Backend\BackendBaseController;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Modules\Article\Events\PostCreated;
use Modules\Article\Events\PostUpdated;
use Modules\Article\Http\Requests\Backend\PostsRequest;
use Modules\Category\Models\Category;
use Spatie\Activitylog\Models\Activity;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Modules\Musician\Models\Musician;
class MusiciansController extends BackendBaseController
{
    use Authorizable;

    public function __construct()
    {
        // Page Title
        $this->module_title = 'Musicians';

        // module name
        $this->module_name = 'musicians';

        // directory path of the module
        $this->module_path = 'musician::backend';

        // module icon
        $this->module_icon = 'fa-regular fa-sun';

        // module model name, path
        $this->module_model = "Modules\Musician\Models\Musician";
    }

    public function edit($id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Edit';

        $$module_name_singular = $module_model::findOrFail($id);

        logUserAccess($module_title.' '.$module_action.' | Id: '.$$module_name_singular->id);
        
        return view(
            "$module_path.$module_name.edit",
            compact('module_title', 'module_name', 'module_path', 'module_icon', 'module_action', 'module_name_singular', "$module_name_singular",'h')
        );
    }

    public function getSubCategories(Request $request)
    {
        $categoryId = $request->input('category_id');
        
        $subCategories = Category::where('parent_category', $categoryId)->where('status','Active')->get();
        
        return response()->json($subCategories);
    }
    public function getSubCategory(Request $request)
    {
        $musicianId = $request->input('musician_id');
        
        $subCategory = Musician::where('id', $musicianId)->where('status',1)->get();
        
        return response()->json($subCategory);
    }
    public function MusicianCount(Request $request)
    {
        $category = $request->input('category');        
        $catCount = Musician::where('category_id', $category)->where('status',1)->whereNull('deleted_at')->count();
       
        return response()->json($catCount);
    }  
    
    public function MusicianOrder(Request $request)
    {
        $id = $request->input('musician_id');
        $order = Musician::where('id', $id)->where('status',1)->whereNull('deleted_at')->get();
       return response()->json($order);
    }  
    
   
    


}
