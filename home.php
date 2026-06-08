<?php
/**
 * Blog index page (when set as "Posts page" in WordPress Settings > Reading).
 * Uses archive.php for the actual rendering.
 *
 * @package Lumea
 */

defined( 'ABSPATH' ) || exit;

include get_theme_file_path( 'archive.php' );
