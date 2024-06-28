@extends('frontend.layouts.app')

@section('title') {{app_name()}} @endsection

@section('content')
<section class="top-breadcrumb">
    <div class="container">
      <div class="row">
        <ul class="breadcrumb">
          <li><a href="/">Home</a>/</li>
          <li><a href="/what-we-do" class="active"><b>What We Do</b></a></li>          
        </ul>
      </div>
    </div>
</section>
@php   
    $heading = [];   
    $content = [];    
    $image = [];   
    foreach ($section1 as $data) {
        $fieldName = $data->field_name;
        $fieldValue = $data->field_value;        
        if (preg_match('/Title(\d+)/i', $fieldName, $matches)) {
            $heading[$matches[1]] = $fieldValue;            
        } elseif (preg_match('/Content(\d+)/i', $fieldName, $matches)) {
            $content[$matches[1]] = $fieldValue;
        }elseif (preg_match('/Image(\d+)/i', $fieldName, $matches)) {
            $image[$matches[1]] = $fieldValue;
        }
    }  
    
@endphp
<section class="orchestra">
        <div class="container">
            <div class="row">
              @foreach($heading as $index => $item)
                <div class="col-md-4 col-sm-6 @if($loop->iteration == 1)first-www @elseif($loop->iteration == 2) sec-www @else third-www @endif">
                    <div class="pos-rel">
                        <img src="{{$image[$index]}}" class="www-img">
                        <div class="www-overlay">
                            <h3 class="www-img-hd">{{$heading[$index]}}</h3>
                            <div class="www-img-sub-hd">
                                {{$content[$index]}}
                            </div>
                        </div>
                    </div>
                </div>
              @endforeach                
            </div>
        </div>
    </section>
    @php   
    $title = [];   
    $heading = [];
    $content = [];    
    $desc = [];   
    $image=[];
    foreach ($section2 as $data) {
        $fieldName = $data->field_name;
        $fieldValue = $data->field_value;        
        if (preg_match('/Heading(\d+)/i', $fieldName, $matches)) {
            $heading[$matches[1]] = $fieldValue;            
        } elseif (preg_match('/Content(\d+)/i', $fieldName, $matches)) {
            $content[$matches[1]] = $fieldValue;
        }elseif (preg_match('/Image(\d+)/i', $fieldName, $matches)) {
            $image[$matches[1]] = $fieldValue;
        }
    }  
    
@endphp
    <section class="www-music-ip">
        <div class="container">
            <h3 class="music-ip-hd">{{$section2Title}}</h3>
            <h5 class="text-center">{{$section2Description}}</h5>
            <div class="row">
                @foreach($heading as $index => $item)
                <div class="col-md-4 text-center">
                    <div class="music-ip-img mx-auto">
                        <fig>
                            <img src="{{$image[$index]}}" class="img-fluid">
                        </fig>
                    </div>
                    <div class="music-ip-c">
                        <h4>{{$heading[$index]}}</h4>
                        <h6>{{$content[$index]}}</h6>
                    </div>
                </div>
                @endforeach              
            </div>
        </div>
    </section>

    <section class="www-edu-prgrms">
        <div class="container-fluid">
            <div class="row mm-up-per-div">
                <img src="{{$section3Image}}" class="img-fluid p-0 www-bg-img">
                <div class="www-centered">
                    <h1 class="www-up-content">{{ $section3Title }}</h1>
                    <h4 class="www-down-content">{{ $section3Description}}</h4>
                    <button class="btn www-btm-btn"><span class="www-btn-bold">Know</span>MORE</button>
                </div>
            </div>
        </div>
    </section>

    <section class="stay-informed">
        <div class="container">    
            <h1 class="fir-sub-hd">STAY IN TOUCH</h1>    
            <div class="alert alert-success alert-dismissible fade show" role="alert" id="successAlert" >
                <strong>Success!</strong> Subscription successful.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>        
            
            <div class="row">
                <div class="input-container-stay">                    
                    <input type="email" id="sub-email" class="input-field form-control sub-placeholder" name="email" placeholder="Type your email" />
                    <!---<button class="btn sub-btn" onclick="subscribe()">Subscribe</button> --->
                    <span class="invalidEmailAlert"></span>
                    <button type="button"  class="btn btn-primary sub-btn" onclick="openMailModal()">Subscribe</button>
                    
                </div>
                
            </div>
        </div>
    </section>
@include('frontend.subscribe-modal');
@endsection
