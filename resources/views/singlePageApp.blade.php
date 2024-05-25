
@extends('layouts.app')
@section('content')

    <div class="container mt-3">
        <h3 class="row justify-content-center">Laravel + jQuery Crud Operations</h3>
        <p id="respanel"></p>
        <!-- Button to Open the Modal -->
        <div class="d-flex justify-content-end p-3">
            <button id="newModal" type="button" class="btn " style="color:white; border: 1px solid black; background: linear-gradient(to right, #ff7e5f, #feb47b);" data-bs-toggle="modal" data-bs-target="#myModal">
                Add Employees
            </button>
        </div>

        <!-- The Modal -->
        <div class="modal fade" id="myModal">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Add Employee Record</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <form id="myForm">
                            <input type="hidden" name="id" id="id">
                            <div class="mb-3 mt-3">
                              <label for="name" class="form-label">Name:</label>
                              <input type="name" class="form-control" id="name" placeholder="Enter name" name="name">
                            </div>
                            <div class="mb-3 mt-3">
                              <label for="email" class="form-label">Email:</label>
                              <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
                            </div>
                            <div class="mb-3">
                              <label for="pwd" class="form-label">Password:</label>
                              <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pswd">
                            </div>
                            <div class="mb-3">
                                <label for="mobile" class="form-label">Mobile:</label>
                                <input type="number" class="form-control" id="mobile" placeholder="Enter number" name="mobile">
                              </div>

                            <button type="submit" id="submit" class="btn btn-success">Submit</button>
                          </form>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </div>




    </div>

    <div class="container">
        <div class="row justify-content-center mt-10">
            <div class="col-md-8">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered">
                        <thead class="table-success">
                            <th>Sr No</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Password</th>
                            <th colspan="2" align="center">Action</th>
                        </thead>
                        <tbody id="employee_data">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script>
    $(document).ready(function() {

        $('#newModal').on('click', function(){
            $('#myForm')[0].reset();
            $('#id').val('');
            $('#submit').text('Submit')
        });
        // save record
        $('#myForm').on('submit', function(e) {
            e.preventDefault();

            var data = $('#myForm').serialize();
            $.ajax({
                url: "{{ route('saveData') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    data: data
                },
                success: function(response) {
                    $('#respanel').html(response);
                    $('#myForm')[0].reset();
                    $('#myModal').modal('hide');
                    fetchrecords();
                }
            });
        });
        // Update Record
        $(document).on('click', '.btn-warning', function(e){
            e.preventDefault();
            var id = $(this).val();
            // alert(id);
            $.ajax({
                url: "{{route('editData')}}",
                type: "POST",
                data:{
                    "_token": "{{csrf_token()}}",
                    id: id,
                },
                success: function(response){
                    // alert(response.name);
                    $('#myForm')[0].reset();

                    $('#id').val(response.id);
                    $('#name').val(response.name);
                    $('#email').val(response.email);
                    $('#mobile').val(response.mobile);
                    $('#pwd').val(response.password);

                    $('.btn-success').text('Update');
                    $('#myModal').modal('show');
                }
            });
        });
        // delete record
         $(document).on('click', '.btn-danger', function(e){
            e.preventDefault();
            var id = $(this).val();
            // alert(id);
            $.ajax({
                url: "{{route('deleteData')}}",
                type: "POST",
                data:{
                    "_token": "{{csrf_token()}}",
                    id: id,
                },
                success: function(response){
                    $('#respanel').html(response);
                    fetchrecords();
                }
            });
        });
        // fetch record
        function fetchrecords(){
            $.ajax({
                url: "{{ route('getData') }}",
                type: "GET",
                success: function(response){
                    // console.log(response);
                    var tr = '';
                    for(var i = 0; i<response.length; i++){
                        var id = response[i].id;
                        var name = response[i].name;
                        var email = response[i].email;
                        var mobile = response[i].mobile;
                        var password = response[i].password;

                        tr += '<tr>';
                        tr += '<td>'+id+'</td>';
                        tr += '<td>'+name+'</td>';
                        tr += '<td>'+email+'</td>';
                        tr += '<td>'+mobile+'</td>';
                        tr += '<td>'+password+'</td>';

                        tr += '<td><button type="button" class="btn btn-warning" value="'+id+'">Edit</button></td>';
                        tr += '<td><button type="button" class="btn btn-danger" value="'+id+'">Delete</button></td>';
                        tr += '</tr>';
                    }
                    $('#employee_data').html(tr);
                }
            });
        }
        fetchrecords();
    });
</script>

@endpush
