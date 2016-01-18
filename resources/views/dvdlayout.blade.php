<!DOCTYPE html>
<html>
<head>
    <title>The Movie Rental Shop</title>

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

<div class="container">
    <h1>Welcome to MOVIE-RENTAL store.</h1>
    <p></p>
    <p>MOVIE-RENTAL store web application, you can Add/Remove store's client and also can Add/Remove the movie in the store.</p>
    <p>Not only that, you would be able to manage rental/return process as well by choose the tab below.</p>

    <ul class="nav nav-tabs">
        <li class="active"><a href="#Store" data-toggle="tab">STORE</a></li>
        <li class=""><a href="#Client" data-toggle="tab">CLIENT</a></li>
        <li class=""><a href="#Movie" data-toggle="tab">MOVIE</a></li>
        <li class=""><a href="#Rental" data-toggle="tab">RENTAL</a></li>
        <li><a href="#Return" data-toggle="tab">RETURN</a></li>
    </ul>
    <div id="methodTabContent" class="tab-content">

        <!--STORE TAB-->

        <div class="tab-pane fade active in" id="Store">
            <p></p>
            <p>All of activities of our Client's.</p>

            <div class="container">
                <p><strong>Client Table</strong><p>
                <div class="table-responsive">
                    <table class="table" id="client_table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Movie Rental</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>

            <script>

                $.ajax({
                    type    : "GET",
                    cache   : false,
                    url     : "clients",
                    success : function(data) {
                        console.log(data);
                        var trClient = '';
                        $.each(data, function (key, val) {

                            trClient += '<tr><td>' + (key+1) + '</td><td>' + val.Name;

                            // If clients has Details:
                            if(val.hasOwnProperty('Details')){

                                $lastObjIndex = (Object.keys(val.Details).length - 1);

                                trClient += '</td><td>' + val.Details[$lastObjIndex].Movie + '</td><td>' + val.Details[$lastObjIndex].Status + '</td><td>' + val.Details[$lastObjIndex].Date + '</td></tr>';

                            }else{
                                trClient += '</td><td>' + '-' + '</td><td>' + '-' + '</td><td>' + '-' + '</td></tr>';
                            }

                        });

                        if (data.status != 'Client not found') {
                            $('#client_table').append(trClient);
                        }
                    }
                })

            </script>

            <p></p>
            <p>All of inventory of our Store.</p>

            <div class="container">
                <p><strong>Movie Table</strong><p>
                <div class="table-responsive">
                    <table class="table" id="movie_table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Available</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>

            <script>
                $.ajax({
                    type    : "GET",
                    cache   : false,
                    url     : "movies",
                    success : function(data) {
                        console.log(data);
                        var trMovie = '';
                        $.each(data, function (key, val) {

                            trMovie += '<tr><td>' + (key+1) + '</td><td>' + val.Name + '</td><td>' + val.Type + '</td><td>' + val.Status + '</td></tr>';
                        });

                        if (data.status != 'Movie not found') {
                            $('#movie_table').append(trMovie);
                        }
                    }
                })

            </script>

        </div>

        <!--CLIENT TAB-->

        <div class="tab-pane fade" id="Client">
            <p></p>
            <p>Add/Remove client to the store.</p>

            <div class="form-group">
                <label for="usr">Client Name:</label>
                <input type="text" class="form-control" placeholder="Enter client's name" id="ClientName">
            </div>

            <button type="button" class="btn btn-primary navbar-btn" onclick = postClientData();>ADD</button>

            <script>
                function postClientData() {
                    $.ajax({
                        type    : "POST",
                        cache   : false,
                        url     : "clients",
                        data    : {'Name' : document.getElementById("ClientName").value},
                        success : function(data) {
                            console.log(data);

                            if(data.status == 'success'){
                                alert('Done!');
                                location.reload();

                            }else if(data.status == 'Please insert Name'){
                                alert('Please insert Name');
                            }else{
                                alert('Fail!')
                            }
                        }
                    })
                }
            </script>

            <button type="button" class="btn btn-primary navbar-btn" onclick = deleteClientData();>DELETE</button>

            <script>
                function deleteClientData() {
                    $.ajax({
                        type    : "DELETE",
                        cache   : false,
                        url     : "clients/"+$('#ClientName').val(),
                        success : function(data) {
                            location.reload();

                            if(data.status == 'success'){
                                alert('Done!');
                                console.log(data);

                            }else{
                                alert('Failed, invalid client name!')
                            }

                        }
                    }).fail(function(){
                        alert('Failed, please insert client name!');
                    })
                }

            </script>

        </div>

        <!--MOVIE TAB-->

        <div class="tab-pane fade" id="Movie">
            <p></p>
            <p>Add/Remove movie in the store.</p>

            <div class="form-group">
                <label for="usr">Movie Name:</label>
                <input type="text" class="form-control" placeholder="Enter movie's name" id="MovieName">
            </div>


            <div class="form-group">
                <label for="MovieType">Select movie type (select one):</label>
                <select class="form-control" id="MovieType">
                    <option value="Action" selected="selected">Action</option>
                    <option value="Comedy">Comedy</option>
                    <option value="Drama">Drama</option>
                </select>
             </div>

            <button type="button" class="btn btn-primary navbar-btn" onclick = postMovieData();>ADD</button>

            <script>
                function postMovieData() {
                    $.ajax({
                        type    : "POST",
                        cache   : false,
                        url     : "movies",
                        data    : { 'Name' : document.getElementById("MovieName").value, 'Type' : document.getElementById("MovieType").value , 'Status' : 'YES' },
                        success : function(data) {
                            console.log(data);

                            if(data.status == 'success'){
                                alert('Done!');
                                location.reload();
                            }else if(data.status == 'Please insert Name'){
                                alert('Please insert Name');
                            }else{
                                alert('Fail!')
                            }
                        }
                    })
                }
            </script>

            <button type="button" class="btn btn-primary navbar-btn" onclick = deleteMovieData();>DELETE</button>

            <script>
                function deleteMovieData() {
                    $.ajax({
                        type    : "DELETE",
                        cache   : false,
                        url     : "movies/"+$('#MovieName').val(),
                        success : function(data) {
                            console.log(data);

                            if(data.status == 'success'){
                                alert('Done!');
                                location.reload();
                            }else{
                                alert('Failed, invalid movie name!')
                            }
                        }
                    }).fail(function(){
                        alert('Failed, please insert movie name!');
                    })
                }
            </script>

        </div>

        <!--RENTAL TAB-->

        <div class="tab-pane fade" id="Rental">
            <p></p>
            <p>Choose client and movie which want to proceed rental.</p>

            <div class="form-group">
                <label for="ClientName">Select client name:</label>
                <select class="form-control" id="rentalClient" size="5">
                </select>
            </div>

            <script>
                $.ajax({
                    type    : "GET",
                    cache   : false,
                    url     : "clients",
                    success : function(data){

                        //clear the current content of the select
                        $('#rentalClient').html('');

                        //iterate over the data and append a select option
                        $.each(data, function(key, val){

                            // If 'Details' is one of the object:
                            if(val.hasOwnProperty('Details')){
                                $lastObjIndex = (Object.keys(val.Details).length - 1);
                                console.log(val.Details);

                                // If most recent status is 'Return', we allow client to rent:
                                if(val.Details[$lastObjIndex].Status == 'Returned'){
                                    $('#rentalClient').append('<option value="' + val.Name + '">' + val.Name + '</option>');
                                    console.log(val.Details[$lastObjIndex].Status);
                                }

                             // Otherwise, fresh client should not have 'Details:
                            }else{
                                $('#rentalClient').append('<option value="' + val.Name + '">' + val.Name + '</option>');
                            }

                        })
                    }
                });
            </script>

            <div class="form-group">
                <label for="MovieName">Select movie name:</label>
                <select class="form-control" id="rentalMovie" size="5">
                </select>
            </div>

            <script>
                $.ajax({
                    type    : "GET",
                    cache   : false,
                    url     : "movies",
                    success : function(data){

                        //clear the current content of the select
                        $('#rentalMovie').html('');

                        //iterate over the data and append a select option
                        $.each(data, function(key, val){

                            if(val.Status == 'YES') {
                                $('#rentalMovie').append('<option value="' + val.Name + '">' + val.Name + '</option>');
                            }
                        })
                    }
                });
            </script>

            <button type="button" class="btn btn-primary navbar-btn" onclick = postRental();>RENT!</button>

            <script>
                function postRental() {
                    $.ajax({
                        type    : "POST",
                        cache   : false,
                        url     : "rental",
                        data    : { 'Name' : document.getElementById("rentalClient").value, 'Movie' : document.getElementById("rentalMovie").value },
                        success : function(data) {
                            console.log(data);
                            location.reload();
                        }
                    })
                }
            </script>

        </div>

        <!--RETURN TAB-->

        <div class="tab-pane fade" id="Return">
            <p></p>
            <p>Choose client and movie which want to proceed return.</p>

            <div class="form-group">
                <label for="ClientName">Select client name:</label>
                <select class="form-control" id="returnClient" size="5">
                </select>
            </div>

            <script>
                $.ajax({
                    type    : "GET",
                    cache   : false,
                    url     : "clients",
                    success : function(data){

                        //clear the current content of the select
                        $('#returnClient').html('');

                        //iterate over the data and append a select option
                        $.each(data, function(key, val){

                            // If there is
                            //if(Object.keys(val).length >= 3) {
                            if(val.hasOwnProperty('Details')){
                                //console.log(val);

                                $lastObjIndex = (Object.keys(val.Details).length - 1);
                                console.log(val.Details);

                                if(val.Details[$lastObjIndex].Status == 'Rented'){
                                    $('#returnClient').append('<option value="' + val.Name + '">' + val.Name + '</option>');
                                    console.log(val.Details[$lastObjIndex].Status);
                                }

                            }
                        })
                    }
                });
            </script>

            <div class="form-group">
                <label for="MovieName">Select movie name:</label>
                <select class="form-control" id="returnMovie" size="5">
                </select>
            </div>

            <script>
                $.ajax({
                    type    : "GET",
                    cache   : false,
                    url     : "movies",
                    success : function(data){

                        //clear the current content of the select
                        $('#returnMovie').html('');

                        //iterate over the data and append a select option
                        $.each(data, function(key, val){
                            //console.log(data);

                            if(val.Status == 'NO') {
                                $('#returnMovie').append('<option value="' + val.Name + '">' + val.Name + '</option>');
                            }
                        })
                    }
                });
            </script>

            <button type="button" class="btn btn-primary navbar-btn" onclick = putReturn();>RETURN!</button>

            <script>
                function putReturn() {
                    $.ajax({
                        type    : "PUT",
                        cache   : false,
                        url     : "return/"+document.getElementById("returnClient").value+"/"+document.getElementById("returnMovie").value,
                        success : function(data) {
                            console.log(data.status);

                            // If return invalid movie:
                            if(data.status == 'Details incorrect'){
                                alert('You are not return rented movie!!!');
                            }else{
                                alert('Movie returned successfully.');
                            }

                            location.reload();
                        }
                    })
                }
            </script>

        </div>
    </div>
</div>

<body>
<div class="container">
    @yield('content')
</div><!-- /.container -->
</body>
</html>
