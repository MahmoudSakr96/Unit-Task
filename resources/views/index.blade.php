<!Doctype html>
<html >
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">

    <title>Units Details!</title>

  </head>
  <body>
   
    <div class="container">
      <div class="row">
      @for ( $i=0 ; $i <count($adress) ; $i++)
        <div class="col-4 "style=" border:8px solid #ffffff;  ">
          <div class="card "style="height: 250px;  background-color: powderblue;">
            <div class="card-body">
              <h5  class="card-title">Item Name: {{$item[$i]}}</h5>

              @if (array_key_exists("$i",$sensor))

              <h5  class="card-text">Sensor: {{$sensor[$i][0]}}</h5 >
              @else
              <h5  class="card-text">Sensor: Not Found</h5 >


             @endif
              <h5  class="card-text">Address: {{str_replace(["[","]",'"'],"",((array)$adress[$i])[0])}}</h5 >
            </div>
          </div>
        </div>



       @endfor
      </div>

    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script> --}}

  <script>
    $(document).ready(function() {
      setInterval(function() {
      window.location.reload(true);
      }, 10000);
    });
  </script>
  </body>
</html>