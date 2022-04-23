<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    

    <title>Hello, world!</title>
  </head>
  <body>
    <h1 class="text-center mt-5">Ajax-Crud</h1><hr>
   <div class="container mt-5">
    <div id="success"></div>
    <button type="button" class="btn btn-success p-2 mb-5" style="margin-left: 1200px;" data-bs-toggle="modal" data-bs-target="#exampleModal">Add User</button>
    <table class="table data-table">
        <thead>
          <tr>
            <th scope="col">Sl-No</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
        
        </tbody>
      </table>
   </div>
    

   <!--Add Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <ul id="err_save"></ul>
            <input type="text" name="name" class="form-control name" placeholder="Enter Name"  aria-describedby="basic-addon1">
            <input type="text" name="email" class="form-control mt-2 email" placeholder="Enter Email"  aria-describedby="basic-addon1">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary add_info">Save</button>
        </div>
      </div>
    </div>
  </div>

     <!--Edit Modal -->
<div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Update</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <input type="text" name="name" class="form-control" placeholder="Enter Name"  aria-describedby="basic-addon1">
            <input type="text" name="email" class="form-control mt-2" placeholder="Enter Email"  aria-describedby="basic-addon1">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Update</button>
        </div>
      </div>
    </div>
  </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
  

  </body>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>

  <script type="text/javascript">
    $(function () {
      
      var table = $('.data-table').DataTable({
          processing: false,
          serverSide: false,
      });
      
    });
  </script>
  <script>
    $(document).ready(function () {

    // fetch data
    fetchdata();
     function fetchdata(){
       $.ajax({
         type: "get",
         url: "/fetch_data",
         dataType: "json",
         success: function (response) {
          //  console.log(response.users);
          $('tbody').html("");
          $.each(response.users, function (key, item) { 
             $('tbody').append(
               '<tr>\
                <td>'+item.id+'</td>\
                <td>'+item.name+'</td>\
                <td>'+item.email+'</td>\
                <td>\
                    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#exampleModal1">Edit</button>\
                    <button type="button" class="btn btn-danger">Delete</button>\
                </td>\
              </tr>');
          });
         }
       });
     }

    // end fetch data

     $(document).on('click','.add_info', function (e) {
       e.preventDefault();
      //  console.log('hello');
      var data = {
        'name':$('.name').val(),
        'email':$('.email').val(),
      }
      // console.log(data);

      $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
        type: "POST",
        url: "/userspost",
        data: data,
        dataType: "json",
        success: function (response) {
          if(response.status == 400)
          {
            $('#err_save').html("");
            $('#err_save').addClass("alert alert-danger");
            $.each(response.errors, function (key, err_val) { 
              $('#err_save').append('<li>'+err_val+'</li>');
           });
          }else{
            $('#err_save').html("");
            $('#success').addClass('alert alert-success');
            $('#success').text(response.massage)
            $('#exampleModal').modal('hide');
            $('#exampleModal').find('input').val("");
            fetchdata();
          }
          
        }
      });
     });
    });
  </script>
</html>