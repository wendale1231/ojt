@extends('layout')


@section('sidebar')
    @include('layouts.admin.includes.sidebar')
@endsection

@section('breadcrumb')
<ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Dashboard</li>
</ol>
<h6 class="font-weight-bolder mb-0">Dashboard</h6>
@endsection

@section('content')

    <div class="card pb-0 mt-5">
        <div class="card-header">
            <h6>Departments</h6>
        </div>
        <div class="card-body">
            <input type="hidden" value="{{ csrf_token() }}" id="_token">
            <div id="table-alert"></div>
            <div align="right">
                <button type="button" name="add" id="add" class="btn btn-info">Add</button>
            </div>
            <div class="table-responsive">
                <table id="schedule-table" class="teble">
                    <thead>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Department Name</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"></th>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function(){
  
            fetch_data();
            function fetch_data(){
                var dataTable = $('#schedule-table').DataTable({
                    "processing" : true,
                    "serverSide" : true,
                    "order" : [],
                    "ajax" : {
                        url:"{{ route('admin.getdepartments') }}",
                        type:"post",
                        data: {_token: $("#_token").val()}
                    }
                });
            }
            $('#add').click(function(){
                var html = '<tr>';
                html += '<td  ></td>';
                html += '<td contenteditable id="data1" ></td>';
                html += '<td  ><button type="button" name="insert" id="insert" class="btn btn-success btn-xs">Insert</button></td>';
                html += '</tr>';
                $('#schedule-table tbody').prepend(html);
            });
            function update_data(id, column_name, value){
                $.ajax({
                    url:"{{ route('admin.updatedepartment') }}",
                    method:"POST",
                    data:{id:id, column_name:column_name, value:value, _token: $("#_token").val()},
                    success:function(data)
                    {
                        $('#table-alert').html('<div class="alert alert-success">'+data+'</div>');
                        $('#schedule-table').DataTable().destroy();
                        fetch_data();
                    }
                });
                setTimeout(function(){
                    $('#table-alert').html('');
                }, 5000);
            }
            $(document).on('blur', '.update', function(){
                var id = $(this).data("id");
                var column_name = $(this).data("column");
                var value = $(this).text();
                update_data(id, column_name, value);
            });
            function check_inputs(){
                var check = true;
                for(var i = 1; i < 2; i++){
                    if($("#data" + i).text() == '') check = false;
                }
                return check;
            }
            $(document).on('click', '#insert', function(){
                var department_name = $('#data1').text();
                if(check_inputs()){
                    $.ajax({
                        url:"{{ route('admin.adddepartment') }}",
                        method:"POST",
                        data:{
                            department_name: department_name,
                            _token: $("#_token").val()
                            },
                        success:function(data){
                            $('#table-alert').html('<div class="alert alert-success">'+data+'</div>');
                            $('#schedule-table').DataTable().destroy();
                            fetch_data();
                        }
                    });
                    setTimeout(function(){
                        $('#table-alert').html('');
                    }, 5000);
                }
                else{
                    alert("Both Fields is required");
                }
            });
            $(document).on('click', '.delete', function(){
                var id = $(this).attr("id");
                if(confirm("Are you sure you want to remove this?")){
                    $.ajax({
                        url:"{{ route('admin.deletedepartment') }}",
                        method:"POST",
                        data:{id:id, _token: $("#_token").val()},
                        success:function(data){
                            $('#table-alert').html('<div class="alert alert-success">'+data+'</div>');
                            $('#schedule-table').DataTable().destroy();
                            fetch_data();
                        }
                    });
                    setTimeout(function(){
                        $('#table-alert').html('');
                    }, 5000);
                }
            });
        });
    </script>
@endsection
