## Overview
This Magento 2 extension provides an easy way to change order statuses directly from the admin panel.

## Features
- Change order status with a single click
- Support for multiple order statuses
- AJAX-based status updates

## Installation
WIP - soon composer version

### Manual Installation
1. Create directories: `app/code/Topalovic/Narudzbine`
2. Copy module files
3. Run installation commands:
```bash
bin/magento module:enable Topalovic_Narudzbine
bin/magento setup:upgrade
bin/magento setup:di:compile
bin/magento cache:clean
```

Compatibility
    Magento 2.4.7

Directory structure:
```
app/code/Topalovic/Narudzbine/
├── Block
│   └── Adminhtml
│       └── Order
│           └── View
│               └── StatusButton.php
├── Controller
│   └── Adminhtml
│       └── Order
│           └── ChangeStatus.php
├── etc
│   ├── adminhtml
│   │   ├── routes.xml
│   │   └── menu.xml
│   └── module.xml
├── Model
│   └── Order
│       └── StatusChanger.php
├── view
│   └── adminhtml
│       ├── layout
│       │   └── sales_order_view.xml
│       └── templates
│           └── order
│               └── status_button.phtml
├── composer.json
├── LICENSE.txt
├── README.md
└── registration.php
```

Custom Order Status can be edited/viewed from within Magento 2 Dashboard area:
https://experienceleague.adobe.com/en/docs/commerce-admin/stores-sales/order-management/orders/order-status#custom-order-status