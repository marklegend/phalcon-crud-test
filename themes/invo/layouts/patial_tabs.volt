{% set tabs = [
    [
        'controller': 'invoices',
        'action': 'index',
        'title': 'Invoices',
        'uri': '/invoices/index'
    ],
    [
        'controller': 'customers',
        'action': 'index',
        'title': 'Customers',
        'uri': '/customers/index'
    ],

    [
    'controller': 'payments',
    'action': 'index',
    'title': 'Payments',
    'uri': '/payments/index'
    ],
   
    [
        'controller': 'paymenttypes',
        'action': 'index',
        'title': 'Invoice lines',
        'uri': '/paymenttypes/index'
    ],

    [
        'controller': 'invoices',
        'action': 'profile',
        'title': 'Your Profile',
        'uri': '/invoices/profile'
    ]
] %}

<ul class="nav nav-tabs mb-3">
    {% for controller, tab in tabs %}
        <li class="nav-item">
            <a class="nav-link {% if tab['controller'] == dispatcher.getControllerName()|lower and tab['action'] == dispatcher.getActionName() %}active{% endif %}" href="{{ tab['uri'] }}">
                {{ tab['title'] }}
            </a>
        </li>
    {% endfor %}
</ul>
