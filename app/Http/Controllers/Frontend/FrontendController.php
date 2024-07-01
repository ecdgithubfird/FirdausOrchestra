<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Modules\Performance\Models\Performance;
use Modules\Article\Models\Post;
use Modules\Testimonial\Models\Testimonial;
use Modules\News\Models\News;
use Modules\Category\Models\Category;
use Modules\Musician\Models\Musician;
use Modules\Menu\Models\Menu;
use Modules\Page\Models\Page;
use Illuminate\Http\Request;
use Modules\Subscriber\Models\Subscriber;
use Modules\EventSetting\Models\EventSetting;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FrontendController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Performance::where('is_featured', 1)->where('status',1)->get();
        $carousels =  Post::where('category_name',"Carousel")->get();
        $testimonials = Testimonial::where('is_featured',1)->where('status',1)->get();
        $about =  Post::where('category_name',"About Us")->where('type', "Article")->where('is_featured', 1)->get();
        $aboutImage = Post::where('category_name',"About Us")->where('type', "Feature")->where('is_featured', 1)->get();
        $news = News::where('is_featured', '1')->where('status',1)->orderBy('created_at', 'asc')->limit(5)->get();
        $aboutSection = Page::join('page_fields', 'pages.id', '=', 'page_fields.page_id')
        ->join('fields','page_fields.field_id','fields.id')
        ->select('pages.name', 'pages.url','page_fields.field_id', 'page_fields.field_value','fields.name as field_name' ,'fields.field_type','fields.slug')
        ->where('pages.name','Home')
        ->where('fields.name', 'like', '%about%')
        ->get();       
        
        $carouselData = Page::join('page_fields', 'pages.id', '=', 'page_fields.page_id')
        ->join('fields', 'page_fields.field_id', 'fields.id')
        ->select(
            'pages.name',
            'pages.url',
            'page_fields.field_id',
            'page_fields.field_value',
            'fields.name as field_name',
            'fields.field_type',
            'fields.slug'
        )
        ->where('pages.name', 'Home')
        ->where('fields.name', 'like', '%carousel%') // Add this line to filter by 'carousel' in 'field_name'
        ->get();
        
        return view('frontend.index')->with('events',$events)
        ->with('carousels',$carouselData)
        ->with('testimonials',$testimonials)
        ->with('about',$about)
        ->with('aboutImage',$aboutImage)
        ->with('news',$news)
        ->with('aboutSection',$aboutSection);
    }

    
    /**
     * Meet the Musicians  Page.
     *
     * @return \Illuminate\Http\Response
     */
    public function musicians()
    {
        // $top_content =  Post::where('category_name',"Musicians")->get();
        $top_content = Page::select('fields.name as field_name', 'page_fields.field_value as field_value')
                        ->join('page_fields', 'pages.id', '=', 'page_fields.page_id')
                        ->join('fields', 'page_fields.field_id', '=', 'fields.id')
                        ->join('templates','pages.template_id','=','templates.id')
                        ->where('templates.slug', '=', 'meet-the-musicians')
                        ->get() 
                        ->pluck('field_value', 'field_name')
                        ->toArray();
        
        /*$topMusicians = Musician::whereRaw('LOWER(designation) NOT LIKE ? AND LOWER(designation) NOT LIKE ?', 
                        ['concertmaster', '%concert master%'])
                        ->orWhere('designation', '=', 'Concert Master And String Section Leader')
                        ->orderByRaw("CASE 
                                      WHEN LOWER(designation) = 'conductor' THEN 1
                                      WHEN LOWER(designation) = 'concert master and string section leader' THEN 2
                                      WHEN LOWER(designation) LIKE '%rhythm%' OR LOWER(designation) LIKE '%percussion%' THEN 3
                                      ELSE 4
                                  END")
                        ->orderBy('designation')
                        ->get();   */
        /*$topMusicians = Musician::whereIn('designation', ['Conductor', 'Concert Master and String Section Leader', 'Rhythm/Arabic/Indian Section Leader'])
                        ->orderByRaw("CASE 
                                        WHEN LOWER(designation) = 'conductor' THEN 1
                                        WHEN LOWER(designation) = 'concert master and string section leader' THEN 2
                                        WHEN LOWER(designation) LIKE '%rhythm%'   THEN 3
                                        ELSE 4
                                    END")
                        ->orderBy('designation')
                        ->get(); */

        $topMusicians = Musician::join('categories', 'musicians.category_id', '=', 'categories.id')
                        ->select('musicians.name','musicians.designation','musicians.file')
                        ->where('categories.name', '=', 'Section Leaders')
                        ->where('musicians.musician_order', '>=', 2)
                        ->orderBy('musicians.musician_order', 'asc')
                        ->get();
        $sectionLeaders = Musician::join('categories', 'musicians.category_id', '=', 'categories.id')
                        ->select('musicians.name','musicians.designation','musicians.file','musicians.id')
                        ->where('categories.name', '=', 'Section Leaders')                        
                        ->orderBy('musicians.musician_order', 'asc')
                        ->get();
               
        $category =  Category::where('group_name',"Musician-Instruments")
                    ->where('status','Active')->orderBy('category_order')->get(); 
        $category1 =  Category::where('group_name',"Musician-Instruments")
                    ->where('status','Active')
                    ->orderBy('category_order')->first();        
             
        $events =  Post::where('category_name',"MusicianEvent")->get();
        $subcategory1 = [];
        $subcategory2 = [];
        $subcategory3 = [];
        $subcategory4 = [];
        if ($category) {
            $subcategory1 = Category::where('parent_category', $category1->id)->get();  
            $subcategory2 = Category::where('parent_category', $category[1]->id)->get();  
            $subcategory3 = Category::where('parent_category', $category[2]->id)->get();
            $subcategory4 = Category::where('parent_category', $category[3]->id)->get();     
            $musicians = [];  
            $musicians2 = [];    
            $musicians3 = [];    
            $musicians4 = [];       
            foreach ($subcategory1 as $index => $subCategory) {
                // Retrieve musicians for the current subcategory
                $musiciansForSubCategory = Musician::join('categories', 'musicians.sub_category', '=', 'categories.id')
                    ->select('musicians.id', 'musicians.name', 'musicians.slug', 'musicians.designation', 'musicians.url', 'musicians.file', 
                        'musicians.status','musicians.designation_category','categories.id as category_id', 'categories.name as category_name')
                    ->where('categories.parent_category', $category1->id)
                    ->where('categories.name', $subCategory->name)                   
                    ->where('musicians.status', 1)
                    ->orderByRaw("CASE 
                                        WHEN LOWER(designation) LIKE '%concertmaster%' THEN 1
                                        WHEN LOWER(designation) LIKE '%principal 1%' THEN 2
                                        WHEN LOWER(designation) LIKE '%principal 2%' THEN 3
                                        WHEN LOWER(designation) LIKE '%tutti%' THEN 4
                                        ELSE 5
                                    END, designation")     

                    ->get();            
                
                $musiciansForSubCategory = $musiciansForSubCategory->reject(function ($musician) use ($topMusicians) {
                    return $topMusicians->pluck('name')->contains($musician->name);
                });                
                $musicians[$subCategory->name] = $musiciansForSubCategory;
            }
            
            
            foreach ($subcategory2 as $index=>$subCategory2) {
                $musiciansForSubCategory2 = Musician::join('categories', 'musicians.sub_category', '=', 'categories.id')
                    ->select('musicians.id','musicians.name', 'musicians.slug', 'musicians.designation', 'musicians.url', 'musicians.file', 
                    'musicians.status','musicians.designation_category','categories.id as category_id', 'categories.name as category_name')
                    ->where('categories.parent_category', $category[1]->id)
                    ->where('categories.name', $subCategory2->name)                    
                    ->where('musicians.status',1)
                    ->orderByRaw("CASE 
                                        WHEN LOWER(designation) LIKE '%concertmaster%' THEN 1
                                        WHEN LOWER(designation) LIKE '%principal 1%' THEN 2
                                        WHEN LOWER(designation) LIKE '%principal 2%' THEN 3
                                        WHEN LOWER(designation) LIKE '%tutti%' THEN 4
                                        ELSE 5
                                    END, designation")    
                    ->get();   
                $musiciansForSubCategory2= $musiciansForSubCategory2->reject(function ($musician) use ($topMusicians) {
                        return $topMusicians->pluck('name')->contains($musician->name);
                    });      
                $musicians2[$subCategory2->name] = $musiciansForSubCategory2;              
            }
            foreach ($subcategory3 as $index=>$subCategory3) {
                $musiciansForSubCategory3 = Musician::join('categories', 'musicians.sub_category', '=', 'categories.id')
                    ->select('musicians.id','musicians.name', 'musicians.slug', 'musicians.designation', 'musicians.url', 'musicians.file', 
                    'musicians.status','musicians.designation_category','categories.id as category_id', 'categories.name as category_name')
                    ->where('categories.parent_category', $category[2]->id)                    
                    ->where('categories.name', $subCategory3->name)
                    ->where('musicians.status',1)
                    ->orderByRaw("CASE 
                                        WHEN LOWER(designation) LIKE '%concertmaster%' THEN 1
                                        WHEN LOWER(designation) LIKE '%principal 1%' THEN 2
                                        WHEN LOWER(designation) LIKE '%principal 2%' THEN 3
                                        WHEN LOWER(designation) LIKE '%tutti%' THEN 4
                                        ELSE 5
                                    END, designation")    
                    ->get(); 
                    $musiciansForSubCategory3= $musiciansForSubCategory3->reject(function ($musician) use ($topMusicians) {
                        return $topMusicians->pluck('name')->contains($musician->name);
                    });       
                $musicians3[$subCategory3->name] = $musiciansForSubCategory3;              
            }
            foreach ($subcategory4 as $index=>$subCategory4) {
                $musiciansForSubCategory4 = Musician::join('categories', 'musicians.sub_category', '=', 'categories.id')
                    ->select('musicians.id','musicians.name', 'musicians.slug', 'musicians.designation', 'musicians.url', 'musicians.file', 
                    'musicians.status','musicians.designation_category','categories.id as category_id', 'categories.name as category_name')
                    ->where('categories.parent_category', $category[3]->id)
                    ->where('categories.name', $subCategory4->name)                    
                    ->where('musicians.status',1)
                    ->orderByRaw("CASE 
                                        WHEN LOWER(designation) LIKE '%concertmaster%' THEN 1
                                        WHEN LOWER(designation) LIKE '%principal 1%' THEN 2
                                        WHEN LOWER(designation) LIKE '%principal 2%' THEN 3
                                        WHEN LOWER(designation) LIKE '%tutti%' THEN 4
                                        ELSE 5
                                    END, designation")    
                    ->get();    
                    $musiciansForSubCategory4= $musiciansForSubCategory4->reject(function ($musician) use ($topMusicians) {
                        return $topMusicians->pluck('name')->contains($musician->name);
                    });     
                $musicians4[$subCategory4->name] = $musiciansForSubCategory4;              
            }   

        } 
          
        return view('frontend.musicians',compact('sectionLeaders'))
        ->with('topContent',$top_content)
        ->with('category',$category)        
        ->with('musicians',$musicians)        
        ->with('events',$events)
        ->with('subcategory1',$subcategory1)
        ->with('subcategory2',$subcategory2)
        ->with('musicians2',$musicians2)
        ->with('subcategory3',$subcategory3)
        ->with('musicians3',$musicians3)
        ->with('subcategory4',$subcategory4)
        ->with('musicians4',$musicians4)
        ->with('topMusicians',$topMusicians);
    }

    
    /**
     * About Us Page.
     *
     * @return \Illuminate\Http\Response
     */
    public function aboutUs()
    {
        $aboutTemplate = Page::select('pages.name as page_name', 'fields.name as field_name', 'page_fields.field_value as field_value')
                         ->join('page_fields', 'pages.id', '=', 'page_fields.page_id')
                         ->join('fields', 'page_fields.field_id', '=', 'fields.id')
                         ->where('pages.name', '=', 'About Us')
                         ->get();

        $aboutJourney = Page::select('fields.name as field_name', 'page_fields.field_value as field_value')
                         ->join('page_fields', 'pages.id', '=', 'page_fields.page_id')
                         ->join('fields', 'page_fields.field_id', '=', 'fields.id')
                         ->where('fields.name', '=', 'Journey')
                         ->get();

        $section3Data = Page::select('fields.name as field_name', 'page_fields.field_value as field_value')
                        ->join('page_fields', 'pages.id', '=', 'page_fields.page_id')
                        ->join('fields', 'page_fields.field_id', '=', 'fields.id')
                        ->where('fields.name', 'like', '%Section 3%')
                        ->get();

        $section4Data = Page::select('fields.name as field_name', 'page_fields.field_value as field_value')
                        ->join('page_fields', 'pages.id', '=', 'page_fields.page_id')
                        ->join('fields', 'page_fields.field_id', '=', 'fields.id')
                        ->where('fields.name', 'like', '%Section 4%')
                        ->get();
                                                
        return view('frontend.about-us', ['aboutTemplate' => $aboutTemplate, 'aboutJourney' => $aboutJourney, 'section3Data' => $section3Data, 'section4Data' => $section4Data]);
    
    }
    /**
     * Privacy Policy Page.
     *
     * @return \Illuminate\Http\Response
     */
    public function privacy()
    {
        $privacyData = Page::select('fields.name as field_name', 'page_fields.field_value as field_value')
        ->join('page_fields', 'pages.id', '=', 'page_fields.page_id')
        ->join('fields', 'page_fields.field_id', '=', 'fields.id')
        ->join('templates', 'pages.template_id', '=', 'templates.id')
        ->where('templates.name', '=', 'Privacy')
        ->get();
        return view('frontend.privacy')->with('privacyData',$privacyData);
    }

    /**
     * Terms & Conditions Page.
     *
     * @return \Illuminate\Http\Response
     */
    public function terms()
    {
        $termsData = Page::select('fields.name as field_name', 'page_fields.field_value as field_value')
        ->join('page_fields', 'pages.id', '=', 'page_fields.page_id')
        ->join('fields', 'page_fields.field_id', '=', 'fields.id')
        ->join('templates', 'pages.template_id', '=', 'templates.id')
        ->where('templates.name', '=', 'Terms & Conditions')
        ->get();
        return view('frontend.terms')->with('termsData',$termsData);
    }
    /**
     * FAQs Page.
     *
     * @return \Illuminate\Http\Response
     */
    public function faq()
    {
        $faqData = Page::select('fields.name as field_name', 'page_fields.field_value as field_value')
        ->join('page_fields', 'pages.id', '=', 'page_fields.page_id')
        ->join('fields', 'page_fields.field_id', '=', 'fields.id')
        ->join('templates', 'pages.template_id', '=', 'templates.id')
        ->where('templates.name', '=', 'Faq')
        ->get();
        return view('frontend.faq')->with('faqData',$faqData);
    }
    /**
     * Who we are Page.
     *
     * @return \Illuminate\Http\Response
     */
    public function whoWeAre()
    {
        $itemData = Menu::select('name','description','featured_image')
        ->where([['slug', '=', 'who-we-are'],['group_name', '=','SubMenu']])
        ->first();
        return view('frontend.who-we-are')->with('itemData',$itemData);
    }
    /**
     * Our People Page.
     *
     * @return \Illuminate\Http\Response
     */
    public function ourPeople()
    {
        $slug = 'our-people';
        $section1 = DB::table('pages')
                    ->join('page_fields', 'pages.id', '=', 'page_fields.page_id')
                    ->join('fields', 'page_fields.field_id', '=', 'fields.id')
                    ->join('templates', 'pages.template_id', '=', 'templates.id')
                    ->select('fields.name as key', 'page_fields.field_value as value')
                    ->where('fields.name', 'like', 'Section1%')
                    ->where('templates.slug', '=', $slug)
                    ->get()
                    ->map(function ($item) {
                        return (array)$item;
                        })
                    ->toArray(); 
        
        $section2 =  Musician::whereIn('designation', ['Conductor', 'Concert Master and String Section Leader',
                     'Rhythm And Percussion Section Leader'])
                    ->orderByRaw("CASE 
                                    WHEN LOWER(designation) = 'conductor' THEN 1
                                    WHEN LOWER(designation) = 'concert master and string section leader' THEN 2
                                    WHEN LOWER(designation) LIKE '%rhythm%' OR LOWER(designation) LIKE '%percussion%' THEN 3
                                    ELSE 4
                                END")
                    ->orderBy('designation')
                    ->get();   

        $section3TitleValue = $this->getAContent('Section3 Title','our-people');   

        $section3 = Musician::where('designation_category', 'LIKE', '%second violin%')
                    ->orderByRaw("CASE 
                                        WHEN LOWER(designation) LIKE '%principal1%' THEN 1
                                        WHEN LOWER(designation) LIKE '%principal2%' THEN 2
                                        ELSE 3
                                    END, designation") // Add a secondary ordering by designation to ensure consistent results
                    ->limit(4)
                    ->get();
        
        $section4Title = $this->getAContent('Section4 Title','our-people');
        $section4 = $this->getDataByContent('Section4',$slug);        
        $section5Title = $this->getAContent('Section5 Title',$slug);    
        $section5 = $this->getDataByContent('Section5',$slug);
        
        $section7 = DB::table('pages')->join('page_fields', 'pages.id', '=', 'page_fields.page_id')
                    ->join('fields', 'page_fields.field_id', '=', 'fields.id')
                    ->join('templates', 'pages.template_id', '=', 'templates.id')
                    ->select('fields.name as key', 'page_fields.field_value as value')
                    ->where('fields.name', 'like', 'Section7%')
                    ->where('templates.slug', '=', $slug)
                    ->get()
                    ->map(function ($item) {
                        return (array)$item;
                        })
                    ->toArray(); 
       
                        
        return view('frontend.our-people', compact('section1', 'section2','section3TitleValue','section3',
        'section4Title','section4','section5Title','section5','section7'));
    }
    /**
     * Projects Page.
     *
     * @return \Illuminate\Http\Response
     */
    public function projects()
    {
        $itemData = Menu::select('name','description','featured_image')
        ->where([['slug', '=', 'our-journey'],['group_name', '=','SubMenu']])
        ->first();
        return view('frontend.project')->with('itemData',$itemData);
    }
    /**
     * Careers Page.
     *
     * @return \Illuminate\Http\Response
     */
    public function careers()
    {
        $slug = 'careers';
        $careerTitle = $this->getAContent('Career Title',$slug);
        $careerText = $this->getAContent('Career Content',$slug);
        $imageData = $this->getDataByContent('Career Image',$slug); 
        $images = $imageData->pluck('field_value');
        $emailText = $this->getAContent('Career Email Text',$slug); 
        $emailText2 = $this->getAContent('Career Email Text2',$slug); 
        $email = $this->getAContent('Career Email',$slug); 
        return view('frontend.careers',compact('careerText','careerTitle','images','emailText','emailText2','email'));
    }

    /**
     * Our Story Page.
     *
     * @return \Illuminate\Http\Response
     */
    public function ourStory()
    {
        $storyData = Page::join('page_fields', 'pages.id', '=', 'page_fields.page_id')
        ->join('fields','page_fields.field_id','fields.id')
        ->select('pages.name', 'pages.url','page_fields.field_id', 'page_fields.field_value','fields.name as field_name' ,
        'fields.field_type','fields.slug')
        ->where('pages.name','Home')
        ->where('fields.name', 'like', '%about%')
        ->get(); 
        
        $heading = [];
        $content = [];
        $url = [];
        $image = [];

    foreach ($storyData as $data) {
        $fieldName = $data->field_name;
        $fieldValue = $data->field_value;

        if (preg_match('/About Heading1/', $fieldName, $matches)) {
            $heading = $fieldValue;
        } elseif (preg_match('/About Content1/', $fieldName, $matches)) {
            $content = $fieldValue;
        } elseif (preg_match('/About url1/', $fieldName, $matches)) {
            $url = $fieldValue;
        } elseif (preg_match('/About Image1/', $fieldName, $matches)) {
                $image = $fieldValue;
            }
    }
    return view('frontend.our-story',compact('heading','content','url','image'));
    }

    /**
     * Our Mentor Page.
     *
     * @return \Illuminate\Http\Response
     */
    public function ourMentor()
    {
        $mentorData = Page::join('page_fields', 'pages.id', '=', 'page_fields.page_id')
        ->join('fields','page_fields.field_id','fields.id')
        ->select('pages.name', 'pages.url','page_fields.field_id', 'page_fields.field_value','fields.name as field_name' ,
        'fields.field_type','fields.slug')
        ->where('pages.name','Home')
        ->where('fields.name', 'like', '%about%')
        ->get(); 
        
        $heading = [];
        $content = [];       
        $image = [];
        
    foreach ($mentorData as $data) {
        $fieldName = $data->field_name;
        $fieldValue = $data->field_value;

        if (preg_match('/About Heading2/', $fieldName, $matches)) {
            $heading = $fieldValue;
        } elseif (preg_match('/About Content2/', $fieldName, $matches)) {
            $content = $fieldValue;
        } elseif (preg_match('/About Image2/', $fieldName, $matches)) {
                $image = $fieldValue;
            }
    }
    
    return view('frontend.our-mentor',compact('heading','content','image'));
    }
    /**
     * Our Conductors Page.
     *
     * @return \Illuminate\Http\Response
     */
    public function ourConductor()
    {
        $conductorData = Page::join('page_fields', 'pages.id', '=', 'page_fields.page_id')
        ->join('fields','page_fields.field_id','fields.id')
        ->select('pages.name', 'pages.url','page_fields.field_id', 'page_fields.field_value','fields.name as field_name' ,'fields.field_type','fields.slug')
        ->where('pages.name','Home')
        ->where('fields.name', 'like', '%about%')
        ->get(); 
        
        $heading = [];
        $content = [];       
        $image = [];

    foreach ($conductorData as $data) {
        $fieldName = $data->field_name;
        $fieldValue = $data->field_value;

        if (preg_match('/About Heading3/', $fieldName, $matches)) {
            $heading = $fieldValue;
        } elseif (preg_match('/About Content3/', $fieldName, $matches)) {
            $content = $fieldValue;
        } elseif (preg_match('/About Image3/', $fieldName, $matches)) {
                $image = $fieldValue;
            }
    }
    return view('frontend.our-conductor',compact('heading','content','image'));
    }
    /**
     * Contact us Page.
     *
     * @return \Illuminate\Http\Response
     */
    public function contactUs()
    {
        $slug = 'contact-us';
        $connect_menus = Menu::where('group_name','Connect')->where('status',1)->whereNull('deleted_at')->get(); 
        $title = $this->getAContent('Section1 Title',$slug);
        $subtitle = $this->getAContent('Section1 SubTitle',$slug);
        $image = $this->getAContent('Section1 Image',$slug);
        return view('frontend.contact-us',compact('connect_menus','title','subtitle','image'));
    }
    /**
     * Save subscribers mail id.
     *
     * @return \Illuminate\Http\Response
     */
    public function saveSubscribers(Request $request)
    {
        $email =  $request->input('email');
        $name =  $request->input('name');
        if(!empty($email)){
            $subscribers = Subscriber::create([
                'name'=> $name,
                'email' => $email,
                'status' => 1,
            ]);
            
            $subscribers->save();
            return response()->json(['message' => 'Subscription successful']);
        }
    }

    public function getMusician( $id){

		$musicianData = Musician::where('id',$id)->get();
        return response()->json($musicianData);
    }

    public function events(){

        $currentMonth = Carbon::now()->month;       
        $events = Performance::whereMonth('event_date', $currentMonth)
                    ->where('status',1)
                    ->whereNull('deleted_at')
                    ->orderBy('event_date')
                    ->get();
        $eventSettings = EventSetting::where('status',1)->first();
        if($eventSettings){
            $genreFilter = $eventSettings->genre_filter ?? 0;
            $seasonFilter = $eventSettings->season_filter ?? 0;
            $typeFilter = $eventSettings->type_filter ?? 0;
        }else{
            $genreFilter = 0;
            $seasonFilter = 0;
            $typeFilter = 0;
        }
        $genres = Category::where('group_name','Genre')->get();
        $seasons = Category::where('group_name','Season')->get();        
        return view('frontend.events', compact('events','genres','seasons','genreFilter','seasonFilter','typeFilter'));

    }

    public function getEventsByMonth($month){  

        $currentYear = Carbon::now()->year;      
        $events = Performance::whereMonth('event_date', $month)
                    ->whereYear('event_date', $currentYear)
                    ->where('status',1)
                    ->whereNull('deleted_at')
                    ->orderBy('event_date')
                    ->get();
        return response()->json(['events' => $events]);       
    }

    public function getEventsByFilter(Request $request)
    {
        $data = $request->input('filterBy');
        $filter = $request->input('filter');
        $month = $request->input('month');
        $year = $request->input('year');
        $events = $this->eventQuery($filter,$data,$month, $year);
        return response()->json(['events' => $events]);
        
    }
    public function eventQuery($fieldName,$data,$month,$year)
    {
        $events = Performance::whereMonth('event_date', $month)
                    ->whereYear('event_date', $year)
                    ->where($fieldName,$data)                    
                    ->where('status',1)
                    ->whereNull('deleted_at')
                    ->orderBy('event_date')
                    ->get();
        return $events;
    }

    public function comingSoon()
    {
        
      return view('frontend.errors') ;
    }

    public function whatWeDo(){

        $slug = 'what-we-do';
        $section1 = $this->getDataByContent('Section1',$slug);  
        $section2 = $this->getDataByContent('Section2',$slug);                    
        $section2Title = $this->getAContent('Section2 Title',$slug);
        $section2Description = $this->getAContent('Section2 Description',$slug);
        $section3Title = $this->getAContent('Section3 Title',$slug);
        $section3Description = $this->getAContent('Section3 Content',$slug);
        $section3Image = $this->getAContent('Section3 Image',$slug);        
                   
        return view('frontend.what-we-do',compact('section1','section2','section2Title','section3Title',
        'section2Description','section3Description','section3Image')) ;
    }

    public function getAContent($fieldName,$templateSlug)
    {
        $textValue = Page::join('page_fields', 'pages.id', '=', 'page_fields.page_id')
                            ->join('fields', 'page_fields.field_id', '=', 'fields.id')
                            ->join('templates', 'pages.template_id', '=', 'templates.id')
                            ->select('fields.name as key', 'page_fields.field_value as value')
                            ->where('fields.name', '=', $fieldName)
                            ->where('templates.slug', '=', $templateSlug)
                            ->first();

        $textContent = $textValue ? $textValue->value : null;
        return $textContent;
    }
    public function getDataByContent($fieldText,$templateSlug){

        $data = Page::join('page_fields', 'pages.id', '=', 'page_fields.page_id')
                    ->join('fields', 'page_fields.field_id', '=', 'fields.id')
                    ->join('templates', 'pages.template_id', '=', 'templates.id')
                    ->select('fields.name as field_name', 'page_fields.field_value as field_value')
                    ->where('fields.name', 'like', $fieldText.'%')
                    ->where('templates.slug', '=', $templateSlug)
                    ->get();    
        return $data;
    }
}
