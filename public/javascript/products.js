var _products = {
    init: function () {
        this.load();
    },
    load: function () {

        $('.select2-primary').select2();
        
        $('#datatable').DataTable({
            ajax: '/products',
            order: [[1, 'asc']],
            columns: [
                {
                    data: 'image',
                    name: 'image',
                    render: function (data, type, row) {
                        if (data) {
                            var imageUrl = '/storage/' + data;
                            return '<img src="' + imageUrl + '" width="120" height="120" alt="Product Image">';
                        } else {
                            return 'No Image';
                        }
                    }
                },
                {
                    data: 'item_code',
                    name: 'item_code',
                    "defaultContent": ""
                },
                {
                    data: 'color',
                    name: 'color',
                    "defaultContent": ""
                },
                {
                    data: 'size',
                    name: 'size',
                    "defaultContent": ""
                },
                {
                    data: 'status',
                    name: 'status',
                    "defaultContent": "",
                    render: function (data, type, row) {
                        if (type === 'display' || type === 'filter') {
                            let statusLabels = {
                                'Available': '<span class="badge badge-success">Available</span>',
                                'Reserved': '<span class="badge badge-warning">Reserved</span>',
                                'Sold': '<span class="badge badge-danger">Sold</span>',
                            };
                            return statusLabels[data] || '<span class="badge badge-light">Unknown</span>';
                        }
                        return data;
                    }
                },
                {
                    data: 'mine_price',
                    name: 'mine_price',
                    "defaultContent": "",
                    render: function(data, type, row) {
                        // Format the number with the peso sign and two decimal places
                        return data ? '₱' + parseFloat(data).toLocaleString('en-US', { style: 'decimal', minimumFractionDigits: 2, maximumFractionDigits: 2 }) : '-';
                    }
                },
                {
                    data: 'lock_price',
                    name: 'lock_price',
                    "defaultContent": "",
                    render: function(data, type, row) {
                        // Format the number with the peso sign and two decimal places
                        return data ? '₱' + parseFloat(data).toLocaleString('en-US', { style: 'decimal', minimumFractionDigits: 2, maximumFractionDigits: 2 }) : '-';
                    }
                },
                {
                    data: 'miner',
                    name: 'miner',
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
                // Wrap table
                $("#datatable").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");
                
                // Apply Filters
                $('#status-filter').on('change', function () {
                    var status = $(this).val();
                    var table = $('#datatable').DataTable();
                    table.column(4).search(status).draw(); // Column 2 is for 'status'
                });
        
                $('#color-filter').on('change', function () {
                    var color = $(this).val();
                    var table = $('#datatable').DataTable();
                    table.column(2).search(color).draw(); // Column 0 is for 'color'
                });
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
                url: '/products',
                method: 'POST',
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                dataType: "JSON",
                success: function (response) {
                    if (response === 200) {
                        toastr.success('Products database has been updated.')
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
        $("#modal-title").append('Add Product');
        $('#form')[0].reset();
        $('#modal').modal('toggle');
        $('#id').val('').trigger('change');
        $('#image_upload').show();
        $('#size').val('').trigger('change');
    } 
    else {

        $("#modal-title").append('Edit Product');
        $('#image_upload').hide();
        //this will request the details of the given id
        $.ajax({
            url: '/products/' + id,
            method: 'GET',
            dataType: "JSON",
            success: function (response) {
                console.log(response);
                $.each(response, function (index, value) {
                    console.log(response);
                    if (index === 'image') {
                        return;  // Skip processing for the image field
                    }
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
        title: "Are you sure to delete product?",
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
                url: 'products/' + id,
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (response) {
                    $('#datatable').DataTable().ajax.reload(null, false);
                    toastr.success('Product has been deleted successfully.')
                },
                complete: function () {
                    $('#modal-delete').modal('hide');
                }
            });
        }
    }); 
}

_products.init();