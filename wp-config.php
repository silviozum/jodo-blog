<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'jodo');

/** MySQL database username */
define('DB_USER', 'jodo');

/** MySQL database password */
define('DB_PASSWORD', 'limbo123');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '_~k=BO`7f,LUJ;dbMD??I/QXf)H@46R?keMU`.[ePFlK7ZfR8h9k(0-$!GkJ1=U$');
define('SECURE_AUTH_KEY',  'TM_^c3Fn7XV?V Z2]>.|%f%{{h6!e#h5PbOy,mcNU;xu5t{?t8r7=b*&81WSE%<k');
define('LOGGED_IN_KEY',    '[){_:~H29b.+C+$X340X<UFCw6m!93E]5N]UAv4]&eo+!8i5H-|5!~|;kk.u%XUw');
define('NONCE_KEY',        'iqf|=Z)OQ(1J,G1PxAT1RRH5N%ZCZ@cG(Yp_bw,_IstZ`&]lIW3&|=~cRK>I<Ga;');
define('AUTH_SALT',        ',+{>5dzli> ,dRbkN>{Oa3[`Kfx723zm}.J3gpM6<+LurRY|P].^3i|EXY-D_0T.');
define('SECURE_AUTH_SALT', 'ISTj$J&ty]dErUg0~q_W^mt&s!_`doTW>mTq7j1#)1_4f*hx}CdQGNtxbmaKq&-[');
define('LOGGED_IN_SALT',   'r42&C,nK^_EWKUI8ap`v9}3rO#1f!k.`*^EtfRv1n<-*^4}k#1@pco~V5IXouc{U');
define('NONCE_SALT',       'Us7{%P0qd,!(EusF(8 AzLv{)<Yo<Ud]{3U_bP0u<ZeYJnEm]0IjLo[TrWRNS7ft');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
