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
<div id="content"></div>
<div class="whislist">
    <div class="container-fluid">
        <table class="table" id="tableData" style="width: 70%;margin-left: 15%">
            <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Priority</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Url</th>
            </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

<!-- Table body data-->
<script type="text/template" id="tableBody">
    <td hidden><%= id %></td>
    <td><%= title %></td>
    <td><%= description %></td>
    <td><%= name %></td>
    <td><%= quantity %></td>
    <td>$<%= price %></td>
    <td><a href="<%= url %>"><%= url %></a></td>
</script>

<script>
    // get all shared items
    let uuidCode = window.location.href.split("/").pop();
    let WishListItems = Backbone.Collection.extend({
        url: function (){
            return '/WishListApplication/index.php/api/shareList/shares/'
        },
        // defaults: {'id':0}
    })

    let wishListItemsTableView = Backbone.View.extend({
        el: $('#tableData'),
        initialize: function() {
            this.collection.bind("add", this.render);
        },
        // model: items,
        //this creates new rows in the table for each model in the collection
        render: function() {
            // console.log(this.collection.models)
            _.each(this.collection.models, function(data) {
                this.$el.append(new wishListItemsRowView({
                    model: data
                }).render().el);
            }, this);
            return this;
        }
    });

    //a row view to render each item
    let wishListItemsRowView = Backbone.View.extend({
        tagName: "tr",
        template: _.template($("#tableBody").html()),

        render: function() {
            this.$el.html(this.template(this.model.toJSON()));
            return this;
        }
    });
</script>


<script>
    let shareRouter = Backbone.Router.extend({
        routes:{
            ":uuid":"ShowView"
        },
        ShowView:function(uuid){
            let items = new WishListItems();

            items.fetch({async:false,data:({'uuid':uuid})});
            new wishListItemsTableView({collection: items}).render();
        }
    })
    let projRouterObj= new shareRouter();
    Backbone.history.start();
</script>
