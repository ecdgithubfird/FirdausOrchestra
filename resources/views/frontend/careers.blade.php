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

<section class="career-page">
    <div class="container">
        <h1 class="contact-hd">{{strtoupper($careerTitle)}}</h1>
        <div class="row">
            <p>{{$careerText}}</p>
            <p>{{$emailText}}</p>
            <h4>{{$email}} </h4>
            <p>to explore exciting opportunities with us!</p>
        </div>
    </div>
</section>
<section class="career-gallery">
        <div class="container">
            <div class="row">
                @foreach($images as $image)
                    @if($loop->iteration == 1)
                        <div class="col-md-3 col-xs-12 pe-0">
                            <img src="{{$image}}" class="h-400 img-fluid">
                        </div>
                    @endif
                @endforeach
                <div class="col-md-4">
                    <div class="row">
                    @foreach($images as $image)
                        @if($loop->iteration >= 2 && $loop->iteration <= 3)
                        <div class="col-md-12 col-xs-12 pe-0">
                            <img src="{{$image}}" class="h-200 img-fluid">
                        </div>
                        @endif  
                    @endforeach                     
                    </div>
                </div>
                <div class="col-md-3 ">
                    <div class="row">
                    @foreach($images as $image)
                    @if($loop->iteration >= 4 && $loop->iteration <= 6)
                        <div class="@if($loop->iteration == 6) col-md-12 @else col-md-6 @endif col-xs-12 pe-0 ">
                            <img src="{{$image}}" class="h-200 img-fluid @if($loop->iteration == 6) pt-12 @endif">
                        </div>                        
                    @endif
                    @endforeach
                    </div>
                </div>
                
                <div class="col-md-2 col-xs-12 pe-0">
                @foreach($images as $image) 
                    @if($loop->iteration == 7)
                        <img src="{{$image}}" class="h-400 img-fluid">
                    @endif
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
<div class="modal fade" id="mailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Subscribe via Email</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Name:</label>
                        <input type="text" name = "recipient-name" class="form-control" id="recipient-name" required>
                    </div>
                    <div class="mb-3">
                        <label for="recipient-email" class="col-form-label">Email:</label>
                        <input type="email" name ="recipient-email" class="form-control" id="recipient-email" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="subscribe()">Subscribe</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered musicModal">
    <div class="modal-content">    
      <div class="modal-body">      
        <div class="artist-modal">
          <button type="button" class="btn-close modal-close" data-bs-dismiss="modal" aria-label="Close"></button>
          <div class="row">
            <div class="col-md-6 text-center">
              <img src="img/artist-1.png" id ="imgText" class="img-fluid"/>
            </div>
            <div class="col-md-6">
              <div class="artist-details">
                <h4 class="text-left" id="titleText"></h4>
                <h5 class="text-left mt-2" id="roleText"></h5>
              </div>
              <p id ="quoteText" class="mt-3"></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
