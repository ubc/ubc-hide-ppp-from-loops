<?php
/**
 * Hide Password Protected Posts From Loops
 *
 * @package           UBCHidePPPFromLoops
 * @author            Rich Tape
 * @copyright         2020 Rich Tape
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       Hide Password Protected Posts From Loops
 * Plugin URI:        https://ctlt.ubc.ca/
 * Description:       Hide Password Protected Posts from loops
 * Version:           0.1.0
 * Requires at least: 5.2
 * Requires PHP:      5.6
 * Author:            Rich Tape
 * Author URI:        https://ctlt.ubc.ca/
 * Text Domain:       ubc-hide-ppp
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

/**
 * Hook into the posts_where filter to ensure that the post_password column is
 * set to an empty string. This does not apply in the admin or for those users
 * who can edit private posts.
 *
 * @param string $where The current WHERE MySQL query clause.
 * @return string Potentially modified WHERE clause.
 */
function posts_where__ubc_hide_ppp_from_loops( $where = '' ) {

	if ( is_admin() ) {
		return $where;
	}

	if ( current_user_can( 'edit_private_posts' ) ) {
		return $where;
	}

	$where .= " AND post_password = ''";

	return $where;

}//end posts_where__ubc_hide_ppp_from_loops()

add_filter( 'posts_where', 'posts_where__ubc_hide_ppp_from_loops' );
