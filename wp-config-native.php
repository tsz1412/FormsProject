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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wp_onurn' );

/** MySQL database username */
define( 'DB_USER', 'wp_i2jts' );

/** MySQL database password */
define( 'DB_PASSWORD', '9*G5K_Njz~8?$#e2' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost:3306' );

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
define('AUTH_KEY', 'd:]5l3ZS3VQK|m]n1[0h/A+Q&x8eXNbL;3uxt56vxlG@Dw~r7~fB9[Zm6@-f4L@m');
define('SECURE_AUTH_KEY', '[]3|ois#Jz6:g:9+z3cj3;]!_vu6SM[8E[!*2p!9AK/qK9R+aL;@~7x9;4:tX/%E');
define('LOGGED_IN_KEY', '4/9lir~&ns6VH8[X4MNN2)36e(qJ4B+re8v0OvGPK2Bj/1Ug6b:y5S:9Bm8:S2EE');
define('NONCE_KEY', '[P55&uz98;6&yMj[S0IKzaMS/Clu9#9s)010V%N_/s*[Upo;[z0)@8Mq2Yj4Lfu8');
define('AUTH_SALT', 'e[A1gw5L959G2-Ml4564&N!8:i8:~Z5MeT!RQ);9~sq_Ka8]&o2Jl):Qle97pvX@');
define('SECURE_AUTH_SALT', '/Mb0W*Y*rcL9efrM8fz7Wb/#7&i4Lc]Q6g0x-_lf:;w1bXgJ9C)bf7C*6]rJ]o:#');
define('LOGGED_IN_SALT', '65(0r4u73-4yOD%9k:hU+6)P1rR98dnU4#u!2dhy]2a3fAAgvK30+186tM%ZQuix');
define('NONCE_SALT', 'I|*95U2NY8@k&_5)zyz_&]/:zuH!(!2JfR45!VsA6W)90d~)b6wH4c8|q@1en%Um');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'uu7aS_';


define('WP_ALLOW_MULTISITE', true);
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
