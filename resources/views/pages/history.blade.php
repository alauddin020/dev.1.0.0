@extends('layouts.app')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<!------ Include the above in your HEAD tag ---------->

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    var siteUrl = '{{URL::to('/')}}';
    var search = '';
    function dateSearch(val)
    {
        search = val;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "GET",
            url: siteUrl + "/searchResult",
            data:{
                dateTime: search,
            },
            success: function (data)
            {
                //console.log(data);
                $('#allDataSearch').html(data)
            },error: function (xhr, status, error) {
                console.log(error);
            }
        })
    }
    $(document).ready(function()
    {
        $('#search').keyup(function () {
            search = $(this).val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            if (search.length>0)
            {
                $.ajax({
                    type: "GET",
                    url: siteUrl + "/searchResult",
                    data:{
                        search: search,
                    },
                    success: function (data)
                    {
                        $('#allDataSearch').html(data)
                    },error: function (xhr, status, error) {
                        console.log(error);
                    }
                })
            }
        });
        $(document).on('click', '.pagination a', function (e) {
            e.preventDefault();
            var url = $(this).attr('href').split('page=')[1];
            $.ajax({
                url: siteUrl + "/searchResult?search="+search+"&page="+url,
                success: function (data) {
                    //console.log(search);
                    $('#allDataSearch').html(data)
                }
            });
        });
        $('#selectAll').change(function()
        {
            search = $(this).val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "GET",
                    url: siteUrl + "/searchResult",
                    data: {
                        dataFilter: search,
                    },
                    success: function (data)
                    {
                        $('#allDataSearch').html(data);
                        // alert(data.fa);
                    }
                });
        });
        $( "#datepicker" ).datepicker({
            dateFormat : 'yy-mm-dd',
            changeMonth : true,
            changeYear : true,
            yearRange: '-100y:c+nn',
            maxDate: '-1d'
        });
    });
</script>
@section('content')
    <div class="container-fluid app-body settings-page">
        <div class="row" style="margin-bottom: 1%">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-4">
                                <label for="search"></label>
                                <input type="text" id="search" class="form-control" placeholder="Search">
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label></label>
                                    <input type="text" onchange="dateSearch($(this).val())" id="datepicker" class="form-control" placeholder="Choose">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <select class="form-control" id="selectAll">
                                    <option value="all">All</option>
                                    <option value="upload">Upload</option>
                                    <option value="curation">curation</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
        <div class="row">
            <div class="col-md-12">
                <div id="newData"></div>
                <table class="table table-hover social-accounts" id="allDataSearch">
                    <thead>
                    <tr>
                        <th>Group Name</th>
                        <th>Group Type</th>
                        <th>Account Name</th>
                        <th>Post Text</th>
                        <th>Time</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($posts as $post)
                        <tr>
                            <td>{{$post->groupInfo->name}}</td>
                            <td>{{$post->groupInfo->type}}</td>
                            <td>{{$post->groupInfo->user->name}}</td>
                            <td>{{$post->post_text}}</td>
                            <td>{{$post->created_at}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
