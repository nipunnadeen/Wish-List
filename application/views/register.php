<?php


?>

    <html>
    <body>

    <div class="registerView" id="registerForm" style="margin-left: 30%;margin-top: 10%;font-size: 20px">
        <div class="mb-3 row">
            <label for="inputFirstName" class="col-sm-2 col-form-label">First Name</label>
            <div class="col-sm-10">
                <input type="text" name="fname" class="form-control" id="inputFirstName"
                       placeholder="Enter First Name" style="width: 30%" required>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="inputLastName" class="col-sm-2 col-form-label">Last Name</label>
            <div class="col-sm-10">
                <input type="text" name="lname" class="form-control" id="inputLastName"
                       placeholder="Enter Last Name" style="width: 30%" required>
            </div>
        </div>
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
        <div id="registerValidation" style="color: red"></div>
        <div class="mb-3 row">
            <div class="col-sm-10">
                <button class="btn btn-success" id="submitRegister" style="width: 51%">Register</button>
            </div>
        </div>
    </div>

    <script type="text/javascript" lang="javascript">

        let Register = Backbone.Model.extend({
            urlRoot: '/WishListApplication/index.php?/api/user/registerUsers',
            idAttribute: null,
        })
        let RegisterView = Backbone.View.extend(
            {
                el: '#registerForm',
                initialize: function () {

                },
                render: function () {
                    return this;
                },
                events: {
                    "click #submitRegister": 'register'
                },
                register: function () {
                    let fname = $('#inputFirstName').val();
                    let lname = $('#inputLastName').val();
                    let email = $('#inputEmail').val();
                    let password = $('#inputPassword').val();

                    if(email !== "" && password !== "") {
                        if (password.length <= 4) {
                            $("#registerValidation").text("Password length must be more than 4");
                        } else {
                            let reg = new Register();
                            let regDetails = {firstname: fname, lastname: lname, email: email, password: password};
                            reg.save(regDetails, {
                                async: false,
                                success: function () {
                                    window.location.replace("/WishListApplication/index.php/login");
                                },
                                error: function () {
                                    $("#registerValidation").text("Email is already used");
                                }
                            });
                        }
                    }else{
                        $("#registerValidation").text("Please enter your register details");
                    }
                }
            }
        )
        let s = new RegisterView();
    </script>

    </body>

    </html>
<?php
