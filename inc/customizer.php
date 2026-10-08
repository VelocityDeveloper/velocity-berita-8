<?php

/**
 * Pengaturan Berita 8 di Customizer bawaan WordPress (tanpa Kirki).
 *
 * Nama theme mod sama dengan versi Kirki (color_theme, image_iklan_*, link_iklan_*,
 * link_sosmed_*, title_posts_home_*, cat_carousel_home, cat_posts_home_*) supaya nilai
 * yang sudah tersimpan tetap terbaca sesudah tema diperbarui.
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/** Warna bawaan tema (bawaan field Kirki color_theme versi lama). */
define('VELOCITY_BERITA8_WARNA', '#740106');

/**
 * Slot iklan yang benar-benar ditampilkan template: id => [label, keterangan ukuran].
 * Ukuran "WxH" di keterangan dibaca installer untuk membuat banner "Ruang Iklan" seukuran slot.
 */
function velocity_berita8_slot_iklan()
{
    return array(
        'iklan_header'       => array('Iklan Header', 'Iklan Header 728x90'),
        'iklan_home_2'       => array('Iklan Home', 'Iklan Halaman Depan 300x250'),
        'iklan_home_bawah_1' => array('Iklan Home Bawah 1', 'Iklan Halaman Depan Bawah 600x80'),
        'iklan_home_bawah_2' => array('Iklan Home Bawah 2', 'Iklan Halaman Depan Bawah 600x80'),
        'iklan_content'      => array('Iklan Single', 'Iklan Single post 600x80'),
        'iklan_content_2'    => array('Iklan Single 2', 'Iklan Single post 300x250'),
        'iklan_archive'      => array('Iklan Archive', 'Iklan Arsip post 600x60'),
        'iklan_archive_2'    => array('Iklan Archive 2', 'Iklan Arsip post 600x60'),
    );
}

/** Sosial media: id => [label, tautan bawaan (sama dengan bawaan versi Kirki)]. */
function velocity_berita8_sosmed()
{
    return array(
        'facebook'  => array('Facebook', 'https://facebook.com/'),
        'twitter'   => array('Twitter / X', 'https://twitter.com/'),
        'instagram' => array('Instagram', 'https://instagram.com/'),
        'youtube'   => array('YouTube', 'https://youtube.com/'),
    );
}

/**
 * Blok berita beranda: id => [label, boleh dinonaktifkan].
 * Hanya carousel yang template-nya mendukung disembunyikan (pilihan 'disable', sama dengan versi Kirki).
 */
function velocity_berita8_blok()
{
    return array(
        'carousel_home' => array('Carousel Home', true),
        'posts_home_1'  => array('Posts Home 1', false),
        'posts_home_2'  => array('Posts Home 2', false),
        'posts_home_3'  => array('Posts Home 3 (kolom kiri)', false),
        'posts_home_4'  => array('Posts Home 4 (kolom kanan)', false),
        'posts_home_5'  => array('Posts Home 5 (kolom kanan bawah)', false),
    );
}

function velocity_berita8_sanitize_kategori($value, $setting)
{
    $value = (string) $value;
    if ($value === '' || $value === 'disable') {
        $control = $setting->manager->get_control($setting->id);
        return ($value === '' || ($control && isset($control->choices['disable']))) ? $value : '';
    }
    return term_exists((int) $value, 'category') ? (string) absint($value) : '';
}

add_action('customize_register', 'velocity_berita8_customize_register', 20);
function velocity_berita8_customize_register(WP_Customize_Manager $wp_customize)
{
    $wp_customize->add_panel('panel_berita', array(
        'priority' => 10,
        'title'    => esc_html__('Berita', 'justg'),
    ));

    // Warna.
    $wp_customize->add_section('section_colorberita', array(
        'panel'       => 'panel_berita',
        'title'       => esc_html__('Warna', 'justg'),
        'description' => esc_html__('Kosongkan untuk memakai warna utama tema (Primary Color) atau warna bawaan tema.', 'justg'),
        'priority'    => 10,
    ));
    $wp_customize->add_setting('color_theme', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'color_theme', array(
        'label'   => esc_html__('Warna Tema', 'justg'),
        'section' => 'section_colorberita',
    )));

    // Iklan.
    $wp_customize->add_section('section_iklanberita', array(
        'panel'       => 'panel_berita',
        'title'       => esc_html__('Iklan', 'justg'),
        'description' => esc_html__('Slot tanpa gambar tidak ditampilkan.', 'justg'),
        'priority'    => 20,
    ));
    foreach (velocity_berita8_slot_iklan() as $id => $slot) {
        $wp_customize->add_setting('image_' . $id, array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'image_' . $id, array(
            'label'       => sprintf(esc_html__('Gambar %s', 'justg'), $slot[0]),
            'description' => $slot[1],
            'section'     => 'section_iklanberita',
        )));
        $wp_customize->add_setting('link_' . $id, array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control('link_' . $id, array(
            'type'    => 'url',
            'label'   => sprintf(esc_html__('Link %s', 'justg'), $slot[0]),
            'section' => 'section_iklanberita',
        ));
    }

    // Sosial media.
    $wp_customize->add_section('section_sosmedberita', array(
        'panel'       => 'panel_berita',
        'title'       => esc_html__('Sosial Media', 'justg'),
        'description' => esc_html__('Kosongkan link untuk menyembunyikan ikonnya.', 'justg'),
        'priority'    => 30,
    ));
    foreach (velocity_berita8_sosmed() as $id => $sosmed) {
        $wp_customize->add_setting('link_sosmed_' . $id, array(
            'default'           => $sosmed[1],
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control('link_sosmed_' . $id, array(
            'type'    => 'url',
            'label'   => sprintf(esc_html__('Link %s', 'justg'), $sosmed[0]),
            'section' => 'section_sosmedberita',
        ));
    }

    // Blok berita beranda.
    $wp_customize->add_section('section_homeberita', array(
        'panel'       => 'panel_berita',
        'title'       => esc_html__('Home', 'justg'),
        'description' => esc_html__('Judul kosong = nama kategori yang dipilih.', 'justg'),
        'priority'    => 40,
    ));

    $kategori = array('' => esc_html__('Semua Kategori (terbaru)', 'justg'));
    foreach (get_categories(array('hide_empty' => false)) as $term) {
        $kategori[(string) $term->term_id] = $term->name;
    }

    foreach (velocity_berita8_blok() as $id => $blok) {
        list($label, $bisa_mati) = $blok;
        if ($id !== 'carousel_home') {
            $wp_customize->add_setting('title_' . $id, array(
                'default'           => '',
                'sanitize_callback' => 'sanitize_text_field',
            ));
            $wp_customize->add_control('title_' . $id, array(
                'type'    => 'text',
                'label'   => sprintf(esc_html__('Judul %s', 'justg'), $label),
                'section' => 'section_homeberita',
            ));
        }
        $wp_customize->add_setting('cat_' . $id, array(
            'default'           => '',
            'sanitize_callback' => 'velocity_berita8_sanitize_kategori',
        ));
        $wp_customize->add_control('cat_' . $id, array(
            'type'    => 'select',
            'label'   => sprintf(esc_html__('Kategori %s', 'justg'), $label),
            'section' => 'section_homeberita',
            'choices' => $bisa_mati ? $kategori + array('disable' => esc_html__('Nonaktifkan', 'justg')) : $kategori,
        ));
    }
}

/**
 * Tautan sosmed yang belum pernah disimpan memakai tautan bawaan (seperti bawaan Kirki dulu);
 * isian kosong yang disimpan tetap kosong (ikon disembunyikan).
 */
foreach (array_keys(velocity_berita8_sosmed()) as $velocity_berita8_id) {
    add_filter('theme_mod_link_sosmed_' . $velocity_berita8_id, function ($nilai) use ($velocity_berita8_id) {
        if ($nilai === null || $nilai === false) {
            $sosmed = velocity_berita8_sosmed();
            return $sosmed[$velocity_berita8_id][1];
        }
        return $nilai;
    });
}
unset($velocity_berita8_id);

/**
 * Warna tema: pilihan Customizer Berita, lalu Primary Color induk (diisi installer dari
 * warna klien), lalu warna bawaan tema.
 */
function velocity_berita8_warna()
{
    $warna = sanitize_hex_color((string) get_theme_mod('color_theme', ''));
    if (!$warna) {
        $utama = sanitize_hex_color((string) get_theme_mod('primary_color', ''));
        $warna = ($utama && strtolower($utama) !== '#1e73be') ? $utama : VELOCITY_BERITA8_WARNA;
    }
    return $warna;
}

add_action('wp_head', 'velocity_berita8_css_warna', 100);
function velocity_berita8_css_warna()
{
    printf(
        '<style id="velocity-berita8-warna">:root{--color-theme:%1$s;}.border-color-theme{--bs-border-color:%1$s;}</style>' . "\n",
        esc_attr(velocity_berita8_warna())
    );
}

/** URL gambar iklan; Kirki lama bisa menyimpan id lampiran atau array. */
function velocity_berita8_url_gambar($nilai)
{
    if (is_numeric($nilai)) {
        return (string) wp_get_attachment_url((int) $nilai);
    }
    if (is_array($nilai)) {
        $nilai = isset($nilai['url']) ? $nilai['url'] : (isset($nilai['id']) ? wp_get_attachment_url((int) $nilai['id']) : '');
    }
    return (string) $nilai;
}

/** Id kategori blok untuk WP_Query ('' = semua, 'disable' = blok disembunyikan). */
function velocity_berita8_kategori($id)
{
    $cat = (string) get_theme_mod('cat_' . $id, '');
    if ($cat === 'disable') {
        return 'disable';
    }
    return ($cat === '' || !term_exists((int) $cat, 'category')) ? '' : (string) absint($cat);
}

/**
 * Judul blok: isian Customizer, lalu nama kategori, lalu "Berita Terbaru".
 * "Recent Posts" adalah bawaan versi Kirki, jadi diperlakukan sebagai kosong.
 */
function velocity_berita8_judul($id)
{
    $judul = trim((string) get_theme_mod('title_' . $id, ''));
    if ($judul !== '' && $judul !== 'Recent Posts') {
        return $judul;
    }
    $cat = velocity_berita8_kategori($id);
    $term = ($cat !== '' && $cat !== 'disable') ? get_term((int) $cat, 'category') : null;
    return ($term && !is_wp_error($term)) ? $term->name : __('Berita Terbaru', 'justg');
}

/** Kepala blok beranda: judul + tombol ke arsip kategori (bila kategori dipilih). */
function velocity_berita8_kepala_blok($id)
{
    $cat   = velocity_berita8_kategori($id);
    $judul = velocity_berita8_judul($id);
    echo '<h3 class="widget-title d-flex align-items-center justify-content-between">';
    echo '<span>' . esc_html($judul) . '</span>';
    if ($cat !== '' && $cat !== 'disable') {
        echo '<a class="btn btn-warning btn-sm shadow py-0 px-1" href="' . esc_url(get_category_link((int) $cat)) . '" aria-label="' . esc_attr(sprintf(__('Lihat semua %s', 'justg'), $judul)) . '">';
        echo '<i class="fa fa-angle-right" aria-hidden="true"></i>';
        echo '</a>';
    }
    echo '</h3>';
}
