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
define('DB_NAME', 'quoccuon_quoccuong');

/** MySQL database username */
define('DB_USER', 'quoccuongmykolor');

/** MySQL database password */
define('DB_PASSWORD', 'vien@12345');

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
define('AUTH_KEY',         '[myNw8X+`IS+b3Wj8up:XF-vc%VZ4 e5Z!(TDFj6O4FZ@yC]|gluQxR-DST#fk01');
define('SECURE_AUTH_KEY',  'R%m4(iUp2>Qa3{)[SB?,o6N8Cc+aelTZ<R9 {Bhm@hr}1)K4>c;!)}UXUyzqU}6H');
define('LOGGED_IN_KEY',    '{<<{[{;ABJxf)bCWJ|:OULokYMrMr)5?vvS/L2o+HFB%Rs7Z-bbHI4r):gUXvv)V');
define('NONCE_KEY',        'L-U&{CE.-~Fp$-`&j{-%TH||D [+[xMtbmhe]Z ~@2p$CGD51SSn*e ?OYKDS6^1');
define('AUTH_SALT',        '^|q^sNRSw0PD7@NV!22}I/7R4-33!u5(xM`GZ)jT#<d] - 3+WG@$ET@)>sQ6@XW');
define('SECURE_AUTH_SALT', 'xl%OiE#X+#7min/Oe17U^lC|eN:A79qAElJd1+PZlu{=Z}&!X?L0{Y&44odl.0ca');
define('LOGGED_IN_SALT',   '-m)ps+[hE+mIuvFBCnuWL0R+HjK1|alxj2#6ZAgr(Cq?gr77}m+v1MfK?0-sw!ir');
define('NONCE_SALT',       '&Lh_Az%&z+/Zuv)0]U$+x-,_*V_/>{Pi$eJuhMQfRFFEp?A5 Q8v2}itr#gFY|Dj');

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
require_once(ABSPATH . 'wp-settings.php');
