@extends('frontend.layouts.app')

@section('title') {{app_name()}} @endsection

@section('content')
<section class="about-breadcrumb">
        <div class="container">
            <div class="row">
                <ul class="breadcrumb">
                    <li><a href="#">Home</a>/</li>
                    <li><a href="/contact-us" class="active"><strong>Contact Us</strong></a></li>
                </ul>
            </div>
        </div>
    </section>
    <section class="contact-us-page">
        <div class="container">
            <h1 class="contact-hd">CONTACT US</h1>
            <div class="row">
                <div class="col-md-5">
                    <img src="{{$image}}" class="contact-page-img img-fluid">
                </div>
                <div class="col-md-7 contact-rgt-side">
                    <h5>{{$title}}</h5>
                    <p>{{$subtitle}}</p>
                    <h6>follow us</h6>
                    <ul class="list-inline contact-ul-margin">
                        @foreach($connect_menus as $menu)
                            <li class="list-inline-item contact-li">
                                <a href="{{$menu->link}}" class="no-style-link" target="_blank">
                                    <img src="{{$menu->featured_image}}" class="contact-footer-icons">
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <!-- Validation Errors -->
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>There were some problems with your input:</strong>
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <form method="POST" action="{{ route('contact.store') }}" class="contact-form">
                    @csrf
                        <label class="form-label">Enter your Name</label>
                        <div class="mb-3 input-group flex-nowrap">
                            <span class="input-group-text fa fa-user-o"></span>
                            <input type="text" name="name" class="form-control shadow-none" placeholder="Name">
                        </div>
                        <label class="form-label">Enter your Email id</label>
                        <div class="mb-3 input-group flex-nowrap">
                            <span class="input-group-text fa fa-envelope-o"></span>
                            <input type="text" name="email" class="form-control shadow-none" placeholder="Email id">
                        </div>
                        <label class="form-label">Enter your Company</label>
                        <div class="mb-3 input-group flex-nowrap">
                            <span class="input-group-text fa fa-building-o"></span>
                            <input type="text" name="company" class="form-control shadow-none" placeholder="Company">
                        </div>
                        <label class="form-label">Enter your Contact no.</label>
                        <div class="mb-3 input-group flex-nowrap">
                            <span class="input-group-text fa fa-mobile"></span>
                            <input type="text" name="contact_no" class="form-control shadow-none" placeholder="Contact no.">
                        </div>
                        <label class="form-label">Enter your Country</label>
                        <div class="mb-3 input-group flex-nowrap">
                            <span class="input-group-text fa fa-globe"></span>
                            <input type="text" name="country" class="form-control shadow-none" placeholder="Country">
                        </div>
                        <label class="form-label">Inquiry box</label>
                        <div class="input-group flex-nowrap contact-textarea">
                            <textarea class="form-control shadow-none" aria-label="With textarea" placeholder="Inquiry" name="inquiry" rows="4"></textarea> 
                        </div>
                        <span class="float-end textarea-contact">Max 2000 characters</span>
                        <button type="submit" class="btn sub-btn w-100 mt-sub-btn">Submit</button>
                    </form>
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