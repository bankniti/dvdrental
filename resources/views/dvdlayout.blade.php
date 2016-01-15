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
    <p>Below is a more-detailed discussion of the main HTTP methods. Click on a tab for more information about the desired HTTP method.</p>
    <ul class="nav nav-tabs">
        <li class="active"><a href="#Client" data-toggle="tab">CLIENT</a></li>
        <li class=""><a href="#Movie" data-toggle="tab">MOVIE</a></li>
        <li class=""><a href="#Rental" data-toggle="tab">RENTAL</a></li>
        <li><a href="#delete" data-toggle="tab">DELETE</a></li>
    </ul>
    <div id="methodTabContent" class="tab-content">
        <div class="tab-pane fade active in" id="Client">
            <p></p>
            <p>Add/Remove client to the store.</p>
            <p><strong>Examples:</strong></p>
            <ul>
                <li><em>POST http://www.example.com/customers</em></li>
                <li><em>POST http://www.example.com/customers/12345/orders</em></li>
            </ul>

            <div class="form-group">
                <label for="usr">Client Name:</label>
                <input type="text" class="form-control" placeholder="Enter client's name" id="ClientName">
            </div>

            <button type="button" class="btn btn-primary navbar-btn" onclick = postClientData();>ADD</button>
            <button type="button" class="btn btn-primary navbar-btn" onclick = deleteClientData();>DELETE</button>

        </div>
        <div class="tab-pane fade" id="Movie">
            <p></p>
            <p>Add/Remove movies in the store.</p>
            <p><strong>Examples:</strong></p>
            <ul>
                <li><em>GET http://www.example.com/customers/12345</em></li>
                <li><em>GET http://www.example.com/customers/12345/orders</em></li>
                <li><em>GET http://www.example.com/buckets/sample</em></li>
            </ul>

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
            <button type="button" class="btn btn-primary navbar-btn" onclick = deleteMovieData();>DELETE</button>

        </div>
        <div class="tab-pane fade" id="Rental">
            <p>Rental/Return</p>
            <p><strong>Examples:</strong></p>
            <ul>
                <li><em>PUT http://www.example.com/customers/12345</em></li>
                <li><em>PUT http://www.example.com/customers/12345/orders/98765</em></li>
                <li><em>PUT http://www.example.com/buckets/secret_stuff</em></li>
            </ul>

            <table id="movie_table" border='1'>
                <tr>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Available</th>
                </tr>
            </table>

            <button type="button" class="btn btn-primary navbar-btn" onclick = getAllMovie();>GET</button>

        </div>
        <div class="tab-pane fade" id="delete">
            <p>DELETE is pretty easy to understand.  It is used to **delete** a resource identified by a URI.
            </p><p>On successful deletion, return HTTP status 200 (OK) along with a response body, perhaps the representation of the deleted item (often demands too much bandwidth), or a wrapped response (see Return Values below).  Either that or return HTTP status 204 (NO CONTENT) with no response body.  In other words, a 204 status with no body, or the JSEND-style response and HTTP status 200 are the recommended responses.</p>
            <p>HTTP-spec-wise, DELETE operations are idempotent.  If you DELETE a resource, it's removed.  Repeatedly calling DELETE on that resource ends up the same: the resource is gone.  If calling DELETE say, decrements a counter (within the resource), the DELETE call is no longer idempotent.  As mentioned previously, usage statistics and measurements may be updated while still considering the service idempotent as long as no resource data is changed.  Using POST for non-idempotent resource requests is recommended.</p>
            <p>There is a caveat about DELETE idempotence, however.  Calling DELETE on a resource a second time will often return a 404 (NOT FOUND) since it was already removed and therefore is no longer findable.  This, by some opinions, makes DELETE operations no longer idempotent, however, the end-state of the resource is the same. Returning a 404 is acceptable and communicates accurately the status of the call.</p>
            <p><strong>Examples:</strong></p>
            <ul>
                <li><em>DELETE http://www.example.com/customers/12345</em></li>
                <li><em>DELETE http://www.example.com/customers/12345/orders</em></li>
                <li><em>DELETE http://www.example.com/bucket/sample</em></li>
            </ul>
        </div>
    </div>
</div>

<body>
<div class="container">
    @yield('content')
</div><!-- /.container -->
</body>
</html>

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

    function postClientData() {
        $.ajax({
            type: "POST",
            cache: false,
            url : "Client",
            data: { 'Name' : document.getElementById("ClientName").value},
            success: function(data) {
                console.log(data);
                location.reload();
            }
        })
    }

    function deleteClientData() {
        $.ajax({
            type: "DELETE",
            cache: false,
            url : "Client/"+$('#ClientName').val()+"/Delete",
            success: function(data) {
                console.log(data);
                location.reload();

            }
        })
    }

    function postMovieData() {
        $.ajax({
            type: "POST",
            cache: false,
            url : "Movie",
            data: { 'Name' : document.getElementById("MovieName").value, 'Type' : document.getElementById("MovieType").value , 'Status' : 'YES' },
            success: function(data) {
                console.log(data);
                location.reload();
            }
        })
    }

    function deleteMovieData() {
        $.ajax({
            type: "DELETE",
            cache: false,
            url : "Movie/"+$('#MovieName').val()+"/Delete",
            success: function(data) {
                console.log(data);
                location.reload();
            }
        })
    }

    function getAllMovie() {
        $.ajax({
            type: "GET",
            cache: false,
            url : "Movie",
            success: function(data) {
                console.log(data);
                var trHTML = '';
                $.each(data, function (i, item) {
                    trHTML += '<tr><td>' + item.Name + '</td><td>' + item.Type + '</td><td>' + item.Status + '</td></tr>';
                });
                $('#movie_table').append(trHTML);

                location.reload();
            }
        })
    }

    function handleData(data) {
        alert(data);
        //do some stuff
    }

</script>