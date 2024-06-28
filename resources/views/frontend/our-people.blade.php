@extends('frontend.layouts.app')

@section('title') {{app_name()}} @endsection

@section('content')
<section class="top-breadcrumb">
    <div class="container">
      <div class="row">
        <ul class="breadcrumb">
          <li><a href="/">Home</a>/</li>
          <li><a href="/about-us">About Us</a>/</li>
          <li><a href="/our-people" class="active"><b>Our Team</b></a></li>
        </ul>
      </div>
    </div>
</section>
    @php
        $formattedData = [];
        foreach ($section1 as $item) {
            if (strpos($item['key'], 'Title') !== false) {
                $formattedData['title'] = $item['value'];
            } elseif (strpos($item['key'], 'Description') !== false) {
                $formattedData['description'] = $item['value'];
            } elseif (strpos($item['key'], 'Image') !== false) {
                $formattedData['image'] = $item['value'];
            }
        }
    @endphp
<section class="our-people-banner" style="background: url('{{ $formattedData['image'] }}'); " >
    @if(isset($formattedData['title']))
        <h4 class="drop-in">{{ $formattedData['title'] }}</h4>
    @endif
    @if(isset($formattedData['description']))
        <p class="drop-in">{{ $formattedData['description'] }}</p>
    @endif    
</section>

<section class="meet-musicians">
    <div class="container">
        <div class="row mt-2">
            <div class="row mt-5">
                @foreach($section2 as $index => $item)
                    <div class="col-sm-4 openModalButton" data-index="{{ $index }}" data-id="{{$item->id}}" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        <div class="artist-img hovertop column">
                           <figure> <img src="{{$item->file}}" width="80%"></figure>
                        </div>
                        <div class="artist-details">
                            <h4>{{$item->name}}</h4>
                            <h5>{{$item->designation}}</h5>
                        </div>
                    </div>
                @endforeach             
            </div>  
        </div>
    </div>
</section>

<section class="meet-fellow">
  <div class="container">
    <h4>{{$section3TitleValue}}</h4>
    @foreach($section3->chunk(4) as $chunk)
    <div class="row">
        @foreach($chunk as $item)
        <div class="col-md-3 col-sm-6 mt-4 openModalButton" id="openModalButton" data-id="{{$item->id}}" data-bs-toggle="modal" data-bs-target="#exampleModal{{$item->id}}"">
            <div class="vio-musi-img mx-auto d-block hoverflash column">
               <figure> <img src="{{$item->file}}" class="img-fluid"> </figure>
            </div>
            <div class="musi-name">{{$item->name}}</div>            
            <div class="musi-name2">{{$item->designation}}</div>
            <div class="musi-name3">{{$item->designation_category}}</div>
        </div>
        @endforeach
    </div>
    @endforeach
    <div class="">
      <a href="/firdaus-orchestra-musicians" class="no-style-link"><button class="btn view-more">View More</button></a>
    </div>
  </div>
</section>
@php   
    $heading = [];
    $subtitle= [];    
    $image = [];       
    foreach ($section4 as $data) {
        $fieldName = $data->field_name;
        $fieldValue = $data->field_value;        
        if (preg_match('/Heading(\d+)/i', $fieldName, $matches)) {
            $heading[$matches[1]] = $fieldValue;            
        } elseif (strpos($fieldName, 'SubTitle') !== false) {
            $subtitle[1] = $fieldValue;            
        } elseif (preg_match('/Image(\d+)/i', $fieldName, $matches)) {
            $image[$matches[1]] = $fieldValue;
        }
    }  
@endphp
<section class="patron-board">
    <div class="container">
        <h4> {{$section4Title}} </h4>
        <div class="row">
            @foreach($heading as $index => $item)
                <div class="col-md-4">
                    <div class="pb-box hovertop column">
                        @if(isset($image[$index]))
                            <figure><img src="{{ $image[$index] }}" width="100%" /></figure>
                        @endif
                        <h4>{{$heading[$index]}}</h4>                        
                        @if(isset($subtitle[$index]))
                            <p>{{$subtitle[$index] }}</p>
                        @endif                    
                    </div>
                </div> 
            @endforeach     
        </div>
    </div>
</section>
@php   
    $heading5= [];   
    $content = [];       
    foreach ($section5 as $data) {
        $fieldName = $data->field_name;
        $fieldValue = $data->field_value;        
        if (preg_match('/Heading(\d+)/i', $fieldName, $matches)) {
            $heading5[$matches[1]] = $fieldValue;            
        } elseif (preg_match('/Content(\d+)/i', $fieldName, $matches)) {
            $content[$matches[1]] = $fieldValue;
        }
    }  
@endphp
<section class="our-people-collapse">
  <div class="container">
    <h4>{{$section5Title}}</h4>
    <div class="col-md-10 mx-auto">
      <div class="accordion accordion-flush" id="accordionFlushExample">
        @foreach($heading5 as $index => $item)
            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-heading{{$index}}">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse{{$index}}" aria-expanded="false" aria-controls="flush-collapse{{$index}}">
                        {{$heading5[$index]}}
                    </button>
                </h2>
                <div id="flush-collapse{{$index}}" class="accordion-collapse collapse" aria-labelledby="flush-heading{{$index}}" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">{{$content[$index]}}</div>
                </div>
            </div>
        @endforeach
        
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

@php
        $section7Data = [];        
        foreach ($section7 as $item) {            
            if (strpos($item['key'], 'Title') !== false) {
                $section7Data['title'] = $item['value'];
            } elseif (strpos($item['key'], 'Image') !== false) {
                $section7Data['image'] = $item['value'];
            }
        }
        
    @endphp
<section class="mm-upcoming-performance">
  <div class="container-fluid">
    <div class="row mm-up-per-div">
      <img src="{{$section7Data['image']}}" class="img-fluid p-0">
      <div class="mm-centered">
        <h1 class="mm-up-per-content">{{$section7Data['title']}}</h1>
        <a href="/events"><button class="btn mm-cal-btn">View Calender</button></a>
      </div>
    </div>
  </div>
</section>
@include('frontend.subscribe-modal');
@endsection
