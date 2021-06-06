<html>
<body>

<div class="whislist">
    <div id="wishListBtn" ></div>
    <input type="text" readonly class="form-control" id="shareUrl" style="width: 40%; margin-left: 30%">
    <div id="addItemBtn" style="margin-top: 2%;margin-bottom: 1%;">
        <div id="addItemSuccessfulValidation" style="color: green"></div>
        <button type="submit" name="addItem" class="btn btn-primary" data-toggle="modal"
                data-target="#addModal" id="add" style="margin-left: 76%">Add Item</button>
    </div>

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
                <th></th>
                <th></th>
            </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>

    <!-- Update Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Item</h5>
                    <button type="button" class="close" id="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times</span>
                    </button>
                </div>
                <div class="modal-body" id="modalData">
                </div>
                <div class="modal-footer">
                    <div id="updateItemValidation" style="color: red"></div>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="remove">Close</button>
                    <button type="submit" class="btn btn-primary" id="update">Update</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="addItemForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Item</h5>
                    <button type="button" class="close" id="addClose" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Title</label>
                        <input type="text" name="title" class="form-control" id="inputTitle"
                               placeholder="Enter The Title" required>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Phone Number</label>
                        <input type="text" name="description" class="form-control" id="inputDescription"
                               placeholder="Enter The Description" required>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Priority</label>
                        <div class="col-sm-10" id="priority"></div>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Quantity</label>
                        <input type="number" name="quantity" class="form-control" id="inputQuantity" min="1"
                               placeholder="0" required>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Price</label>
                        <input type="text" name="price" class="form-control" id="inputPrice">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">URL</label>
                        <input type="text" class="form-control" id="inputUrl">
                    </div>
                </div>
                <div class="modal-footer">
                    <div id="addItemValidation" style="color: red"></div>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="addRemove">Close</button>
                    <button type="submit" class="btn btn-success" id="submitAddItem">Submit</button>
                </div>
            </div>
        </div>
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
    <td>
        <button type="submit" name="checkout" class="btn btn-info" data-toggle="modal"
                data-target="#editModal" id="edit">Edit</button>
    </td>
    <td>
        <button class="btn btn-danger" id="delete">Delete</button>
    </td>
</script>


<script>
    // If user is not logged in the application will be redirect to login page
    let UserLoggedIn = Backbone.Model.extend({
        url: '/WishListApplication/index.php/api/user/loggedInUsers'
    })

    let userData = new UserLoggedIn();
    userData.fetch({
        async : false,
        success: function() {
        },
        error: function() {
            window.location.replace("/WishListApplication/index.php/login");
        }
    });
</script>

<!-- This script has all the table works-->
<script>
    // get all items
    let WishListItems = Backbone.Collection.extend({
        url: '/WishListApplication/index.php/api/wishListItem/items'
    })

    let items = new WishListItems();
    items.fetch({
        success: function() {
            new wishListItemsTableView({collection: items}).render();
        },
        error: function() {
            console.log('Failed to fetch!');
        }
    });

    //a table view to render the list of employees
    let wishListItemsTableView = Backbone.View.extend({
        el: $('#tableData'),
        initialize: function() {
            this.collection.bind("add", this.render, this);
        },
        //this creates new rows in the table for each model in the collection
        render: function() {
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

    // Delete button mekanism
    let DeleteView = Backbone.View.extend(
        {
            el: '#tableData',
            initialize: function () {},
            render: function () {  return this; },
            events: {
                "click #delete": 'deleteItem'
            },

            deleteItem: function (ev) {
                let $td = $(ev.target).closest('tr').find('td:eq(0)').text();
                let $tr = $(ev.target).closest('tr');

                let DeleteWishListItem = Backbone.Model.extend({
                    url: function (){
                        return '/WishListApplication/index.php/api/wishListItem/deleteItems/'+this.get('id')
                    },
                })

                let listItem = new DeleteWishListItem();
                listItem.set('id',$td);
                listItem.destroy();

                $tr.remove();
            }
        }
    )
    let d = new DeleteView();


    // Update button mekanism
    let UpdateView = Backbone.View.extend(
        {
            el: '#tableData',
            initialize: function () {},
            render: function () {  return this; },
            events: {
                "click #edit": 'updateItem'
            },

            updateItem: function (ev) {
                let $td = $(ev.target).closest('tr').find('td:eq(0)').text();

                let SpecificItem = Backbone.Model.extend({
                        url: function (){
                            return '/WishListApplication/index.php/api/wishListItem/specificitems/'+this.get('itemid')
                        },
                    })

                let item = new SpecificItem({'itemid':$td});

                item.fetch({
                    // async:false,
                    success: function() {
                        console.log(item.toJSON());
                        new UpdateDataView({model: item}).render();
                    },
                    error: function() {
                        console.log('Failed to fetch!');
                    }
                });

                let UpdateDataView = Backbone.View.extend({
                    // async:false,
                    el: '#modalData',
                    initialize: function () {
                        this.model.bind("change", this.render, this)
                    },

                    render: function () {


                        let menu = '<div class="form-group">';
                        menu += '<input type="hidden" name="itemId" class="form-control" id="inputId" value='+$td+' required>';
                        menu += '<label for="recipient-name" class="col-form-label">Title</label>';
                        menu += '<input type="text" name="title" class="form-control" id="inputTitle" value='+item.get('title')+' required>';
                        menu += '</div>';

                        menu += '<div class="form-group">';
                        menu += '<label for="recipient-name" class="col-form-label">Description</label>';
                        menu += '<input type="text" name="description" class="form-control" id="inputDescription" value='+item.get('description')+' required>';
                        menu += '</div>';

                        menu += '<div class="form-group">';
                        menu += '<label for="recipient-name" class="col-form-label">Priority</label>';
                        menu += '<div class="col-sm-10" id="priority"></div>';
                        menu += '</div>';

                        menu += '<div class="form-group">';
                        menu += '<label for="recipient-name" class="col-form-label">Quantity</label>';
                        menu += '<input type="number" name="quantity" min="1" class="form-control" id="inputQuantity" value='+item.get('quantity')+' required>';
                        menu += '</div>';

                        menu += '<div class="form-group">';
                        menu += '<label for="recipient-name" class="col-form-label">Price</label>';
                        menu += '<input type="text" name="price" class="form-control" id="inputPrice" value='+item.get('price')+' required>';
                        menu += '</div>';

                        menu += '<div class="form-group">';
                        menu += '<label for="recipient-name" class="col-form-label">URL</label>';
                        menu += '<input type="text" name="url" class="form-control" id="inputUrl" value='+item.get('url')+' required>';
                        menu += '</div>';

                        $(menu).appendTo(this.$el);

                        let Priorities = Backbone.Collection.extend({
                            url: '/WishListApplication/index.php/api/wishList/priorities'
                        })

                        let itemPriorities = new Priorities();
                        itemPriorities.fetch({
                            success: function () {
                                new prioritiesView({collection: itemPriorities}).render();
                            },
                            error: function () {
                                console.log('Failed to fetch!');
                            }
                        });

                        let prioritiesView = Backbone.View.extend({
                            el: $('#priority'),
                            initialize: function () {
                                this.collection.bind("change", this.render, this);
                            },
                            render: function () {
                                let menu = '<select id="inputPriorityid" style="width: 125%" class="form-control">';
                                for (let i = 0, modelsLength = this.collection.models.length; i < modelsLength; i++) {
                                    let id = this.collection.models[i].attributes.id;

                                    if(item.get('priorityid') !== id){
                                        menu += '<option value =' + id + ' >' +
                                            this.collection.models[i].attributes.name + '</option>';
                                    } else {
                                        menu += '<option selected value =' + id + ' >' +
                                            this.collection.models[i].attributes.name + '</option>';
                                    }
                                }
                                menu += '</select>';
                                $(menu).appendTo(this.$el);

                                return this;
                            }
                        });

                        return this;
                    }
                });
            }
        }
    )
    let u = new UpdateView();
</script>

<!--Get priorities for add item modal and set them to drop down-->
<script type="text/javascript" lang="javascript">

    // Get priorities for add item modal and set them to drop down
    let PriorityView = Backbone.View.extend(
        {
            el: '#addItemBtn',
            initialize: function () {},
            render: function () {  return this; },
            events: {
                "click #add": 'addItem'
            },

            addItem: function (ev) {

                let Priorities = Backbone.Collection.extend({
                    url: '/WishListApplication/index.php/api/wishList/priorities'
                })

                let itemPriorities = new Priorities();
                itemPriorities.fetch({
                    success: function () {
                        new prioritiesView({collection: itemPriorities}).render();
                    },
                    error: function () {
                        console.log('Failed to fetch!');
                    }
                });

                let prioritiesView = Backbone.View.extend({
                    el: $('#priority'),
                    initialize: function () {
                        this.collection.bind("change", this.render, this);
                    },
                    render: function () {
                        let menu = '<select id="inputPriorityid" style="width: 125%" class="form-control">';
                        for (let i = 0, modelsLength = this.collection.models.length; i < modelsLength; i++) {
                            let id = this.collection.models[i].attributes.id;
                            menu += '<option value =' + id + ' >' +
                                this.collection.models[i].attributes.name + '</option>';

                        }
                        menu += '</select>';
                        $(menu).appendTo(this.$el);
                        console.log(this);
                        return this;
                    }
                });
            }
        }
    )
    let p = new PriorityView();
</script>



<!-- Add item data-->
<script type="text/javascript" lang="javascript">
    let AddItem = Backbone.Model.extend({
        urlRoot: '/WishListApplication/index.php/api/wishListItem/items',
        idAttribute: null,
    })

    let AddItemView = Backbone.View.extend(
        {
            el: '#addItemForm',
            initialize: function () {

            },
            render: function () {
                return this;
            },
            events: {
                "click #submitAddItem": 'addItem'
            },
            addItem: function () {
                let title = $('#inputTitle').val();
                let description = $('#inputDescription').val();
                let priorityId = $('#inputPriorityid').val();
                let quantity = $('#inputQuantity').val();
                let price = $('#inputPrice').val();
                let url = $('#inputUrl').val();

                if(title !== "" && description !== "" && url !== "") {
                    if (!isNaN(parseFloat(price))) {
                        let itm = new AddItem({
                            title: title, description: description, priorityid: priorityId,
                            quantity: quantity, price: price, url: url
                        });
                        itm.save();

                        location.reload();
                    } else {
                        $("#addItemValidation").text("Please enter price value");
                    }
                } else {
                    $("#addItemValidation").text("Please fill the empty fields");
                }
            }
        }
    )
    let add = new AddItemView();
</script>


<!-- update item data-->
<script type="text/javascript" lang="javascript">
    let UpdateItem = Backbone.Model.extend({
        urlRoot: '/WishListApplication/index.php/api/wishListItem/items',
        idAttribute: "id",
    })

    let UpdateItemView = Backbone.View.extend(
        {
            el: '#editModal',
            initialize: function () {

            },
            render: function () {
                return this;
            },
            events: {
                "click #update": 'updateItemData'
            },
            updateItemData: function () {
                let id = $('#inputId').val();
                let title = $('#inputTitle').val();
                let description = $('#inputDescription').val();
                let priorityId = $('#inputPriorityid').val();
                let quantity = $('#inputQuantity').val();
                let price = $('#inputPrice').val();
                let url = $('#inputUrl').val();

                if(title !== "" && description !== "" && url !== "") {
                    if (!isNaN(parseFloat(price))) {
                        let userRegister = new UpdateItem({'id': id});
                        let userDetails = {
                            itemid: id,
                            title: title,
                            description: description,
                            priorityid: priorityId,
                            quantity: quantity,
                            price: price,
                            url: url
                        };
                        userRegister.save(userDetails, {
                            async: false,
                            success: function () {
                                location.reload();
                            }
                        })
                    } else {
                        $("#updateItemValidation").text("Please enter price value");
                    }
                } else {
                    $("#updateItemValidation").text("Please fill the empty fields");
                }
            }
        })
    let upd = new UpdateItemView();
</script>

<script>
    // check whether their is a wish list or not for current user
    let WishListDetails = Backbone.Model.extend({
        url: '/WishListApplication/index.php/api/wishList/lists'
    })

    let listData = new WishListDetails();
    listData.fetch({
        success: function() {
            new CheckList({model: listData}).render();
        },
        error: function() {
            new CheckList({model: listData}).render();
        }
    });

    let CheckList = Backbone.View.extend({
        el: '#wishListBtn',
        initialize: function () {
            this.model.bind("change", this.render, this)
        },

        render: function () {
            if(Object.entries(listData.attributes).length !== 0){
                let menu = '<a href="/WishListApplication/index.php/updateWishList"><button class="btn btn-success" id="updateWishList" style="margin-left: 15%">Update Wish List</button></a>';
                $(menu).appendTo(this.$el);
                $("#shareUrl").attr("value", window.location.hostname+"/WishListApplication/index.php/view#/"+listData.attributes.uuid);
                return this;
            } else {
                let menu = '<a href="/WishListApplication/index.php/createWishList"><button class="btn btn-success" id="createWishList" style="margin-left: 15%">Create Wish List</button></a>';
                $("#add").attr("hidden", true);
                $("#shareUrl").attr("hidden", true);
                $(menu).appendTo(this.$el);
                return this;
            }
        }
    });
</script>

<script type="text/javascript" lang="javascript">
    $(document).ready(function () {    //this function is for remove the all favourite properties from local storage
        $('#close').on('click', function () {
            location.reload();
        });
        $('#remove').on('click', function () {
            location.reload();
        });
        $('#addClose').on('click', function () {
            location.reload();
        });
        $('#addRemove').on('click', function () {
            location.reload();
        });
    });
</script>
</body>
</html>