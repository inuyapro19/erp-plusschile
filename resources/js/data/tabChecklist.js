export const tabsCheck = [
    {
        "title": "Categorias",
        "id": "categorias",
        "active": true,
        "href": "#categorias",
        "ariaControls": "home",
        "ariaSelected": "true"
    },
    {
        "title": "Tipos",
        "id": "tipos",
        "active": false,
        "href": "#tipos",
        "ariaControls": "home",
        "ariaSelected": "true"
    },
    {
        "title": "Items",
        "id": "items",
        "active": false,
        "href": "#items",
        "ariaControls": "home",
        "ariaSelected": "true"
    },
]

export const tabContentCheck = [
    {
        "id": "categorias",
        "component": "Categorias",
        "ariaLabelledby": "categorias-tab",
        "active": true
    },
    {
        "id": "tipos",
        "component": "Tipos",
        "ariaLabelledby": "tipos-tab",
        "active": false
    },
    {
        "id": "items",
        "component": "Items",
        "ariaLabelledby": "items-tab",
        "active": false
    }]
