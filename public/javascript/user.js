var _user = {
    init: function () {
        this.load();
    },
    load: function () {

        $('.select2-primary').select2();
        
        $('#datatable').DataTable({
            ajax: '/users',
            order: [[0, 'asc']],
            columns: [
                {
                    name: 'fullname',
                    render: function (data, type, row) {
                        var middleName = row['middlename'] != null ? row['middlename'] : "";
                        return '<span>' + row['lastname'] + ' , ' + row['firstname'] + " " + middleName + '</span>';
                    },
                    width: '50%',
                    "defaultContent": "",
                },
                {
                    data: 'username',
                    name: 'username',
                    "defaultContent": ""
                },
                {
                    data: 'id',
                    name: 'id',
                    orderable: false,
                    searchable: false,
                    width: '5%',
                    render: function (data, type, row) {
                        var name = row['lastname'] + ', ' + row['firstname']

                        var button = '<div class="btn-group mb-1">';
                        var edit = '<button type="button" class="btn btn-primary btn-sm" onclick="userModal(' + data + ')"><i class="far fa-edit"> Edit&nbsp;</i></button>';
                        var destroy = '<button type="button" class="btn btn-danger btn-sm" data-name="' + name + '" onclick="destroy(' + data + ', this)"><i class="far fa-trash-alt"> Delete</i></button>';
                        var reset = '<button type="button" class="btn btn-warning btn-sm" onclick="resetPassword(' + data + ')"><i class="far fa-edit"> &nbsp;Reset</i></button>';
                        return button + reset + edit + destroy + "</div>"
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
                url: '/users',
                method: 'POST',
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                dataType: "JSON",
                success: function (response) {
                    if (response === 200) {
                        toastr.success('User database has been updated.')
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
        $("#modal-title").append('Add User');
        $('#form')[0].reset();
        $("#username").attr('readOnly', false);
        $('#modal').modal('toggle');
        $('#id').val('').trigger('change');

    } 
    else {

        $("#modal-title").append('Edit User');
        $("#username").attr('readOnly', true);
        //this will request the details of the given id
        $.ajax({
            url: '/users/' + id,
            method: 'GET',
            dataType: "JSON",
            success: function (response) {
                //console.log(response);
            
                $.each(response, function (index, value) {
                    if (index === 'is_admin') {
                        // Select the correct option based on the value of is_admin
                        console.log(value);
                        if (value === 1) {
                            $("#roles").val(1).trigger('change');
                        } else {
                            $("#roles").val(0).trigger('change');
                        }
                    } else {
                        // Set other values in the form
                        $("#" + index).val(value);
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

function resetPassword(id) {
    Swal.fire({
        title: "Do you want to change this user password to default?",
        text: "Default: password",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Reset"
    }).then((result) => {
        if (result.isConfirmed) {
        
            $.ajax({
                type: "GET",
                url: '/users/reset-password/' + id,
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (response) {
                    $('#datatable').DataTable().ajax.reload(null, false);
                    toastr.success("User's password has been successfully reset")
                    resetModal.modal('hide')
                },
            });
        }
    }); 
}

function destroy(id) {
    Swal.fire({
        title: "Are you sure to delete user?",
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
                url: 'users/' + id,
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (response) {
                    $('#datatable').DataTable().ajax.reload(null, false);
                    toastr.success('User has been deleted successfully.')
                },
                complete: function () {
                    $('#modal-delete').modal('hide');
                }
            });
        }
    }); 
}


_user.init();