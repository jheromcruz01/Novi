var _expenses = {
    init: function () {
        this.load();
    },
    load: function () {

        $('.select2-primary').select2();
        
        $('#datatable').DataTable({
            ajax: '/expenses',
            order: [[0, 'asc']],
            columns: [
                {
                    data: 'item',
                    name: 'item',
                    "defaultContent": ""
                },
                {
                    data: 'qty',
                    name: 'qty',
                    "defaultContent": ""
                },
                {
                    data: 'price',
                    name: 'price',
                    "defaultContent": ""
                },
                {
                    data: 'id',
                    name: 'id',
                    orderable: false,
                    searchable: false,
                    width: '5%',
                    render: function (data, type, row) {
                        var button = '<div class="btn-group mb-1">';
                        var edit = '<button type="button" class="btn btn-primary btn-sm" onclick="userModal(' + data + ')"><i class="far fa-edit"> Edit&nbsp;</i></button>';
                        var destroy = '<button type="button" class="btn btn-danger btn-sm" onclick="destroy(' + data + ', this)"><i class="far fa-trash-alt"> Delete</i></button>';
                        //var reset = '<button type="button" class="btn btn-warning btn-sm" onclick="resetPassword(' + data + ')"><i class="far fa-edit"> &nbsp;Reset</i></button>';
                        return button + edit + destroy + "</div>"
                    },
                    "defaultContent": "",
                },
            ],
            initComplete: function (settings, json) {
                $("#datatable").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");
            },
        });

        $("#form").on('submit', function (e) {
            e.preventDefault();

            Swal.fire({
                title: 'Loading...',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false
            });
    
            $.ajax({
                url: '/expenses',
                method: 'POST',
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                dataType: "JSON",
                success: function (response) {
                    if (response === 200) {
                        toastr.success('Expenses database has been updated.')
                        $('#datatable').DataTable().ajax.reload(null, false);
                        $('#modal').modal('hide')
                    } else {
                        toastr.error(response);
                    }
                    Swal.close();
                },
            })
        })

    }
}

function userModal(id) {

    $("#modal-title").empty();
    if (id === 0) {
        $("#modal-title").append('Add Expenses');
        $('#form')[0].reset();
        $('#modal').modal('toggle');
        $('#id').val('').trigger('change');

    } 
    else {

        $("#modal-title").append('Edit Expenses');
        //this will request the details of the given id
        $.ajax({
            url: '/expenses/' + id,
            method: 'GET',
            dataType: "JSON",
            success: function (response) {
                console.log(response);
                $.each(response, function (index, value) {
                    let field = $("#" + index);
                    if (field.is("select")) {
                        field.val(value).trigger('change'); // Ensure select field is updated properly
                    } else {
                        field.val(value);
                    }
                });
            },
            complete: function (response) {
                $('#modal').modal('toggle');
            }
        })
        $("#id").val(id);
        
    }
}

function destroy(id) {
    Swal.fire({
        title: "Are you sure to delete expenses?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "DELETE",
                url: 'expenses/' + id,
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (response) {
                    $('#datatable').DataTable().ajax.reload(null, false);
                    toastr.success('Expenses has been deleted successfully.')
                },
                complete: function () {
                    $('#modal-delete').modal('hide');
                }
            });
        }
    }); 
}


_expenses.init();