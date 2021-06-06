<html>
<body>
    <div class="createWishListView" id="createWishListForm" style="margin-left: 30%;margin-top: 10%;font-size: 20px">
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
            <div class="col-sm-10" id="category" style="width: 30%"></div>
        </div>
        <div class="mb-3 row">
            <label for="inputOwner" class="col-sm-2 col-form-label">Owner</label>
            <div class="col-sm-10">
                <input type="text" name="owner" class="form-control" id="inputOwner"
                       placeholder="owner name" style="width: 30%" required>
            </div>
        </div>
        <div id="createListValidation" style="color: red"></div>
        <div class="mb-3 row">
            <div class="col-sm-10">
                <button class="btn btn-success" id="submitCreateWishList" style="width: 51%">Submit</button>
            </div>
        </div>
    </div>

<script type="text/javascript" lang="javascript">
    let AddList = Backbone.Model.extend({
        urlRoot: '/WishListApplication/index.php/api/wishList/lists',
        idAttribute: null,
    })

    let AddListView = Backbone.View.extend(
        {
            el: '#createWishListForm',
            initialize: function () {

            },
            render: function () {
                return this;
            },
            events: {
                "click #submitCreateWishList": 'createList'
            },
            createList: function () {
                let name = $('#inputName').val();
                let description = $('#inputDescription').val();
                let categoryId = $('#inputCategoryid').val();
                let owner = $('#inputOwner').val();

                if(name !== "" && description !== "" && owner !== "") {
                    let wList = new AddList();
                    let addListData = {
                        name: name, description: description, categoryid: categoryId,
                        owner: owner
                    };
                    wList.save(addListData, {
                        async: false,
                        success: function () {
                            window.location.replace("/WishListApplication/index.php/wishList");
                        },
                        error: function () {
                            $("#createListValidation").text("Please try again");
                        }
                    });
                } else {
                    $("#createListValidation").text("Please fill the empty fields");
                }
            }
        }
    )
    let s = new AddListView();
</script>

<!--get categories and populate them on a drop down    -->
<script type="text/javascript" lang="javascript">
    let Categories = Backbone.Collection.extend({
        url: '/WishListApplication/index.php/api/wishList/categories'
    })

    let listCategories = new Categories();
    listCategories.fetch({
        success: function () {
            console.log(listCategories.toJSON());
            new categoriesView({collection: listCategories}).render();
        },
        error: function () {
            console.log('Failed to fetch!');
        }
    });

    let categoriesView = Backbone.View.extend({
        el: $('#category'),
        initialize: function () {
            this.collection.bind("change", this.render, this);
        },
        render: function () {
            let menu = '<select id="inputCategoryid" style="width: 30%">';
            for (let i = 0, modelsLength = this.collection.models.length; i < modelsLength; i++) {
                let id = this.collection.models[i].attributes.id;
                menu += '<option value =' + id + ' >' +
                    this.collection.models[i].attributes.name + '</option>';

            }
            menu += '</select>';
            $(menu).appendTo(this.$el);
            return this;
        }
    });
</script>
</body>
</html>
<?php