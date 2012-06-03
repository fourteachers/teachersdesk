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
define('DB_NAME', 'rantron_teachingdesk');

/** MySQL database username */
define('DB_USER', 'rantron_deskdb');

/** MySQL database password */
define('DB_PASSWORD', 'rhokrules!');

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
define('AUTH_KEY',         'fx~-R\`qE:k;\`=@g2jP|h7Y~YU7c=r/C;\`5pt@-a_aHQjkJ0jq3C;;Qjp?oIO=K99Ew(8H1<DMLWE');
define('SECURE_AUTH_KEY',  'gvb~n(aYwIJE9OYM3j;T:e6$kwcy-oUI_PYf6:awuVVe@CrlTkzseKtCx=Jv^4uY)df');
define('LOGGED_IN_KEY',    '^ncfgc@_\`aQo!?N\`Y~-~o^s(c(n~mE5z)oB5@stFj5cNTLL9P29=SqjB^YF*5h~');
define('NONCE_KEY',        '!W1cxi\`;VxKt=T-q;bA1z\`\`>87o51GQ^z|BdMa/2v5(W|)|jvs-HA)EeT5|hGsI4B');
define('AUTH_SALT',        'EE/j(sECXCFUK/u9^Mwy@GP94shnIzi|q11NJ@XuPi=DEPLqRJub5DzC(MD)32uDx1');
define('SECURE_AUTH_SALT', '1/tV^z;4bJ$rz5Xom4utm(QcLn0/i(AuAQEaZ6!C9AWqhfbl1oqRGc;t$g|L!J=QcPQx');
define('LOGGED_IN_SALT',   'g@=E>UFZN:pxpVi|79Xh-Vm>jpz?caQKW>W9O^XDK-o<oHl!co$qH)t@D-');
define('NONCE_SALT',       'pCH@tfbSR4|e=KqM700-yqD-coEuU#aZHZzG/0)Mi6A#;Qdm)^C5r98@jaY@\`');

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
