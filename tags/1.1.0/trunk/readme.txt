=== PCI Vault Forms ===
Contributors: pcivault
Donate link: https://pcivault.io/
Tags: pci, dss, pci-dss, credit-card, creditcard, tokenization
Requires at least: 4.3.1
Tested up to: 6.0.1
Stable tag: 1.1.0
License: MIT
License URI: https://opensource.org/licenses/MIT

Securely capture card data using [PCI Vault](https://pcivault.io), which is a vendor neutral PCI DSS compliant environment.

== Description ==

Securely [capture payment card data](https://docs.pcivault.io/developers/capturing-card-data/) from your site using PCI Vault. PCI Vault is a vendor neutral PCI DSS compliant environment.

Data captured with this plugin will be sent to PCI Vault's DSS compliant database directly, and will not be present on your own server. This allows you to securely capture and [tokenize credit card](https://pcivault.io) data without being PCI DSS compliant.

= How it Works =

The plugin comes with a short code that loads PCI Vault's own [Payment Card Data (PCD) form](https://api.pcivault.io/pcd/how-to-capture-and-tokenize-payment-card-data.html), and makes all the necessary requests to the [PCI Vault API](https://api.pcivault.io) in order to get the form working. You can read more on the API side of things [here](https://docs.pcivault.io/developers/capturing-card-data/).

Take note that this includes 2 paid API requests: 1 when the form loads, and 1 when the data is being sent to PCI Vault.

To use this plugin, add your authorisation details, and the user/passphrase for a key, in the PCI Vault Options menu. You can then load the capture form anywhere in your site by using the `pcivault_capture` shortcode.

= Shortcode Attributes =

All valid short code attributes are imported directly into the javascript that renders the form. The security of these attributes are the responsibility of the site, and not PCI Vault.

Every attribute must be a valid Javascript expression. We recommend to use function calls that return the values you want the attributes to have, this will grant extra flexibility and avoid issues with Wordpress's sanitisation.

The attribute options are:

* success_callback: A JS function to call if the card was successfully stored.
* error_callback: A JS function to call if the card was not successfully stored.
* extra_data: Extra data to store along with the card, must be a valid JS object. This is where using a JS function call really helps.
* show_card: A true/false value on whether or not to show the card on the form.
* disable_luhn: A true/false value on whether to disable validation on all form fields.
* force_keypad: A true/false value on whether to force the user to use a randomised on-screen keypad for entering card numbers. This helps to protect you from key-loggers.
* field_options: A configuration object for specifying which of the form fields to show or validate.

For more information on these fields, please check the documentation for PCI Vault's [Payment Card Data (PCD) form](https://api.pcivault.io/pcd/how-to-capture-and-tokenize-payment-card-data.html).

= PCI Vault =

All of the magic behind this plugin happens on PCI Vault's environment.

This plugin sends an authenticated request to PCI Vault, retrieving a [unique capturing endpoint](https://docs.pcivault.io/developers/capturing-card-data/#step-1-create-a-unique-endpoint).

This request includes your authentication details, and the key/passphrase pair specified in the PCI Vault Options menu.

This plugin also loads a [hosted PCD form](https://api.pcivault.io/pcd/how-to-capture-and-tokenize-payment-card-data.html) from PCI Vault.

You need to be a customer of PCI Vault for this plugin to work. You can [view our pricing](https://pcivault.io/#pricing) and [register an account](https://pcivault.io/register).

Also have a look at our [Terms of Service](https://pcivault.io/terms/) and our [Privacy Policy](https://pcivault.io/privacy/).

== FAQ ==

= I would like to have additional functionality =

This plugin is still in it's infancy. Your feedback will be much appreciated.

If you need additional functionality in order to use this form, please let us know.

= What if I want to capture sensitive data that is not credit card data? =

PCI Vault can securely store any JSON formatted data. If you would like to store another type of data, please let us know. We can easily add other types of form to the plugin.

= What if I want to see the data I have in the vault? =

You can query [PCI Vault API](https://api.pcivault.io) directly from your browser.

It is also possible to add query functionality to the plugin. Please let us know if this interests you.

== Screenshots ==

1. The PCD form.
2. When the user fills in their CVV number, the card flips.
3. The form after the data has been captured.

== Changelog ==

= 1.1.0 (2022-12-23) =
* Expand shortcode attributes to give more control over the card form

= 1.0.2 (2022-08-22) =
* Reduce required Wordpress version from 5.7.0 to 4.3.1

= 1.0.1 (2022-08-22) =
* Reduce required Wordpress version from 6.0.1 to 5.7.0

= 1.0.0 (2022-08-17) =
* Initial version
