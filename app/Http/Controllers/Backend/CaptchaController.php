<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class CaptchaController extends Controller
{
    

    public $module_title;

    public $module_name;

    public $module_path;

    public $module_icon;

    public $module_model;

    public function __construct()
    {
        // Page Title
        $this->module_title = 'Captcha';

        // module name
        $this->module_name = 'captcha';

        // directory path of the module
        $this->module_path = 'backend';

        // module icon
        $this->module_icon = 'fas fa-archive';
        $this->module_model ="App\Models\Captcha";
    }
    public function index()
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
       // $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';

        $captchaCount = $this->module_model::count();
        $captchaData = $this->module_model::get();

        if ($captchaCount != 0) {
            $captchaRecord = $captchaData->first();
            if ($captchaRecord) {
                $captchaStatus = $captchaRecord->captcha_toggle;  
                $id = $captchaRecord->id;    
                
            } 
        }
        else {
            $captchaStatus = "";
        }
        

        //Log::info(label_case($module_title.' '.$module_action).' | User:'.Auth::user()->name.'(ID:'.Auth::user()->id.')');
         if ($captchaCount!=0) {
            return redirect()->route("backend.captchas.edit",$id );
           
        }
        else{
            return view(
                "backend.$module_name.index",

            compact('module_title', 'module_name', "module_name", 'module_path', 'module_icon', 'module_action', 'module_name_singular'
            ,'captchaStatus','captchaCount')
            );
       }
    }

    public function index_data()
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';

        $page_heading = label_case($module_title);
        $title = $page_heading.' '.label_case($module_action);

        $$module_name = $module_model::select('id', 'name', 'updated_at');

        $data = $$module_name;

        return Datatables::of($$module_name)
            ->addColumn('action', function ($data) {
                $module_name = $this->module_name;

                return view('backend.includes.action_column', compact('module_name', 'data'));
            })
            ->editColumn('name', '<strong>{{$name}}</strong>')
            ->editColumn('updated_at', function ($data) {
                $module_name = $this->module_name;

                $diff = Carbon::now()->diffInHours($data->updated_at);

                if ($diff < 25) {
                    return $data->updated_at->diffForHumans();
                } else {
                    return $data->updated_at->isoFormat('llll');
                }
            })
            ->rawColumns(['name', 'action'])
            ->orderColumns(['id'], '-:column $1')
            ->make(true);
    }

    public function store(Request $request)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
       
        $module_action = 'Store';

        $requestData = $request->except('_token');

        $$module_name_singular = $module_model::create($requestData);
       
        flash(icon()."New '".Str::singular($module_title)."' Added")->success()->important();

        logUserAccess($module_title.' '.$module_action.' | Id: '.$$module_name_singular->id);
        
        return redirect("admin/$module_name");
    }

    public function show($id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Show';
        $captchaCount = $this->module_model::count();
        $captchaData = $this->module_model::get();

        if ($captchaCount != 0) {
            $captchaRecord = $captchaData->first(); 
        
            if ($captchaRecord) {
                $captchaStatus = $captchaRecord->captcha_toggle;     
                
            } 
        }
        else {
            $captchaStatus = "";
        }
        $$module_name_singular = $module_model::findOrFail($id);
        
        logUserAccess($module_title.' '.$module_action.' | Id: '.$$module_name_singular->id);

        /*return view(
            "backend.$module_name.show",
            compact('module_title', 'module_name', 'module_path', 'module_icon', 'module_name_singular', 'module_action', "$module_name_singular")
        );*/
        return view(
            "backend.$module_name.index",

        compact('module_title', 'module_name', "module_name", 'module_path', 'module_icon', 'module_action', 'module_name_singular'
        ,'captchaStatus','captchaCount')
        );
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
        $captchaData = $this->module_model::get();
        $captchaRecord = $captchaData->first(); 
        
            if ($captchaRecord) {
                $id = $captchaRecord->id;     
                
            } 
        
        $$module_name_singular = $module_model::findOrFail($id);

        logUserAccess($module_title.' '.$module_action.' | Id: '.$$module_name_singular->id);

        return view(
            "$module_path.$module_name.edit",
            compact('module_title', 'module_name', 'module_path', 'module_icon', 'module_action', 'module_name_singular', "$module_name_singular")
        );
    }

    public function update(Request $request, $id)
    {
        
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        
        $module_action = 'Update';
        $captchaData = $this->module_model::get();

        $captchaRecord = $captchaData->first(); 
        
            if ($captchaRecord) {
                $id = $captchaRecord->id;     
                
            } 

        $$module_name_singular = $module_model::findOrFail($id);
        
        $$module_name_singular->update($request->all());
        
        flash(icon().' '.Str::singular($module_title)."' Updated Successfully")->success()->important();

        logUserAccess($module_title.' '.$module_action.' | Id: '.$$module_name_singular->id);

        return redirect()->route("backend.$module_name.show", $$module_name_singular->id);
      // return redirect("admin/$module_name");
    }


}
