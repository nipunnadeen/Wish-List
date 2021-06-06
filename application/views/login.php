<?php


?>

<html>
<body>

<div class="loginView" id="loginArea" style="margin-left: 30%;margin-top: 10%;font-size: 20px">

        <div class="createWishListView" id="createWishListForm">
            <div class="mb-3 row">
                <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                    <input type="text" name="email" class="form-control" id="inputEmail"
                           placeholder="Enter Email" style="width: 30%" required>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
                <div class="col-sm-10">
                    <input type="password" name="password" class="form-control" id="inputPassword"
                           placeholder="Enter Password" style="width: 30%" required>
                </div>
            </div>
            <div id="loginValidation" style="color: red"></div>
            <div class="mb-3 row">
                <div class="col-sm-10">
                    <button class="btn btn-success" id="login" style="width: 51%">Login</button>
                </div>
            </div>
        </div>
</div>

<script type="text/javascript" lang="javascript">

    let Login = Backbone.Model.extend({
        urlRoot: '/WishListApplication/index.php/api/user/authenticateUsers',
        idAttribute: null,
    })

    let LoginView = Backbone.View.extend(
        {
            el: '#loginArea',
            initialize: function () {

            },
            render: function () {
                return this;
            },
            events: {
                "click #login": 'loginUser'
            },
            loginUser: function () {
                let email = $('#inputEmail').val();
                let password = $('#inputPassword').val();

                if(email !== "" && password !== ""){
                    let logg = new Login();
                    let loginDetails = {email: email, password: password};
                    logg.save(loginDetails,{
                        async: false,
                        success: function(logg) {
                            window.location.replace("/WishListApplication/index.php/wishList");
                        },
                        error: function() {
                            $("#loginValidation").text("Please enter correct email and password");
                        }
                    });
                }else{
                    $("#loginValidation").text("Please enter your login details");
                }
            }
        }
    )
    let s = new LoginView();
</script>

</body>

</html>
