<?php 

/*3df07*/ 

 

 


/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'successc_madhusudhi.in' );

/** Database username */
define( 'DB_USER', 'successc_madhusudhi' );

/** Database password */
define( 'DB_PASSWORD', 'Manohar@123' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'MXMS~l*M,28}lp);]G8U]`I8L-1hinI3p#f~LQCMSQ#mNJ2g[)Tj;mf/&9ecw,,1' );
define( 'SECURE_AUTH_KEY',  '[v[CT#W%V`E(4ha4?m^/EEauUItP4)Z&K@:Rl6UP/v h?jcoA`.(%2+!J0Ut!s4(' );
define( 'LOGGED_IN_KEY',    '( S[n-4|D:@4^sfvj|$DfVX2,YD<K`&!8.aAn<{KXYUAvMF_}T^:D)oST0z9&Qeo' );
define( 'NONCE_KEY',        '31ajBF49DHiaF>4YiF.i2]*GBJ]npcUTZ-V9U!=&0:@Kmmp>6K(X)PFns0c!OFgT' );
define( 'AUTH_SALT',        'jUJ-LVEQBELNFF.XX6GDhW=7LpCe72b=Xf&M}NX&MU XFwkE![xq2Ss:T_m$.elO' );
define( 'SECURE_AUTH_SALT', '}Zz-G?VEUeSNCC&;#gP},UQ skm,10)H]e0jX7W4=cSyUh;{;xRxN1Q]v]:hM}CB' );
define( 'LOGGED_IN_SALT',   '$|q0Jn99jr>wK.`Gl:5$&;4QqP9Qvh;*#{(}*mZKF!IOi.Js,-6V4ceb#BLi~#Ec' );
define( 'NONCE_SALT',       'sjj#Y~g{FjU/3X[5{$[ob06QL#-R7 >=7k>~uIeqO(8V2[mr3CJ)(G~R~e(kFu=n' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'madhu';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

define ('WP_MEMORY_LIMIT', '256M');
/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
