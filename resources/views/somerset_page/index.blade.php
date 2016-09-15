<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Somerset Place</title>
    
    <link rel="shortcut icon" href="{{ URL::asset('images/favicon.png')}}">
    <!-- Bootstrap Core CSS -->
    <link href="{{ URL::asset('vendors/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="{{ URL::asset('vendors/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>

    <!-- Plugin CSS -->
    <link href="{{ URL::asset('website/vendor/magnific-popup/magnific-popup.css')}}" rel="stylesheet">

    <!-- Theme CSS -->
    <link href="{{ URL::asset('website/css/creative.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('website/css/custom.css')}}" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body id="page-top">

    <nav id="mainNav" class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span> Menu <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand page-scroll" href="#page-top">Somerset Place</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a class="page-scroll" href="#about">About</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#services">Services</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#portfolio">Facilities</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#contact">Contact</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="{{route('login')}}">Login</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

    <header>
        <div class="header-content">
            <div class="header-content-inner">
                <h1 id="homeHeading">Somerset Place</h1>
                <hr>
                <p>A safe, secure and peaceful community amidst the hustle and bustle of Metro Manila.</p>
                <a href="#about" class="btn btn-primary btn-xl page-scroll">Find Out More</a>
            </div>
        </div>
    </header>

    <section class="bg-primary" id="about">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 text-center">
                    <h2 class="section-heading">About Somerset Place</h2>
                    <hr class="light">
                    <p class="text-faded">Somerset Place is a townhouse subdivision located at Manggahan, Pasig City 
                    consisting of two- storey structures (Figure 1 and 2). The Somerset place Homeowners Association 
                    Incorporated (SPHAI)  was established as a nonstock, non- profit community-based organization and 
                    registered with Housing and Land Use Regulatory Board (HLURB) in June 2009.
                    </p>
                    <img src="{{ URL::asset('images/somerset-vicinity.png')}}">
                </div>
            </div>
        </div>
    </section>

    <section id="services">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">At Your Service</h2>
                    <hr class="primary">
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-4x fa-home text-primary sr-icons"></i>
                        <h3>Sturdy Properties</h3>
                        <p class="text-muted">Houses built with high-quality materials to make sure that you get the best out of living with your family.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-4x fa-smile-o text-primary sr-icons"></i>
                        <h3>Amenities</h3>
                        <p class="text-muted">Somerset place has amenities such as playground, basketball court and function hall available for reservation.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-4x fa-shield text-primary sr-icons"></i>
                        <h3>Security</h3>
                        <p class="text-muted">The people living in Somerset place are safe and well-protected with our tight security.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="no-padding" id="portfolio">
        <div class="container-fluid">
            <div class="row no-gutter popup-gallery">
                <div class="col-lg-4 col-sm-6">
                    <a href="{{ URL::asset('images/guard.JPG')}}" class="portfolio-box">
                        <img src="{{ URL::asset('images/guard.JPG')}}" class="img-responsive" alt="Entrance">
                        <div class="portfolio-box-caption">
                            <div class="portfolio-box-caption-content">
                                <div class="project-category text-faded">
                                    Amenity
                                </div>
                                <div class="project-name">
                                    Guarded Entrance
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <a href="{{ URL::asset('images/houses.JPG')}}" class="portfolio-box">
                        <img src="{{ URL::asset('images/houses.JPG')}}" class="img-responsive" alt="">
                        <div class="portfolio-box-caption">
                            <div class="portfolio-box-caption-content">
                                <div class="project-category text-faded">
                                    Property
                                </div>
                                <div class="project-name">
                                    Stylish Properties
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <a href="{{ URL::asset('images/fountain.JPG')}}" class="portfolio-box">
                        <img src="{{ URL::asset('images/fountain.JPG')}}" class="img-responsive" alt="">
                        <div class="portfolio-box-caption">
                            <div class="portfolio-box-caption-content">
                                <div class="project-category text-faded">
                                    Amenity
                                </div>
                                <div class="project-name">
                                    Fountain Garden
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <a href="{{ URL::asset('images/function_hall.JPG')}}" class="portfolio-box">
                        <img src="{{ URL::asset('images/function_hall.JPG')}}" class="img-responsive" alt="">
                        <div class="portfolio-box-caption">
                            <div class="portfolio-box-caption-content">
                                <div class="project-category text-faded">
                                    Amenity
                                </div>
                                <div class="project-name">
                                    Function Hall
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <a href="{{ URL::asset('images/swimming_pool.JPG')}}" class="portfolio-box">
                        <img src="{{ URL::asset('images/swimming_pool.JPG')}}" class="img-responsive" alt="">
                        <div class="portfolio-box-caption">
                            <div class="portfolio-box-caption-content">
                                <div class="project-category text-faded">
                                    Amenity
                                </div>
                                <div class="project-name">
                                    Swimming Pool
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <a href="{{ URL::asset('images/basketball_court.JPG')}}" class="portfolio-box">
                        <img src="{{ URL::asset('images/basketball_court.JPG')}}" class="img-responsive" alt="">
                        <div class="portfolio-box-caption">
                            <div class="portfolio-box-caption-content">
                                <div class="project-category text-faded">
                                    Amenity
                                </div>
                                <div class="project-name">
                                    Basketball Court
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <aside class="bg-white">
        <div class="container-fluid text-center">
            <div class="call-to-action">
                <h2>Somerset Map</h2>
                <div class="col-lg-8 col-md-12 col-sm-12">
                    <img src="{{ URL::asset('images/somerset-map.png')}}" alt="Somerset Map" usemap="#Map" id="somerset">
                    <map name="Map" id="Map">
                        @foreach($blockLotList as $blockLot)
                            <area alt="" 
                                data-block="{{explode('-',$blockLot->block_lot)[0]}}"
                                data-lot="{{explode('-',$blockLot->block_lot)[1]}}"
                                data-status="{{$blockLot->homeowner==NULL?'Not Occupied':'Occupied'}}"
                                title="{{$blockLot->block_lot}} - {{$blockLot->homeowner==NULL?'Not Occupied':'Occupied'}}" 
                                href="#" 
                                shape="poly" 
                                coords="{{$blockLot->coordinates}}" 
                            />
                        @endforeach
                    </map>
                </div>
                <div class="col-lg-4 col-md-12 col-sm-12">
                    <h3 class="text-primary" ><strong>Phase Number</strong></h3>
                    <h2 id="phaseNumber"><strong>-</strong></h2>
                    <h3 class="text-primary" ><strong>Lot Number</strong></h3>
                    <h2 id="lotNumber"><strong>-</strong></h2>
                    <h3 class="text-primary" ><strong>Status</strong></h3>
                    <h2 id="status"><strong>-</strong></h2>
                </div>
                
            </div>
        </div>
    </aside>

    <section id="contact">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 text-center">
                    <h2 class="section-heading">Let's Get In Touch!</h2>
                    <hr class="primary">
                    <p>Ready for a comfortable and hassle-free living in Metro Manila? That's great! Give us a call or send us an email and we will get back to you as soon as possible!</p>
                </div>
                <div class="col-lg-4 col-lg-offset-2 text-center">
                    <i class="fa fa-phone fa-3x sr-contact"></i>
                    <p>SPHAI Office - (02)470-0040</p>
                </div>
                <div class="col-lg-4 text-center">
                    <i class="fa fa-envelope-o fa-3x sr-contact"></i>
                    <p><a href="mailto:your-email@your-domain.com">somersetplace@gmail.com</a></p>
                </div>
            </div>
        </div>
    </section>

    <!-- jQuery -->
    <script src="{{ URL::asset('website/vendor/jquery/jquery.min.js')}}"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="{{ URL::asset('website/vendor/bootstrap/js/bootstrap.min.js')}}"></script>

    <!-- Plugin JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
    <script src="{{ URL::asset('website/vendor/scrollreveal/scrollreveal.min.js')}}" rel="stylesheet"></script>
    <script src="{{ URL::asset('website/vendor/magnific-popup/jquery.magnific-popup.min.js')}}"></script>
    <script src="{{ URL::asset('website/js/creative.min.js')}}"></script>
    <!-- Image Mapster -->
    <script src="{{URL::asset('vendors/imagemapster/dist/jquery.imagemapster.min.js')}}"></script>
    <script>
        var block = '';
        var lot;
        var status = '';
        $(document).ready(function(){
            $('#somerset').mapster({
                fillColor: 'ff0000',
                fillOpacity: 0.3,
                stroke: true,
                singleSelect: true,
                showToolTip: true,
                toolTipClose: ["tooltip-click", "area-click"],
                onClick: function(e) {
                    if(e.key == 0) {

                    }
                }
            });
            $('area').on('click', function(){
                block = $(this).attr('data-block');
                lot = $(this).attr('data-lot');
                status = $(this).attr('data-status');
                $("#phaseNumber").text(block);
                $("#lotNumber").text(lot);
                $("#status").text(status);
                //console.log('Block: ' + block + '\n' + 'Lot: ' + lot + '\n' + 'Status: ' + status);
            });
        });
    </script>
    
</body>

</html>
