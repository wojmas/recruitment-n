# RecruitmentTasks_ProductCustomSku


## Features
Magento 2 module for managing custom SKU product attribute with history tracking.

## Installation
Not needed, just copy the module to your Magento 2 installation.

## Posible TODOS
- attribute varchar (128) not text, should be enough for sku, can be discussed,
- move plugin to adminhtml if we are not using api to modify products, and remove part about apiuser id,
- ignore history changes when there is empty entry? custom_sku is empty,
- move RetentionConfig to folder Config if there is nneed for more configuration getters,
- add command to remove history from cli, move removing logic from CleanCustomSkuHistory to custom model and use it in both cron and command,
- if there is a lot of history entries, we can optimize removal process by implementing batch processing
- config for crontab schedule,
- in this module i presented different approach to phpdoc,
