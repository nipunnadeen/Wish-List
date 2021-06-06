
<html>
<body>
    <div class="updateWishListView" id="updateWishListForm" style="margin-left: 30%;margin-top: 10%;font-size: 20px">
        <div class="mb-3 row">
            <label for="inputName" class="col-sm-2 col-form-label">Name</label>
            <div class="col-sm-10">
                <input type="text" name="name" class="form-control" id="inputName"
                       placeholder="Enter The Name" style="width: 30%" required>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="inputDescription" class="col-sm-2 col-form-label">Description</label>
            <div class="col-sm-10">
                <input type="text" name="description" class="form-control" id="inputDescription"
                       placeholder="Enter The Description" style="width: 30%" required>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="inputCategoryid" class="col-sm-2 col-form-label">Category</label>
            <div class="col-sm-10" id="category">
                <select id="inputCategoryid" style="width: 30%">
                </select>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="inputOwner" class="col-sm-2 col-form-label">Owner</label>
            <div class="col-sm-10">
                <input type="text" name="owner" class="form-control" id="inputOwner"
                       placeholder="name..." style="width: 30%" required>
            </div>
        </div>
        <div id="updateListValidation" style="color: red"></div>
        <div class="mb-3 row">
            <div class="col-sm-10">
                <button class="btn btn-success" id="submitUpdateWishList" style="width: 51%">Update</button>
            </div>
        </div>
    </div>

<script type="text/javascript" lang="javascript">
    let UpdateList = Backbone.Model.extend({
        urlRoot: '/WishListApplication/index.php/api/wishList/lists',
        idAttribute: "id",
    })

    let UpdateListView = Backbone.View.extend(
        {
            el: '#updateWishListForm',
            initialize: function () {

            },
            render: function () {
                return this;
            },
            events: {
                "click #submitUpdateWishList": 'updateList'
            },
            updateList: function () {
                let name = $('#inputName').val();
                let description = $('#inputDescription').val();
                let categoryId = $('#inputCategoryid').val();
                let owner = $('#inputOwner').val();

                if(name !== "" && description !== "" && owner !== ""){
                    let wList = new UpdateList({'id': ""});
                    let listDetails = {
                        name: name, description: description, categoryid: categoryId, owner: owner
                    };
                    wList.save(listDetails, {async: false});
                } else {
                    $("#updateListValidation").text("Please fill the empty fields");
                }

            }
        }
    )
    let s = new UpdateListView();
</script>

<script type="text/javascript" lang="javascript">
    let WishListData = Backbone.Model.extend({
        url: '/WishListApplication/index.php/api/wishList/lists'
    })

    let Categories = Backbone.Collection.extend({
        url: '/WishListApplication/index.php/api/wishList/categories'
    })

    let listCategories = new Categories();
    listCategories.fetch({
        success: function () {
            console.log(listDetails.toJSON());
            new categoriesView({collection: listCategories}).render();
        },
        error: function () {
            console.log('Failed to fetch!');
        }
    });

    let listDetails = new WishListData();
    listDetails.fetch({
        success: function () {
            new wishListDataView({model: listDetails}).render();
        },
        error: function () {
            console.log('Failed to fetch!');
        }
    });

    let wishListDataView = Backbone.View.extend({
        el: $('#createWishListForm'),
        initialize: function () {
            this.render();
        },
        render: function () {

            $("#inputName").attr("value", listDetails.attributes.name);
            $("#inputDescription").attr("value", listDetails.attributes.description);
            $("#inputCategoryid option[value='" + listDetails.attributes.categoryid + "']").attr("selected", "selected");
            $("#inputOwner").attr("value", listDetails.attributes.owner);
            return this;
        }
    });
    let categoriesView = Backbone.View.extend({
        el: $('#inputCategoryid'),
        initialize: function () {
            this.collection.bind("change", this.render, this);
        },
        render: function () {
            let menu = "";
            for (let i = 0, modelsLength = this.collection.models.length; i < modelsLength; i++) {
                let id = this.collection.models[i].attributes.id;
                menu += '<option value =' + id + ' >' +
                    this.collection.models[i].attributes.name + '</option>';
            }
            $(menu).appendTo(this.$el);
            return this;
        }
    });
</script>

</body>
</html>
<?php
