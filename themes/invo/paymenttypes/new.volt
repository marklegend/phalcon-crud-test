<form action="/paymenttypes/create" role="form" method="post">
    <ul class="pager">
        <li class="previous pull-left">
            {{ link_to("paymenttypes", "&larr; Go Back") }}
        </li>
        <li class="pull-right">
            {{ submit_button("Save", "class": "btn btn-success") }}
        </li>
    </ul>

    <div class="center scaffold">
        <h2>Create payment types</h2>

        <div class="clearfix">
            <label for="name">Name</label>
            {{ text_field("name", "size": 24, "maxlength": 70) }}
        </div>
    </div>
</form>