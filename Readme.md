# Magento Product Redirect
This module saves some important attributes before a product is deleted. When this product's url is called the next time, instead of a 404-Error a page is being displayed telling the customer that the product is no longer available and redirecting him to other, similar, products.

## Installation

Add `require` and `repositories` sections to your composer.json as shown in example below and run `composer update`.

*composer.json example*

```
{
    ...
    
    "repositories": [
        {"type": "git", "url": "https://github.com/kirchbergerknorr/Kirchbergerknorr_ProductRedirect"},
    ],
    
    "require": {
        "kirchbergerknorr/Kirchbergerknorr_ProductRedirect": "*"
    },
    
    ...
}
```

## Usage

In Magento Backend you will find the configuration under System -> Configuration -> Kirchbergerknorr -> General -> Product Redirect.
There you can activate the module and choose which HTTP response code you would like to display on the page. In general we recommend 410 (Gone).

## Support

Please [report](https://github.com/kirchbergerknorr/Kirchbergerknorr_ProductRedirect/issues/new) new bugs or improvements. We are aware that this module is no final solution and consider it as a beta. 
The configurable attributes are not tested yet in storeview context. We will improve this module as soon as we face new issues or requirements.