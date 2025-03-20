var _transaction = {
    init: function () {
        this.load();
    },
    load: function () {

        $('.select2-primary').select2();

        this.loadCustomers();
        
        $('#datatable').DataTable({
            ajax: '/transactions',  // This should point to your route for fetching transactions
            order: [[1, 'asc']],  // Default sorting
            columns: [
                { data: 'order_id', name: 'order_id' },
                { data: 'item_code', name: 'item_code' },
                { data: 'customer_name', name: 'customer_name' },
                { data: 'shipping_address', name: 'shipping_address' },
                { data: 'contact_number', name: 'contact_number' },
                { data: 'transaction_date', name: 'transaction_date' },
                { data: 'shipping_fee', name: 'shipping_fee',
                    render: function(data, type, row) {
                        // Format the number with the peso sign and two decimal places
                        return data ? '₱' + parseFloat(data).toLocaleString('en-US', { style: 'decimal', minimumFractionDigits: 2, maximumFractionDigits: 2 }) : '-';
                    }
                },
                { data: 'total_amount', name: 'total_amount',
                    render: function(data, type, row) {
                        // Format the number with the peso sign and two decimal places
                        return data ? '₱' + parseFloat(data).toLocaleString('en-US', { style: 'decimal', minimumFractionDigits: 2, maximumFractionDigits: 2 }) : '-';
                    }
                },
                {
                    data: 'order_status',
                    name: 'order_status',
                    "defaultContent": "",
                    render: function (data, type, row) {
                        if (type === 'display' || type === 'filter') {
                            let statusLabels = {
                                'Pending': '<span class="badge badge-danger">Pending</span>',
                                'Paid': '<span class="badge badge-info">Paid</span>',
                            };
                            return statusLabels[data] || '<span class="badge badge-light">Unknown</span>';
                        }
                        return data;
                    }
                },
                { 
                    data: 'id', 
                    name: 'id', 
                    orderable: false, 
                    searchable: false,
                    render: function(data) {
                        return `<div class="btn-group">
                            <button class="btn btn-primary btn-sm" onclick="updateModal(${data})"><i class="far fa-edit"></i></button>
                            <button class="btn btn-info btn-sm" onclick="downloadPDF(${data})"><i class="fa fa-file"></i></button>
                            <button class="btn btn-danger btn-sm" onclick="destroy(${data})"><i class="far fa-trash-alt"></i></button>
                        </div>`;
                    }
                }
            ],
            initComplete: function (settings, json) {
                $("#datatable").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");

                // Apply Filters
                $('#status-filter').on('change', function () {
                    var status = $(this).val();
                    var table = $('#datatable').DataTable();
                    table.column(8).search(status).draw(); // Column 2 is for 'status'
                });
        
                // Calculate the total price and display it below the table
                let totalPrice = 0;
                let table = this.api();
                
                table.rows().every(function() {
                    let data = this.data();
                    let price = parseFloat(data.total_sales) || 0;
                    totalPrice += price;  // Only summing the price
                });
        
                // Format the total price with the peso sign
                let formattedTotal = '₱' + totalPrice.toLocaleString('en-US', { style: 'decimal', minimumFractionDigits: 2, maximumFractionDigits: 2 });
        
                // Add a new row under the table to display the total price
                $('#datatable tfoot').remove(); // Remove any existing tfoot
                $('#datatable').append('<tfoot><tr><td colspan="10" style="text-align: left;"><strong>Total Sales: ' + formattedTotal + '</strong></tr></tfoot>');
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
                url: '/transactions',
                method: 'POST',
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                dataType: "JSON",
                success: function (response) {
                    if (response === 200) {
                        toastr.success('Transaction Saved!.')
                        $('#datatable').DataTable().ajax.reload(null, false);
                        $('#modal').modal('hide')
                    } else {
                        toastr.error(response);
                    }
                    Swal.close();
                },
            })
        })
        

    },
    loadCustomers: function() {
        $.ajax({
            url: '/customers',  // Make sure this route exists in your web.php
            method: 'GET',
            dataType: 'JSON',
            success: function(response) {
                // Clear any existing options before populating
                $('#customer_id').empty();

                // Add the placeholder option
                $('#customer_id').append('<option value="" disabled selected>Select Customer</option>');

                // Loop through the response and add each customer to the select
                response.data.forEach(function(customer) {
                    $('#customer_id').append('<option value="' + customer.id + '">' + customer.customer_name + '</option>');
                });

                // Reinitialize Select2 after populating the options
                $('#customer_id').select2();
            },
            error: function(xhr, status, error) {
                console.error("Failed to fetch customers:", error);
            }
        });
    }
}

$(document).ready(function () {

    // Initialize product list and load products on page load
    loadProducts(1);

    // Handle product selection change
    $(document).on('change', '.product-select', function () {
        var productId = $(this).val();
        var productIndex = $(this).attr('id').split('_')[2]; // Get the product index
        if (productId) {
            loadPriceOptions(productId, productIndex);
        }
    });

    // Add more product selection fields
    window.addProduct = function() {
        var productIndex = $('#product-selection-container .product-selection').length + 1;
        var newProductSelection = `
            <div class="form-group row product-selection" id="product-selection-${productIndex}">
                <label for="product_id_${productIndex}" class="col-md-1 col-form-label">Product</label>
                <div class="col-md-4">
                    <select class="form-control select2-primary product-select" id="product_id_${productIndex}" name="product_id[]" style="width: 100%;" required>
                        <option value="" disabled selected>Select Product</option>
                        <!-- Product options will be dynamically added here -->
                    </select>
                </div>
                <br><br>
                <label for="price_type_${productIndex}" class="col-md-1 col-form-label">Price</label>
                <div class="col-md-4">
                    <select class="form-control price_type" id="price_type_${productIndex}" name="price_type[]" required>
                        <option value="" disabled selected>Select Price Type</option>
                        <!-- Price options will be dynamically added here -->
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger btn-sm remove-product-btn mt-1" onclick="removeProduct(${productIndex})">Remove</button>
                </div>
            </div>
        `;
        $('#product-selection-container').append(newProductSelection);
        loadProducts(productIndex);  // Load products for the new dropdown
        // Initialize select2 for the newly added product select
        $('#product_id_' + productIndex).select2({
            placeholder: 'Select Product'
        });
    }

    // Remove product selection field
    window.removeProduct = function(productIndex) {
        $('#product-selection-' + productIndex).remove();
    }

    // Load the products into the dropdowns
    function loadProducts(productIndex) {
        $.ajax({
            url: '/products',  // Your route for fetching products
            method: 'GET',
            dataType: 'JSON',
            success: function(response) {
                console.log(response);
                var productSelect = $('#product_id_' + productIndex);
                productSelect.empty();
                productSelect.append('<option value="" disabled selected>Select Product</option>');

                // Filter products by status 'Reserved'
                var reservedProducts = response.data.filter(function(product) {
                    return product.status === 'Reserved';
                });

                // Add filtered products to the dropdown
                reservedProducts.forEach(function(product) {
                    productSelect.append('<option value="' + product.id + '">' + product.item_code + '</option>');
                });
            },
            error: function(xhr, status, error) {
                console.error("Failed to fetch products:", error);
            }
        });
    }

    // Load price options based on the selected product
    function loadPriceOptions(productId, productIndex) {
        $.ajax({
            url: '/products/' + productId,  // Fetch product details by ID
            method: 'GET',
            dataType: 'JSON',
            success: function(response) {
                var product = response;
                var priceSelect = $('#price_type_' + productIndex);
                priceSelect.empty();

                // Add price options (Mine Price and Lock Price)
                if (product.mine_price && product.lock_price) {
                    priceSelect.append('<option value="'+product.mine_price+'">Mine Price</option>');
                    priceSelect.append('<option value="'+product.lock_price+'">Lock Price</option>');
                } else if (product.mine_price) {
                    priceSelect.append('<option value="'+product.mine_price+'">Mine Price</option>');
                } else if (product.lock_price) {
                    priceSelect.append('<option value="'+product.lock_price+'">Lock Price</option>');
                }

                // Reinitialize select2 for the new price type dropdown
                priceSelect.select2();
            },
            error: function(xhr, status, error) {
                console.error("Failed to fetch product details:", error);
            }
        });
    }

});

function userModal(id) {

    $("#modal-title").empty();
    if (id === 0) {
        $("#modal-title").append('Add Transaction');
        $('#form')[0].reset();
        $('#modal').modal('toggle');
        $('#id').val('').trigger('change');
        $('#image_upload').show();
        $('#size').val('').trigger('change');
    } 
    else {

        $("#modal-title").append('Edit Transaction');
        $('#image_upload').hide();
        //this will request the details of the given id
        $.ajax({
            url: '/transactions/' + id,
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
        title: "Are you sure to delete transaction?",
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
                url: 'transactions/' + id,
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (response) {
                    $('#datatable').DataTable().ajax.reload(null, false);
                    toastr.success('Transaction has been deleted successfully.')
                },
                complete: function () {
                    $('#modal-delete').modal('hide');
                }
            });
        }
    }); 
}

function downloadPDF(orderId) {
    // Fetch the transaction details by ID (you can use AJAX to fetch this from your server)
    $.ajax({
        url: `/transactions/${orderId}`, // Use the correct route to fetch the details
        method: 'GET',
        success: function(transaction) {
            console.log(transaction);
            
            const { order_id, items, customer_name, shipping_address, province, city, barangay, contact_number, transaction_date, shipping_fee, total_amount } = transaction.original.data;
            
            // Create a new jsPDF instance
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            // Set margins (small margins)
            const marginLeft = 10;
            const marginTop = 10;
            const marginRight = 10;

            doc.setFont('Arial', 'normal');
            doc.setFontSize(13);

            // Title
            doc.text("Here’s your invoice", 105, marginTop + 5, null, null, 'center');

            // Add Image (right side)
            const imageUrl = '/res/logo.jpg'; // Image stored in the public/res folder (adjust the file name as needed)
            const imageWidth = 30; // Width of the image
            const imageHeight = 30; // Height of the image
            const imageX = 170; // X position (right side)
            const imageY = 10; // Y position (top)

            // Add image to the PDF
            doc.addImage(imageUrl, 'JPEG', imageX, imageY, imageWidth, imageHeight);

            // Customer Information
            doc.setFontSize(8);
            doc.text(`Customer: ${customer_name}`, marginLeft, marginTop + 10);
            doc.text(`Address: ${shipping_address}`, marginLeft, marginTop + 15);
            doc.text(`Province: ${province}`, marginLeft, marginTop + 20);
            doc.text(`City: ${city}`, marginLeft, marginTop + 25);
            doc.text(`Barangay: ${barangay}`, marginLeft, marginTop + 30);
            doc.text(`Contact: ${contact_number}`, marginLeft, marginTop + 35);
            doc.text(`Date: ${transaction_date}`, marginLeft, marginTop + 40);

            // Table headers
            const headers = ['Item Code', 'Price'];
            const headerHeight = 55;  // Reduced header height for less space
            const rowHeight = 7;  // Reduced row height for less padding
            const columnWidths = [30, 30]; // Adjust the width of the columns

            // Draw the table headers with a border
            doc.setFontSize(9);
            doc.rect(marginLeft, headerHeight, columnWidths[0], rowHeight); // Left column border
            doc.rect(marginLeft + columnWidths[0], headerHeight, columnWidths[1], rowHeight); // Right column border
            doc.text('Item Code', marginLeft + 3, headerHeight + 5);  // Adjusted position
            doc.text('Price', marginLeft + columnWidths[0] + 3, headerHeight + 5);  // Adjusted position

            // Add items to the table with borders
            let yPosition = headerHeight + rowHeight;
            items.forEach(item => {
                doc.rect(marginLeft, yPosition, columnWidths[0], rowHeight); // Left column border
                doc.rect(marginLeft + columnWidths[0], yPosition, columnWidths[1], rowHeight); // Right column border
                doc.text(item.item_code, marginLeft + 3, yPosition + 5);  // Adjusted text position
                doc.text(parseFloat(item.price).toFixed(2), marginLeft + columnWidths[0] + 3, yPosition + 5); // Adjusted text position
                yPosition += rowHeight;
            });

            // Shipping Fee row with border
            const totalRowHeight = 7; // Reduced row height for shipping fee row
            doc.setFontSize(9);
            doc.rect(marginLeft, yPosition, columnWidths[0] + columnWidths[1], totalRowHeight); // Bottom row border
            doc.text('Shipping Fee', marginLeft + 3, yPosition + 5); // Reduced padding
            doc.text(parseFloat(shipping_fee).toFixed(2), marginLeft + columnWidths[0] + 3, yPosition + 5); // Reduced padding

            // Total Amount row with border
            yPosition += totalRowHeight;
            doc.rect(marginLeft, yPosition, columnWidths[0] + columnWidths[1], totalRowHeight); // Bottom row border
            doc.text('Total Amount', marginLeft + 3, yPosition + 5); // Reduced padding
            doc.text(parseFloat(total_amount).toFixed(2), marginLeft + columnWidths[0] + 3, yPosition + 5); // Reduced padding

            // Add the extra text below the table
            const extraTextYPosition = yPosition + totalRowHeight + 5; // Position after the total row
            doc.setFontSize(8); // Smaller font size for the extra text
            doc.text("Cutoff of payment : 48hrs after invoice", marginLeft, extraTextYPosition);
            doc.text("2 DAYS RESERVATION ONLY", marginLeft, extraTextYPosition + 5);
            doc.text("No returns and cancellation policy", marginLeft, extraTextYPosition + 10);
            doc.text("Thank you so much for trusting our shop!", marginLeft, extraTextYPosition + 15);

            // Payment Info (on the right side)
            const paymentTextYPosition = 0 + 20;
            doc.setFontSize(8);
            doc.text("Mode of payment", 130, paymentTextYPosition);

            const paymentDetails = [
                { method: "GCASH", image: '/res/gcash.jpg', name: "Nicole Arizabal", number: "09959019507" },
                { method: "MAYA", image: '/res/maya.jpg', name: "Nicole Arizabal", number: "09959019507" },
                { method: "GOTYME", image: '/res/gotime.jpg', name: "Nicole Arizabal", number: "012695130050" },
                { method: "UNIONBANK", image: '/res/ub.jpg', name: "Nicole Arizabal", number: "1096 6812 3394" },
            ];

            let paymentYPosition = paymentTextYPosition + 10;
            paymentDetails.forEach(payment => {
                doc.addImage(payment.image, 'JPEG', 130 - 35, paymentYPosition, 20, 20); // Adjust image size and position
                doc.text(`${payment.method}:`, 130, paymentYPosition);
                doc.text(`${payment.name}`, 130, paymentYPosition + 5);
                doc.text(`${payment.number}`, 130, paymentYPosition + 10);
                paymentYPosition += 20; // Increment for the next payment method
            });

            doc.text("*Send the SS of your payment", 130, paymentYPosition + 5);

            // Save the PDF
            doc.save('invoice.pdf');
        },
        error: function() {
            alert("Error fetching transaction details.");
        }
    });
}

// Function to open the modal and populate the fields with the order data
function updateModal(orderId) {
    $.ajax({
        url: '/transactions/' + orderId, // Assuming this route returns the details of a transaction by its ID
        method: 'GET',
        dataType: 'JSON',
        success: function(response) {
            const order = response.original.data;
            console.log(order);

            // Set the order ID in the hidden input
            $('#orderId').val(order.order_id);
            // Set the current order status in the dropdown
            $('#orderStatus').val(order.order_status);

            // Show the modal
            $('#updateModal').modal('show');
        },
        error: function(xhr, status, error) {
            console.error('Failed to fetch order details:', error);
        }
    });
}

// Submit the form to update the order status
$('#updateStatusForm').on('submit', function(event) {
    event.preventDefault();

    const orderId = $('#orderId').val();
    const newStatus = $('#orderStatus').val();

    // Send an AJAX request to update the order status
    $.ajax({
        url: '/transactions/order-status/' + orderId,  // Assuming this is your API endpoint for updating an order
        method: 'PUT',
        dataType: 'JSON',
        data: {
            order_status: newStatus,
            _token: $('meta[name="csrf-token"]').attr('content'),
        },
        success: function(response) {
            // Hide the modal
            $('#updateModal').modal('hide');

            // Reload the DataTable to reflect the changes
            $('#datatable').DataTable().ajax.reload();

            // Optionally, you can show a success message
            alert('Order status updated successfully!');
        },
        error: function(xhr, status, error) {
            console.error('Failed to update order status:', error);
            alert('Failed to update order status.');
        }
    });
});



_transaction.init();