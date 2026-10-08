<?php

/**
 * Fuction yang digunakan di theme ini.
 */
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

add_action('after_setup_theme', 'velocitychild_theme_setup', 9);

function velocitychild_theme_setup()
{
	// Pengaturan tema ada di inc/customizer.php (Customizer bawaan, tanpa Kirki).

	register_nav_menus(
		array(
			'secondary' => __('Secondary Menu', 'justg'),
		)
	);

	//remove action from Parent Theme
	remove_action('justg_header', 'justg_header_menu');
	remove_action('justg_do_footer', 'justg_the_footer_open');
	remove_action('justg_do_footer', 'justg_the_footer_content');
	remove_action('justg_do_footer', 'justg_the_footer_close');
}

add_action('justg_before_header', 'justg_header_berita_top');
function justg_header_berita_top()
{
	require_once(get_stylesheet_directory() . '/inc/part-header-top.php');
}
///add action builder part
add_action('justg_header', 'justg_header_berita');
function justg_header_berita()
{
	require_once(get_stylesheet_directory() . '/inc/part-header.php');
}
add_action('justg_do_footer', 'justg_footer_berita');
function justg_footer_berita()
{
	require_once(get_stylesheet_directory() . '/inc/part-footer.php');
}

function get_berita_iklan($idiklan)
{
	$gambar = velocity_berita8_url_gambar(get_theme_mod('image_' . $idiklan, ''));
	echo '<div class="part_' . esc_attr($idiklan) . '">';
	if ($gambar) {
		$link  = (string) get_theme_mod('link_' . $idiklan, '');
		$slot  = velocity_berita8_slot_iklan();
		$label = isset($slot[$idiklan]) ? $slot[$idiklan][0] : __('Iklan', 'justg');
		echo '<div class="mb-3 text-center">';
		echo $link ? '<a href="' . esc_url($link) . '" target="_blank" rel="noopener sponsored">' : '';
		echo '<img class="img-fluid" src="' . esc_url($gambar) . '" alt="' . esc_attr($label) . '" loading="lazy" decoding="async">';
		echo $link ? '</a>' : '';
		echo '</div>';
	}
	echo '</div>';
}

function vdberita_limit_text($text, $limit)
{
	if (str_word_count($text, 0) > $limit) {
		$words = str_word_count($text, 2);
		$pos   = array_keys($words);
		$text  = substr($text, 0, $pos[$limit]) . '...';
	}
	return $text;
}

// Fungsi untuk menambahkan hit ke post meta
function tambahkan_hit_ke_post_meta()
{
	if (is_single()) { // Memeriksa apakah ini halaman single post
		$post_id = get_the_ID();
		$hit_count = get_post_meta($post_id, 'hit', true); // Dapatkan nilai hit sekarang

		if (empty($hit_count)) {
			$hit_count = 1; // Jika belum ada hit sebelumnya, mulai dari 1
		} else {
			$hit_count++; // Jika sudah ada hit sebelumnya, tambahkan 1
		}

		update_post_meta($post_id, 'hit', $hit_count); // Update nilai hit
	}
}

// Menjalankan fungsi saat halaman dimuat
add_action('wp_footer', 'tambahkan_hit_ke_post_meta');

if (!function_exists('justg_get_hit')) {
	function justg_get_hit()
	{
		$hit = get_post_meta(get_the_ID(), 'hit', true);
		echo $hit ? esc_html($hit) : '0';
	}
}

/**
 * Tombol bagikan. justg_share() pindah dari tema induk ke Velocity Addons 2.x; situs dengan
 * Velocity Addons lama + induk baru tidak punya fungsinya (fatal error di artikel).
 */
function velocity_berita8_share()
{
	if (function_exists('justg_share')) {
		return justg_share();
	}
	$url    = rawurlencode(get_permalink());
	$judul  = rawurlencode(get_the_title());
	$tujuan = array(
		'facebook' => array('Facebook', '#2d59a1', 'https://www.facebook.com/sharer/sharer.php?u=' . $url),
		'twitter'  => array('Twitter', '#14171a', 'https://twitter.com/intent/tweet?text=' . $judul . '&url=' . $url),
		'whatsapp' => array('WhatsApp', '#25d366', 'https://wa.me/?text=' . $judul . '%20' . $url),
		'telegram' => array('Telegram', '#0088cc', 'https://t.me/share/url?url=' . $url . '&text=' . $judul),
		'envelope' => array('Email', '#444444', 'mailto:?subject=' . $judul . '&body=' . $url),
	);
	$html = '<div class="berita-share py-2">';
	foreach ($tujuan as $ikon => $t) {
		$html .= '<a class="btn btn-sm text-white rounded-0 me-1 mb-1" style="background:' . esc_attr($t[1]) . '" href="' . esc_url($t[2]) . '" target="_blank" rel="noopener" aria-label="' . esc_attr($t[0]) . '"><i class="fa fa-' . esc_attr($ikon) . '" aria-hidden="true"></i></a>';
	}
	return $html . '</div>';
}
