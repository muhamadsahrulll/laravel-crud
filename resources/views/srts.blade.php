<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD SURAT AJAX</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet">
  </head>
</head>
<body>
    
    <div class="container">
            <h1>List Surat</h1>
            <a class="btn btn-success" href="javascript:void(0)" id="createNewSurat" style="float:right">Add</a>
            <table class = "table table-bordered data-table">
                <thead>
                    <tr>
                        <th>Nomor Surat</th>
                        <th>Judul Surat</th>
                        <th>Tanggal</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
    </div>
    <div class="modal fade" id="ajaxModel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalHeading"></h4>
                </div>
                <div class="modal-body">
                    <form id="suratForm" name="suratForm" class="form-horizontal">
                        <input type="hidden" name="surat_id" id="surat_id">
                        <div class="form-group">
                            Nama: <br>
                            <input type="text" class="form-control" id="nama" name="nama" value="" required>
                        </div>

                        <div class="form-group">
                            Tanggal: <br>
                            <input type="date" class="form-control" id="tanggal" name="tanggal" value="" required>
                        </div>
                        <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Simpan</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-kjU+l4N0Yf4ZOJErLsIcvOU2qSb74wXpOhqTvwVx3OElZRweTnQ6d31fXEoRD1Jy" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
</body>
<script type="text/javascript">
    $(function(){
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }
        })
            var table = $(".data-table").DataTable({
            severSide: true,
            processing: true,
            ajax: "{{route('srts.index')}}",
            columns: [
                {data:'DT_RowIndex',name:'DT_RowIndex'},
                {data:'nama',name:'nama'},
                {data:'tanggal',name:'tanggal'},
                {data:'action',name:'action'},
            ]
        });

        $("#createNewSurat").click(function(){
            $("#surat_id").val('');
            $("#suratForm").trigger("reset");
            $("#modalHeading").html("Tambah Surat");
            $('#ajaxModel').modal('show');

        });

        $("#saveBtn").click(function(e){
            e.preventDefault();
            $(this).html('Save');

            $.ajax({
                data:$("#suratForm").serialize(),
                url:"{{route('srts.store')}}",
                type:"POST",
                dataType:'json',
                success:function(data){
                    $("#suratForm").trigger("reset");
                    $('#ajaxModel').modal('hide');
                    table.draw();
                },
                error:function(data){
                    console.log('Error:',data);
                    $("#saveBtn").html('Save');
                }
            });
        });
        $('body').on('click','.deleteSrt',function(){
            var surat_id = $(this).data("id");
            confirm("Apakah kau yakin ingin menghapus data ?");
            $.ajax({
                type:"DELETE",
                url:"{{route('srts.store')}}"+'/'+surat_id,
                success:function(data){
                    table.draw();
                },
                error:function(data){
                    console.log('Error:',data);
                }
            });
        });
        $('body').on('click','.editSrt',function(){
            var surat_id = $(this).data('id');
            $.get("{{route('srts.index')}}"+"/"+surat_id+"/edit",function(data){
                $("modalHeading").html("Edit Surat");
                $('#ajaxModel').modal('show');
                $("#surat_id").val(data.id);
                $("#nama").val(data.nama);
                $("#tanggal").val(data.tanggal);
            });
        });
    });
    
    </script>
</html>