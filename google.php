<html>

<head>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet" type="text/css">
    <script src="https://apis.google.com/js/api:client.js"></script>
    <script>
       
        var startApp = function() {
            gapi.load('auth2', function() {
                // Retrieve the singleton for the GoogleAuth library and set up the client.
                auth2 = gapi.auth2.init({
                    client_id: 'YOUR_CLIENT_ID.apps.googleusercontent.com',
                    cookiepolicy: 'single_host_origin',
                    // Request scopes in addition to 'profile' and 'email'
                    //scope: 'additional_scope'
                });
                console.log("10");
                attachSignin(document.getElementById('customBtn'));
                console.log("fwfew");
            });
        };

        function attachSignin(element) {
            console.log(element.id);
            auth2.attachClickHandler(element, {},
                function(googleUser) {
                    document.getElementById('name').innerText = "Signed in: " +
                        googleUser.getBasicProfile().getName();
                },
                function(error) {
                    alert(JSON.stringify(error, undefined, 2));
                });
        }
    </script>

</head>

<body>
    <!-- In the callback, you would hide the gSignInWrapper element on a
  successful sign in -->
    <div id="gSignInWrapper">
        <span class="label">Sign in with:</span>
        <div id="customBtn">
            <span class="icon"></span>
            <span class="buttonText">Google</span>
        </div>
    </div>
    <div id="name"></div>
    <script>
        startApp();
    </script>
</body>

</html>