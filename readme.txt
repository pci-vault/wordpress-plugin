=== PCI Vault Forms ===
Contributors: pcivault
Donate link: https://pcivault.io/
Tags: pci, dss, pci-dss, credit-card, creditcard, tokenization
Requires at least: 6.0.1
Tested up to: 6.0.1
Stable tag: 1.0.0
Requires PHP: 7.4
License: MIT
License URI: https://opensource.org/licenses/MIT

Securely capture card data using PCI Vault, which is a vendor neutral PCI DSS compliant environment.

== Description ==

Securely capture card data from your site using PCI Vault. PCI Vault is a vendor neutral PCI DSS compliant environment.
Data captured with this plugin will be sent to PCI Vault's DSS compliant database directly, and will not be present
on your own server at all. This allows you to capture sensitive payment data without having a PCI DSS compliant server.

The plugin comes with a short code that loads PCI Vault's own Payment Card Data(PCD) form, and makes all the necessary
requests to the PCI Vault API in order to get the form working. You can read more on the API side of things [here]: https://docs.pcivault.io/developers/capturing-card-data/
Take note that this includes 2 paid API requests: 1 when the form loads, and 1 when the data is being sent to PCI Vault.

== FAQ ==

= I would like to have additional functionality =

This plugin is still in it's infancy. Your feedback will be much appreciated.
If you need additional functionality in order to use this form, please let us know.

= What if I want to capture sensitive data that is not credit card data? =

The PCIVault can securely store any JSON formatted data. If you would like to store another type of data,
please let us know. We can easily add other types of form to the plugin.

= What if I want to see the data I have in the vault? =

You can query the PCI Vault API directly from your browser [here]: https://api.pcivault.io
It is also possible to add querying functionality to the plugin. Please let us know if you want it.

== Screenshots ==

1. The PCD form.
2. When the user fills in their CVV number, the card flips.
3. The form after the data has been captured.

== Changelog ==

= 1.0.0 (2022-08-17) =
* Initial version
