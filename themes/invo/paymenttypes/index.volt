<div class="row mb-3">
    <div class="col-xs-12 col-md-6">
        <h2>Search Invoice lines</h2>
    </div>
    <div class="col-xs-12 col-md-6 text-right">
        {{ link_to("paymenttypes/new", "Create invoice line", "class": "btn btn-primary") }}
    </div>
</div>

<form action="/paymenttypes/search" role="form" method="get">
    <div class="form-group">
        <label for="id">Id</label>
        {{ numeric_field("id", "size": 10, "maxlength": 10, "class": "form-control") }}
    </div>

    <div class="form-group">
        <label for="name">Name</label>
        {{ text_field("name", "size": 24, "maxlength": 70, "class": "form-control") }}
    </div>

    {{ submit_button("Search", "class": "btn btn-primary") }}
</form>
