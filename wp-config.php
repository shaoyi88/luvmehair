<?php define('WP_CACHE', true);
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
define( 'UPLOADS', ''.'uploads' );
// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'luvmehair');

/** MySQL database username */
//define('DB_USER', 'luvmehair');
define('DB_USER', 'root');

/** MySQL database password */
//define('DB_PASSWORD', 'Na3dBdchkNa3pdBpSdc9thk7');
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         '<*FXMmacpLSR)25pZ o>LG{#`8)C/A;(WdKp5#C:>5R}I67w)YfXV.;37N/!fid%');
define('SECURE_AUTH_KEY',  '2`W.nps{S!B4a?LxBHdW`1Bpw/VJ2A?5D7KQC*LXzX,0HMXKL|g($P<4g2~70bb%');
define('LOGGED_IN_KEY',    'O3jcA/TY6?VJB][Z^Wnu|m^Pg}DWU]H5}LVqmSwx-O(m#Qe2H2ORmuvW5KFlkB(+');
define('NONCE_KEY',        'xmF*]U3(]A5mB*gceJu-4UML>w;q+!~x08D*8HQ)}j34e%_7vJ!K,&Mpll?_<rz/');
define('AUTH_SALT',        '{ZeiJ`Pp<1uSJ9PI>ed}Gxxwz895fC?dg8Ch~J`zWep~judF}-s0+&pPUiaH~x;1');
define('SECURE_AUTH_SALT', 'Wz$>[/fj)u|IlBtj{|e%3QRFX+iaQ_]Z}TBOdt%kb5-UWGmkmaH|su^$8XF50H{C');
define('LOGGED_IN_SALT',   'I]%9;(7XaeQ^=gaAkRkxr!AQlfe(x5-3;6d]HKGbcbq~gmW$ccZgjovj2NO,u8z0');
define('NONCE_SALT',       '`Ws_(*5LkNCp8DoS#1_(+wVzr?foISqwkpV^FH}e  L_/yvpTFunk7Qh|?orgS;7');

/**#@-*/

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
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
define('WP_POST_REVISIONS',false);

require_once(ABSPATH . 'wp-settings.php');