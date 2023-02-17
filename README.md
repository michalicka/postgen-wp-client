# Wordpres PostGen Client

A Wordpress plugin client providing API for [PostGen](https://github.com/michalicka/postgen) AI publisher.

## Installation

1. Download and unpack code repository to your Wordpress's `wp-content/plugins/postgen-wp-client/` folder.
2. Enable plugin from admin's Wordpress **Plugins** page.
3. Open **Options** section in admin menu and Postgen Client page to configure plugin.
4. Configure:
    - Enable plugin
    - Enter API KEY
    - Define default category
    - Define WP user ID to assign authorship (use 1 when only admin exists)

## Usage 

1. Configure a new **Site** in PostGen project.
2. Enter API Url e.g. `https://<domain_name>/wp-content/plugins/postgen-wp-client/api.php`
3. Enter the same API key
4. Publish post from PostGen project
5. Check if post was published in Wordpress
