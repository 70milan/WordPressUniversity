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

// ** MySQL settings ** //
if (file_exists(dirname(__FILE__). '/local.php')){


//local db settings

define( 'DB_NAME', 'local' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );



}else{


//live db settings

define( 'DB_NAME', 'milanb32_uniData' );

/** MySQL database username */
define( 'DB_USER', 'milanb32_bar' );

/** MySQL database password */
define( 'DB_PASSWORD', 'Qwerty7' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );



}


/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'KJcqFOWF7W+n0NJPODDHDGxuTuZKbtNUVztdG7TqpF0YuxrZ+Od4kC7CovhifUK2CqfvQtip0iz/LiyF3zj+Cw==');
define('SECURE_AUTH_KEY',  'yd2Dz5vmYKOBESd1W3I3j3G60j3qgKHmCNMzSFN9n5vCDSWhSQ8M9eITiGZvjaHh7Sd7p614j8a32mtF1E4otQ==');
define('LOGGED_IN_KEY',    'd1Q/yA0cKA0rXA1PVLS44WzIVldIeQJS7MGDbTEE6UXHZHrNW/v03h+N2qLM5rcmgyJ6hcIw7u/sYAlet8qDiQ==');
define('NONCE_KEY',        'qQQm+8dX2eToeuvdGKtVMbS8mtuz+M7LXwmHSJDJZsI/E8czK94VAAWnnHVnVGBuASn52LFGIXDbUbs3Rt94fw==');
define('AUTH_SALT',        'uMTfnJkf3EIidNfkg+HapcYjMKlIEKcDFBSQX4HantEKKFmJASyXSvP6x7ytr2txP0LZgqV5fLnXj5i9nncuqw==');
define('SECURE_AUTH_SALT', 'KLnZc/X4S558J56azKK1VuxcFvLb/vH+ygvqMYuGKGkSBUTtTJU/y/sM1tZbaVfB/FB2otLp5IJr+vi8BDpkKQ==');
define('LOGGED_IN_SALT',   '2QOnHkM5wfReuieA5b8Fzx1rZy4Q4pBOFOKUf2CQS3sZf1TO9JlgAilOrcjrGkivEAoixA53OmDv2CQVGpFuNA==');
define('NONCE_SALT',       '1fTDysFexZIniJqGJ39wn3Ju79SSvg/zxaqUxnU/NQDJss3uz7ESRHoPPYvAsSngHof5RGy/nI4yiqS/16ZPTA==');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';




/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) )
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
