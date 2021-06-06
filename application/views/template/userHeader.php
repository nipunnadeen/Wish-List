<html>
<head>
    <meta charset="UTF-8">
    <title>Wish List Builder</title>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="/WishListApplication/js/underscore.js" type="text/javascript"></script>
    <script src="/WishListApplication/js/backbone.js" type="text/javascript"></script>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootswatch/4.5.2/cerulean/bootstrap.min.css" integrity="sha384-3fdgwJw17Bi87e1QQ4fsLn4rUFqWw//KU0g8TvV6quvahISRewev6/EocKNuJmEw" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="/WishListApplication/index.php/login">Wish List Builder</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto" style="font-family: 'United Sans Cd Hv',monospace">
            <li class="nav-item" id="viewItems">
                <a class="nav-link" href="/WishListApplication/index.php/wishList" id="view">WISH-LIST</a>
            </li>
            <li class="nav-item" id="signOut">
                <a class="nav-link" href="" id="logout">SIGN OUT</a>
            </li>
        </ul>
    </div>
</nav><br>

<script type="text/javascript" lang="javascript">

    let SignOut = Backbone.Model.extend({
        urlRoot: '/WishListApplication/index.php?/api/user/signOutUsers',
        idAttribute: null,
    })
    let SignOutView = Backbone.View.extend(
        {
            el: '#signOut',
            initialize: function () {

            },
            render: function () {
                return this;
            },
            events: {
                "click #logout": 'signOutUser'
            },
            signOutUser: function () {

                let userData = new SignOut();
                userData.save({}, {
                    async:false,
                    success: function() {
                        window.location.replace("/WishListApplication/index.php/login");
                    },
                    error: function() {
                        console.log('User could not able to sign in!!');
                    }
                });
            }
        }
    )
    let sv = new SignOutView();
</script>
