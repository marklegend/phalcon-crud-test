<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("payments/index", "&larr; Go Back") }}
    </li>
    <li class="pull-right">
        {{ link_to("payments/new", "Create payments") }}
    </li>
</ul>

{% for payment in page.items %}
    {% if loop.first %}
        <table class="table table-bordered table-striped" align="center">
        <thead>
        <tr>
            <th>ID</th>
            <th>Customer ID</th>
            <th>Date created</th>
            <th>Amount</th>
        </tr>
        </thead>
    {% endif %}
    <tbody>
    <tr>
        <td>{{ payment.id }}</td>
        <td>{{ payment.cust_id }}</td>
        <td>{{ payment.date_created }}</td>
        <td>{{ payment.amount }}</td>
        <td width="7%">{{ link_to("payments/edit/" ~ payment.id, '<i class="glyphicon glyphicon-edit"></i> Edit', "class": "btn btn-default") }}</td>
        <td width="7%">{{ link_to("payments/delete/" ~ payment.id, '<i class="glyphicon glyphicon-remove"></i> Delete', "class": "btn btn-default") }}</td>
    </tr>
    </tbody>
    {% if loop.last %}
        <tbody>
        <tr>
            <td colspan="7" align="right">
                <div class="btn-group">
                    {{ link_to("payments/search", '<i class="icon-fast-backward"></i> First', "class": "btn btn-default") }}
                    {{ link_to("payments/search?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class": "btn btn-default") }}
                    {{ link_to("payments/search?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn btn-default") }}
                    {{ link_to("payments/search?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn btn-default") }}
                    <span class="help-inline">{{ page.current }}/{{ page.total_pages }}</span>
                </div>
            </td>
        </tr>
        <tbody>
        </table>
    {% endif %}
{% else %}
    No payments were found...
{% endfor %}
