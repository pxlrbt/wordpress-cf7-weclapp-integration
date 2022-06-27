# WeClapp Integration for Contact Form 7
Contributors: pixelarbeit
Tags: contact form 7, cf7, weclapp, contact form 7 addon, contact form 7 integration, crm
Tested up to: 5.4
Requires at least: 4.6
Requires PHP: 5.5
Stable tag: 1.2.2
License: GPLv3 or later
License URI: https://www.gnu.org/licenses/gpl-3.0.html

Send user form input to WeClapp to add new contacts/leads/customers recipients.

## Description

This plugin adds the possibility for sending user form input to WeClapp to add new contacts/leads/customers recipients. It adds a WeClapp configuration section to every form, where you can map your contact form 7 fields to WeClapp fields.

## Installation

1. Upload the plugin files to the `/wp-content/plugins/cf7-weclapp` directory, or install the plugin through the WordPress plugins screen directly.
1. Activate the plugin through the 'Plugins' screen in WordPress

## Configuration
1. Create an api token inside WeClapp: Avatar > My Settigs > API Token
1. Set the WeClapp api token and tenant via Settings -> CF7 to WeClapp
1. Configure forms via Contact -> "Your form" > WeClapp tab

## Links
- [Github Repository](https://github.com/pxlrbt/wordpress-cf7-weclapp-integration/)
- [WordPress Plugin Directory](https://wordpress.org/plugins/cf7-weclapp-integration/)

## Screenshots

1. WeClapp form configuration

## Changelog

### 1.2.2
* Security: Update dependencies

### 1.2.1
* Fix: Patch autoloader files to prevent collision

### 1.2
* Refactor: Use Guzzle, Monolog, Notifier
* Fix: Fix API payload

### 1.1
* Move settings page

### 1.0
* First version
