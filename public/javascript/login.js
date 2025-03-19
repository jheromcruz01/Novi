var _login = {
    init: function () {
        this.load();
    },
    load: function () {
        $("#login-form").on('submit', function(e) {
            e.preventDefault();
        
            $.ajax({
                url: "/login",
                method: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                dataType: "JSON",
                beforeSend: function() {
                    $("#loginButton").prop("disabled", true);
                },
                success: function(response) {
                    location.replace('/' + response[1]);
                },
                done: function(response) {
                    $("#loginButton").prop("disabled", false)
                },
                error: function(response) {
                    $("#loginButton").prop("disabled", false)
                    $("#loginResult").text(response.responseJSON['message']);
                },
            })
        })
    }
}

_login.init();