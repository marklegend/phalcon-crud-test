<div class="row mb-3">
    <div class="col-xs-12 col-md-6">
        <h2>Search payments</h2>
    </div>
    <div class="col-xs-12 col-md-6 text-right">
        {{ link_to("payments/new", "Create Payment", "class": "btn btn-primary") }}
    </div>
</div>

<form action="/payments/search" role="form" method="get">
    {% for element in form %}
        {% if is_a(element, 'Phalcon\Forms\Element\Hidden') %}
            {{ element }}
        {% else %}
            <div class="form-group">
                {{ element.label() }}
                <div class="controls">
                    {{ element.setAttribute("class", "form-control") }}
                </div>
            </div>
        {% endif %}
    {% endfor %}

    {{ submit_button("Search", "class": "btn btn-primary") }}
</form>
