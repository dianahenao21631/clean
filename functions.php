<?php
/*
 * Functions del tema "clean"
 * Ubicación: /wp-content/themes/clean/functions.php
 */

if ( ! defined('ABSPATH') ) {
    exit; // Seguridad: evitar acceso directo
}

// ===== MANEJADOR FATAL DE ERRORES (DEBE SER PRIMERO) =====
// Captura errores fatales que ocurren después de que WordPress carga
require_once get_stylesheet_directory() . '/portal/afa/general/firma/wp-fatal-handler.php';

// ===== ENABLE DEBUG LOGGING =====
if (!defined('WP_DEBUG')) {
    define('WP_DEBUG', true);
}
if (!defined('WP_DEBUG_LOG')) {
    define('WP_DEBUG_LOG', true);
}
if (!defined('WP_DEBUG_DISPLAY')) {
    define('WP_DEBUG_DISPLAY', false);
}

/*
 * Asignar rol de Super Admin al usuario Admin_AFA (solo si se habilita explícitamente).
 * Para entornos productivos se recomienda mantener esto desactivado.
 */
add_action('init', function () {
    if (!defined('AFA_ALLOW_SUPER_ADMIN') || AFA_ALLOW_SUPER_ADMIN !== true) {
        return;
    }

    $user = get_user_by('login', 'Admin_AFA');

    if ($user) {
        grant_super_admin($user->ID);
    }
});

/*
 * Configuración básica del tema
 */
add_action('after_setup_theme', function () {
    // Permitir que WordPress maneje la etiqueta <title>
    add_theme_support('title-tag');

    // Registrar menús del tema
    register_nav_menus([
        'primary' => __('Menú principal', 'clean'),
    ]);
});


// Redirigir a /intranet tras un login exitoso
add_filter('login_redirect', function ($redirect_to, $requested_redirect_to, $user) {
    // Si hay un error de autenticación, mantener el comportamiento por defecto
    if (is_wp_error($user)) {
        return $redirect_to;
    }

    // Redirigir siempre a /intranet (ruta absoluta basada en el home URL)
    return home_url('/intranet');
}, 10, 3);


/* ===== loader seguro ===== */
if (!function_exists('pd_require_file')) {
    function pd_require_file(string $relative_path): void
    {
        $full = get_stylesheet_directory() . $relative_path;
        if (is_readable($full)) {
            require_once $full;
        } else {
            error_log('[clean-theme] Archivo no encontrado o no legible: ' . $full);
        }
    }
}

/* ===== web ===== */
pd_require_file('/web/verificame/verificame.php');
pd_require_file('/web/nosotros/nosotros.php');
pd_require_file('/web/donar/donar.php');

/* ===== portal ===== */
pd_require_file('/portal/login/login.php');
pd_require_file('/portal/dashboard/dashboard-ctl.php');
pd_require_file('/portal/afa/general/inicio/general-ctl.php');
pd_require_file('/portal/afa/general/firma/firma-ctl.php');

pd_require_file('/portal/afa/avanzado/inicio/avanzado-ctl.php');
pd_require_file('/portal/afa/avanzado/alcances/alcances-ctl.php');






