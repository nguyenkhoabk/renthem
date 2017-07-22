<?php


/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */


// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
// //Added by WP-Cache Manager
 //Added by WP-Cache Manager
define('WP_CACHE', false); //Added by WP-Cache Manager
define( 'WPCACHEHOME', '' ); //Added by WP-Cache Manager
define('DB_NAME', 'renthem');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', 'utf8');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY', 'S0LDvbGZ5HyDV_qVy4v7L5cnsML0yDfoCHcVv3nFyBa99qg14glOnuKxsU74');
define('SECURE_AUTH_KEY', 'f6iqQdt6e4RLp87uahC4fdM1Bv6hx6DoGwlxrJj_TTt_D7Lrz4R6zCnoLUSV');
define('LOGGED_IN_KEY', 'mslMtwZsZ3BsWtNaNdorXB9wInsU2ExYQVNmpbuJFZJ6tvDAhffE1n1bzoMB');
define('NONCE_KEY', 'tGQxp8uHzxQIENz3AAPogGO8nlnppXcklAyOjVDZg6dH0l_H7Ba6PcEgmjms');
define('AUTH_SALT', '9Jo_1Rs2mOG0mZRZHs99uUnK5fljo2w4WxeDe1vSTXeeuaoYxTUL2C1sxB0f');
define('SECURE_AUTH_SALT', 'BH7tLHAT_iwaagMGwmqa4pjHcInMa5LD0dwvq1xAueLZTYJP9TGt8FpBrhGk');
define('LOGGED_IN_SALT', 'W34RLYMZrz6yvJaa9blnrfl2O5tbOAPyZjNr6ennnXmq_aA9zaW7GM4wPx7_');
define('NONCE_SALT', 'nfCBcHeFg92N5m7W6Vqb1pVthN0ac6OQmfGfzYR9dlK1sbX7MRr47pemD2GT');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress.  A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de.mo to wp-content/languages and set WPLANG to 'de' to enable German
 * language support.
 */
define ('WPLANG', 'sv_SE');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

define('WP_SITEURL', 'http://renthem.dev');
define('FORCE_SSL_ADMIN', false);
define('FORCE_SSL_LOGIN', false);
define('FORCE_SSL_CONTENT', true);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
define("WP_CONTENT_URL", "http://static.yourdomain.com");
define("COOKIE_DOMAIN", "www.yourdomain.com");
