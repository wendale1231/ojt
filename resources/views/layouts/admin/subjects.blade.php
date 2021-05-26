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

    <div class="card mt-5">
        <input type="hidden" value="{{ csrf_token() }}" id="_token">
        <div class="card-header">
            Subjects
        </div>
        <div class="card-body">
            <div id="table-alert"></div>
            <div align="right">
                <button type="button" name="add" id="add" class="btn btn-info">Add</button>
            </div>
            <table id="schedule-table" class="teble table-bordered">
                <thead>
                    <th>ID</th>
                    <th>Subject Name</th>
                    <th>Subject Code</th>
                    <th>Subject Unit</th>
                    <th>Subject Hours</th>
                    <th>Subject Year Prerequisite</th>
                    <th>Subject Prerequisite</th>
                    <th>Subject Description</th>
                    <th></th>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                    <th>ID</th>
                    <th>Subject Name</th>
                    <th>Subject Code</th>
                    <th>Subject Unit</th>
                    <th>Subject Hours</th>
                    <th>Subject Year Prerequisite</th>
                    <th>Subject Prerequisite</th>
                    <th>Subject Description</th>
                    <th></th>
                </tfoot>
            </table>
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
                        url:"{{ route('admin.getsubjects') }}",
                        type:"post",
                        data: {_token: $("#_token").val()}
                    }
                });
            }
            $('#add').click(function(){
                var html = '<tr>';
                html += '<td  ></td>';
                html += '<td contenteditable id="data1" ></td>';
                html += '<td contenteditable id="data2" ></td>';
                html += '<td contenteditable id="data3" ></td>';
                html += '<td contenteditable id="data4" ></td>';
                html += '<td contenteditable id="data5" ></td>';
                html += '<td contenteditable id="data6" ></td>';
                html += '<td contenteditable id="data7" ></td>';
                html += '<td  ><button type="button" name="insert" id="insert" class="btn btn-success btn-xs">Insert</button></td>';
                html += '</tr>';
                $('#schedule-table tbody').prepend(html);
            });
            function update_data(id, column_name, value){
                $.ajax({
                    url:"{{ route('admin.updatesubject') }}",
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
            $(document).on('click', '#insert', function(){
                var subject_name = $('#data1').text();
                var subject_code = $('#data2').text();
                var subject_unit = $('#data3').text();
                var subject_hours = $('#data4').text();
                var subject_year_prerequisite = $('#data5').text();
                var subject_prerequisite = $('#data6').text();
                var subject_description = $('#data7').text();
                if(subject_name != ''){
                    $.ajax({
                        url:"{{ route('admin.addsubject') }}",
                        method:"POST",
                        data:{
                            subject_name: subject_name,
                            subject_code: subject_code,
                            subject_unit: subject_unit,
                            subject_description: subject_description,
                            subject_hours: subject_hours,
                            subject_year_prerequisite: subject_year_prerequisite,
                            subject_prerequisite: subject_prerequisite,
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
                        url:"{{ route('admin.deletesubject') }}",
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