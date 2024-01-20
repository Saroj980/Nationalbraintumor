<?php
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
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress2' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

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
define( 'AUTH_KEY',         ' vCti)%E)_fe&(:mb0su_g1biW61-W<6~zS Iv=j&G^]i0aIhvvhT }Cbfzy]YD[' );
define( 'SECURE_AUTH_KEY',  'q<j7Ne<s_vq+(0-HYRqN;)Q8V* jzvqxWnQco6D|@.3F@1,oak$+,ER[TNY):=jX' );
define( 'LOGGED_IN_KEY',    ',rYBY1Z!WVuc{%Ta&Uo{h5k39-e7E8s`k)!w1J/JBT[=_UwOerE.vmi>k$$crP#h' );
define( 'NONCE_KEY',        '<<c(d|{v)i:Tz32@?eV[^2Lhk~4 U@p21kroc,m]{rxjzU,`l&ny]>w ^bn_>WDk' );
define( 'AUTH_SALT',        ',6vt=k[l,n jjDy7AP`U7Uo[fb4~1Y;}]R4yI^nGCW_V4nzV^]>V <!2g+d+bK+2' );
define( 'SECURE_AUTH_SALT', 'YuI]$YIt^,8Y2,sFN8jh:er|-$3io4KMRL@uo,Up6<>kgB},@^q/99I{4Mnb~Pjm' );
define( 'LOGGED_IN_SALT',   'ga%|H6ccPPI9%E$e1&p<e&0NErsoN8P>?<pPPjd9S:tvYzS}/FkYU7c7MG<A+m(I' );
define( 'NONCE_SALT',       'pxA5/K%@y5|fYv>w;Ob?S$0}!Pm$:Y_HVJ9clx;ar^f g:I3FA+dm{qMsb>kbmfI' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
