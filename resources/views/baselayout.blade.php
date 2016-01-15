<!DOCTYPE html>
<html>
<head>
    <title>Laravel is awesome</title>

    {!! Html::style('css/app.css') !!}

    {!! Html::script('js/jquery.min.js') !!}
    {!! Html::script('js/bootstrap.min.js') !!}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <style>
        body { padding-top: 60px; }
        @media (max-width: 979px) {
            body { padding-top: 0px; }
        }
    </style>
</head>

<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Project name</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li><a href="">Home</a></li>
                <li><a href="Account">About</a></li>
                <li><a href="">Contact</a></li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>

<script>
    function loadDoc() {
        $.post("Account",
                {
                    name: "Donald Duck",
                    Amount: "1000"
                });
    }
    function getData() {
        $.ajax({
            url : 'Account',
            type: 'GET',
            success: function(data) {
                console.log(data);
            }
        })
    }

    function postData() {
        $.ajax({
            type: "POST",
            cache: false,
            url : "Account",
            data: { 'Name' : $('#Name').val(),'Amount' : $('#Amt').val() },
            success: function(data) {
                console.log(data);
            }
        })
    }

    function handleData(data) {
        alert(data);
        //do some stuff
    }

</script>

<div class="form-group">
    <label for="usr">Name:</label>
    <input type="text" class="form-control" id="Name">
</div>

<div class="form-group">
    <label for="usr">Amount:</label>
    <input type="text" class="form-control" id="Amt">
</div>

<button type="button" class="btn btn-default navbar-btn" onclick = getData();>GET</button>
<button type="button" class="btn btn-default navbar-btn" onclick = postData();>POST</button>

</div>

<body>
<div class="container">
    @yield('content')
</div><!-- /.container -->
</body>
</html>