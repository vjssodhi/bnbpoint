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
define('DB_NAME', 'livebackup');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

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
define('AUTH_KEY', '-xOtHjF)o{Luu?!s_L-/Nxgj}+X/s[LgJ[<^TXwBvV]tor!EgG(>g@xQ_z{DjOVC/p>md>Po(>qgKZiI%WZVs;G%HtZl&O!]ze<V&%o/];?P$^*yVCn-fc/xehUf<jEk');
define('SECURE_AUTH_KEY', 'aqi*BtPqdq{bVUhyu;_j/hOD*rjKc)%Nb|DVIl^Xd_kqKF{%K@dtH[<Za;)GiqPh&w)J(</*kaNFoXe&;f$JQbvGDINYBL&{]Ccx%u[SP>aXZ^EpUP=*Ws)DS%NG}}oQ');
define('LOGGED_IN_KEY', 'N_+A&Wz;v(|>I?Aclq[IX*i]ISp$@Y/)qdWHR*SJHADFBEpVG+Dgc-/QUnjJP_|uP|/XhKcSTvE{$&eCttg@|BFbMjrX&jVza=!jo;PIQi$zEl+=dABanEHQw;q!blwI');
define('NONCE_KEY', 'pS({efwAD-;dUzsZBxZ<bKJg=<y-xz)OtI/Z<oDKcot+TLdm<X<d-]d-LkQ-Y[dThZqUTwpGA)MBEQT(Fu>D[|brP>>V]cxInBU$rhCql]_zM+MMJBnc=&!Goslm[&UA');
define('AUTH_SALT', 'FA)T%&CJl{@=^b)MpB?PLPa=ItZ/V/b}HMhRPaJg<M|i-vGlE<bGt&O$Tcf?PjBT&>jJ@CeVd}xI_h=)|(|/j*hpwwwEhTg%W@Gob%aPhXOc*EARM^$LNOm?Q)N@W^nX');
define('SECURE_AUTH_SALT', '}y{A|=Lp<K;(p$yQ^!wpOFq]W<l%qxwV<ufd)+[}ysLXJoW|D{%YB|xfM*craxDYe**ql[P>Y*gYg+d=&PCaq*cnVu[!mDsw!fQ|zUN=f^K^S&_/=U$<ANm{*Uj^/_QB');
define('LOGGED_IN_SALT', 'T}q%>N]!_S$W%Xg!nZJD_SJo>y%[CU_haq]IoV_xCbm$ELvp<%ILFXOMU+d!^&}ZkvO^s;W)T|ZLpmgV$v=W!%U|D[Z(ybVxr=v?^ao%F=rHuAunVA[-^@<FQ@])?Xfw');
define('NONCE_SALT', '_SMTczTYyT?wck}hOzvlTI*=_naZ-sVq!DaQeHJW@-]Ols&ZOcNf(ttox>zcLfOdj)Z+LDb!=(@jE&Z@Xt@IaGVHa=l[D&OzUa<>k;(FR(Ruyp^^t@e}L=Za/M{|tHdr');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_dmfw_';

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

/**
 * Include tweaks requested by hosting providers.  You can safely
 * remove either the file or comment out the lines below to get
 * to a vanilla state.
 
if (file_exists(ABSPATH . 'hosting_provider_filters.php')) {
	include('hosting_provider_filters.php');
} */
