var _customers = {
    init: function () {
        this.load();
    },
    load: function () {

        $('.select2-primary').select2();
        
        $('#datatable').DataTable({
            ajax: '/customers',
            order: [[0, 'desc']],
            columns: [
                {
                    data: 'submitted_date',
                    name: 'submitted_date',
                    "defaultContent": ""
                },
                {
                    data: 'ig_username',
                    name: 'ig_username',
                    "defaultContent": ""
                },
                {
                    data: 'customer_name',
                    name: 'customer_name',
                    "defaultContent": ""
                },
                {
                    data: 'contact_number',
                    name: 'contact_number',
                    "defaultContent": ""
                },
                {
                    data: 'shipping_address',
                    name: 'shipping_address',
                    "defaultContent": ""
                },
                {
                    data: 'province',
                    name: 'province',
                    "defaultContent": ""
                },
                {
                    data: 'city',
                    name: 'city',
                    "defaultContent": ""
                },
                {
                    data: 'barangay',
                    name: 'barangay',
                    "defaultContent": ""
                },
                
            ],
            initComplete: function (settings, json) {
                $("#datatable").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");
            },
        });

    }
}



_customers.init();