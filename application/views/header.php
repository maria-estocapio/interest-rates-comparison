<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">   
    <title>Homework</title>
  <link href="/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">  
	<link href="/assets/css/datepicker.min.css" rel="stylesheet">	
	<link href="/assets/css/default.css" rel="stylesheet">
	<script src="/assets/js/jquery-3.3.1.min.js"></script>
  <script src="/assets/bootstrap/js/bootstrap.min.js"></script>  
	<script src="/assets/js/datepicker.min.js"></script>
	<script src="/assets/js/chart.js"></script>
	<script src="/assets/js/utils.js"></script>
	


    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    
  </head>
  

<body>

<nav class="navbar navbar-expand-md navbar-dark bg-mom fixed-top">
  <a class="navbar-brand" href="#">Ministry of Manpower</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarsExampleDefault">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="<?php echo base_url();?>">Home <span class="sr-only">(current)</span></a>
      </li>     
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Charts</a>
        <div class="dropdown-menu" aria-labelledby="dropdown01">          
          <a class="dropdown-item" href="<?php echo base_url();?>ui/charts">Trend</a>
          <a class="dropdown-item" href="<?php echo base_url();?>ui/charts/average">Average</a>
        </div>
      </li>
    </ul>   
  </div>
</nav>