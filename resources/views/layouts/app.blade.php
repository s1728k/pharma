@php
  $arr_fonts = ['ABeeZee', 'Bitter', 'Brawler', 'Buenard', 'Courgette', 'Delius', 'Fenix', 'Gudea', 'Halant', 'Heebo', 'Hind', 'K2D', 'Khula', 'Lora', 'Delius', 'Encode Sans', 'Esteban', 'Laila', 'Mukta', 'Patua One', 'Pavanam', 'Roboto', 'Sniglet', 'Strait'];
    $t = (strtotime(date("Y-m-d"))-strtotime("2010-01-01"))/86400 % count($arr_fonts);
    $font_family = $arr_fonts[$t];

  $color = ['background-color'=>'#F8F8F8','background-shade-color'=>'#EEEEEE','border-color'=>'#E7E7E7','default'=>'#777','hover'=>'#333','bhover'=>'#5E5E5E','active'=>'#555','active-background'=>'#D5D5D5', 'default-background'=>'white'];
  $color = ['background-color'=>'#31B0D5','background-shade-color'=>'#EEEEEE','border-color'=>'#7DC4F5','default'=>'white','hover'=>'#e1e1e1','bhover'=>'#5E5E5E','active'=>'#d3d3d3','active-background'=>'#006BFF', 'default-background'=>'white'];
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
  <base href="/">
	<title>Billing Software Online</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
  <link href='https://fonts.googleapis.com/css?family={{$font_family}}' rel='stylesheet'>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
  <style>
    :root{
      --font-family:{{$font_family}};
      --nav-bg-color: {{$color['background-color']}}; 
      --nav-bg-shade-color: {{$color['background-shade-color']}}; 
      --nav-border-color: {{$color['border-color']}}; 
      --nav-link-color: {{$color['default']}}; 
      --nav-hover-color: yellow; 
      --nav-brand-hover-color: {{$color['bhover']}}; 
      --nav-active-link-color: {{$color['active']}}; 
      --nav-active-link-bg-color: {{$color['active-background']}}; 
      --nav-brand-hover-color: {{$color['default-background']}}; 
      --nav-toggle-color: #3B5998; 
      --nav-toggle-lines-color: {{$color['background-shade-color']}}; 
    }
  </style>
  <link rel="stylesheet" href="public/css/app.css">
  <style>
    
  </style>
  @yield("custom_css")
</head>
<body>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span> 
        </button>
        <a href="/home"><svg height="25" width="100">
            <text x="0" y="16" fill="yellow" style="font-size:15px; font-weight:bold; font-family:Arial, Helvetica, sans-serif">Billing</text>
            <text x="0" y="25" fill="lightgrey" style="font-size:9px; font-weight:bold; font-family:Arial, Helvetica, sans-serif; letter-spacing: .38rem;">---------</text>
          Billing
        </svg></a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav navbar-right">
        @guest
        <li><a href="/main_categories">MainCat</a></li>
        <li><a href="/sub_categories">SubCat</a></li>
        <li><a href="/drugs_list">DrugsList</a></li>
        <li><a href="{{route('register')}}"><i class="fa fa-user"></i> Sign Up</a></li>
        <li><a href="{{route('login')}}"><i class="fa fa-sign-in"></i> Login</a></li>
        @else
        <li><a href="{{route('invoice.index')}}">Invoices</a></li>
        <li><a href="{{route('order.index')}}">Orders</a></li>
        <li><a href="{{route('estimate.index')}}">Estimates</a></li>
        <li><a href="{{route('recurring.index')}}">Recurring</a></li>
        <li><a href="{{route('porder.index')}}">Purchase Orders</a></li>
        <li><a href="{{route('expense.index')}}">Expenses</a></li>
        <li><a href="{{route('customer.index')}}">Customers</a></li>
        <li><a href="{{route('product.index')}}">Products/Services</a></li>
        <li><a href="{{route('reports.index')}}">Reports</a></li>
        <li><a href="{{route('settings.index')}}">Settings</a></li>
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">{{\Auth::user()->name}}
          <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="{{ route('logout') }}" onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();"><span class="fa fa-sign-out"></span> Logout</a></li>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
            </form>
          </ul>
        </li>
        @endguest
      </ul>
    </div>
  </div>
</nav>
@yield("content")
</body>
</html>

