<?php
/**
 * Component: Social Share
 * Task: Reusable social share template part with copy-to-clipboard feedback
 * Author: Claude Code (contributor)
 * Date: 2026-03-14
 *
 * INTEGRATION NOTE: This is a reusable template part.
 * To include: get_template_part('components/social-share/social-share', null, $args);
 * Required: Theme assets are bundled via src/scss/app.scss and src/js/app.js.
 */

declare(strict_types=1);

defined('ABSPATH') || exit;

if (!function_exists('sw_social_share_icon')) {
    /**
     * Render inline SVG icons for social-share actions.
     */
    function sw_social_share_icon(string $icon): string
    {
        $icons = [
            'copy' => '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M15.5495 4.6696C16.8667 3.3468 18.794 3.31924 19.8605 4.39034C20.9298 5.46328 20.9013 7.40338 19.5822 8.72617L17.3564 10.9611C17.231 11.0913 17.1618 11.2654 17.1636 11.446C17.1655 11.6267 17.2382 11.7994 17.3661 11.927C17.494 12.0545 17.6669 12.1267 17.8476 12.128C18.0282 12.1293 18.2022 12.0596 18.3319 11.934L20.5586 9.69898C22.3141 7.93617 22.5346 5.12247 20.837 3.41754C19.1375 1.71168 16.3294 1.93398 14.5721 3.69679L10.1205 8.16766C8.36503 9.93047 8.14456 12.7442 9.84215 14.4482C9.90555 14.5141 9.98145 14.5668 10.0654 14.6031C10.1494 14.6393 10.2397 14.6586 10.3312 14.6596C10.4227 14.6606 10.5134 14.6433 10.5982 14.6089C10.6829 14.5745 10.7599 14.5235 10.8248 14.459C10.8896 14.3944 10.9409 14.3176 10.9758 14.2331C11.0106 14.1485 11.0283 14.0578 11.0277 13.9663C11.0271 13.8749 11.0083 13.7844 10.9725 13.7003C10.9366 13.6162 10.8843 13.54 10.8186 13.4763C9.74937 12.4034 9.77876 10.4633 11.097 9.14047L15.5495 4.6696Z" fill="currentColor"/><path d="M14.4082 9.80094C14.2791 9.67145 14.1038 9.59856 13.9209 9.5983C13.7381 9.59804 13.5626 9.67044 13.4331 9.79956C13.3036 9.92868 13.2307 10.104 13.2305 10.2868C13.2302 10.4697 13.3026 10.6452 13.4317 10.7747C14.501 11.8476 14.4725 13.7868 13.1534 15.1105L8.70089 19.5804C7.38269 20.9032 5.45545 20.9308 4.38894 19.8597C3.31968 18.7868 3.34908 16.8467 4.66728 15.5239L6.89399 13.2889C6.95786 13.2248 7.00848 13.1487 7.04296 13.065C7.07744 12.9813 7.09509 12.8917 7.09492 12.8012C7.09475 12.7107 7.07676 12.6211 7.04197 12.5376C7.00717 12.454 6.95626 12.3781 6.89215 12.3142C6.82803 12.2504 6.75196 12.1998 6.66828 12.1653C6.5846 12.1308 6.49495 12.1131 6.40445 12.1133C6.31394 12.1135 6.22436 12.1315 6.14081 12.1663C6.05726 12.2011 5.98138 12.252 5.91751 12.3161L3.6908 14.5511C1.93534 16.3148 1.71487 19.1276 3.41246 20.8325C5.11189 22.5393 7.92007 22.3161 9.67737 20.5532L14.1299 16.0824C15.8853 14.3205 16.1058 11.505 14.4082 9.80094Z" fill="currentColor"/></svg>',
            'x' => '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M18.6144 3.84325C18.7105 3.73338 18.784 3.60567 18.8308 3.46739C18.8775 3.32912 18.8965 3.183 18.8868 3.03737C18.877 2.89175 18.8387 2.74947 18.7739 2.61866C18.7092 2.48785 18.6193 2.37107 18.5094 2.27499C18.3996 2.17891 18.2718 2.10541 18.1336 2.05869C17.9953 2.01197 17.8492 1.99294 17.7035 2.00269C17.5579 2.01244 17.4156 2.05077 17.2848 2.11551C17.154 2.18025 17.0372 2.27012 16.9411 2.37998L11.2633 8.86858L6.44442 2.44442C6.34093 2.30644 6.20671 2.19444 6.05246 2.1173C5.89821 2.04016 5.72813 2 5.55556 2H1.11111C0.904797 2 0.702518 2.05746 0.526984 2.16594C0.35145 2.27441 0.209627 2.42963 0.117306 2.61418C0.0249848 2.79873 -0.0139868 3.00534 0.00454042 3.21084C0.0230676 3.41634 0.0983527 3.61263 0.222223 3.7777L7.37444 13.3128L1.38558 20.157C1.19152 20.3789 1.09379 20.6693 1.11385 20.963C1.13391 21.2568 1.2701 21.5312 1.49203 21.7252C1.71396 21.9193 2.00431 22.017 2.29804 21.997C2.59177 21.9769 2.8662 21.8407 3.06026 21.6188L8.73667 15.1305L13.5556 21.5547C13.6591 21.6927 13.7933 21.8047 13.9475 21.8818C14.1018 21.9589 14.2719 21.9991 14.4444 21.9991H18.8889C19.0952 21.9991 19.2975 21.9416 19.473 21.8332C19.6486 21.7247 19.7904 21.5695 19.8827 21.3849C19.975 21.2004 20.014 20.9938 19.9955 20.7883C19.977 20.5828 19.9016 20.3865 19.7778 20.2214L12.6256 10.6863L18.6144 3.84325Z" fill="currentColor"/></svg>',
            'whatsapp' => '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path fill-rule="evenodd" clip-rule="evenodd" d="M10.0002 2C15.5229 2 20 6.47721 20 12C20 17.5228 15.5229 22 10.0002 22C8.27004 22 6.64208 21.56 5.22167 20.786L0.812521 21.5256C0.703843 21.5437 0.592366 21.5359 0.487348 21.5026C0.382329 21.4694 0.286595 21.4118 0.208114 21.3345C0.129632 21.2572 0.0704974 21.1623 0.0357198 21.0578C0.000942149 20.9533 -0.00848276 20.842 0.00798519 20.733L0.752005 15.8121C0.253479 14.6031 -0.00188989 13.3077 1.05342e-05 12C1.05342e-05 6.47721 4.47716 2 10.0002 2ZM6.22633 7.06977C5.54263 7.06977 4.97611 7.64651 5.08223 8.35907C5.28311 9.69488 5.87658 12.1563 7.64206 13.9349C9.4877 15.7944 12.1285 16.5898 13.5583 16.9033C14.2987 17.066 14.9303 16.48 14.9303 15.7572V14.0605C14.9304 14.0041 14.9133 13.949 14.8814 13.9025C14.8495 13.856 14.8043 13.8203 14.7517 13.8L12.9285 13.0995C12.8793 13.0807 12.8258 13.0762 12.7741 13.0865L10.9351 13.4456C9.74903 12.8316 9.03093 12.1433 8.6002 11.106L8.94628 9.23163C8.95549 9.18175 8.951 9.1303 8.93327 9.08279L8.24947 7.25116C8.22966 7.19805 8.19412 7.15223 8.14759 7.11983C8.10105 7.08742 8.04575 7.06996 7.98905 7.06977H6.22633Z" fill="currentColor"/></svg>',
            'telegram' => '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M14 2C8.48 2 4 6.48 4 12C4 17.52 8.48 22 14 22C19.52 22 24 17.52 24 12C24 6.48 19.52 2 14 2ZM18.64 8.8C18.49 10.38 17.84 14.22 17.51 15.99C17.37 16.74 17.09 16.99 16.83 17.02C16.25 17.07 15.81 16.64 15.25 16.27C14.37 15.69 13.87 15.33 13.02 14.77C12.03 14.12 12.67 13.76 13.24 13.18C13.39 13.03 15.95 10.7 16 10.49C16.0066 10.4582 16.0058 10.4252 15.9975 10.3938C15.9893 10.3624 15.9738 10.3337 15.95 10.31C15.89 10.26 15.81 10.28 15.74 10.29C15.65 10.31 14.25 11.24 11.52 13.08C11.12 13.35 10.76 13.49 10.44 13.48C10.08 13.47 9.4 13.28 8.89 13.11C8.26 12.91 7.77 12.8 7.81 12.45C7.83 12.27 8.08 12.09 8.55 11.9C11.47 10.63 13.41 9.79 14.38 9.39C17.16 8.23 17.73 8.03 18.11 8.03C18.19 8.03 18.38 8.05 18.5 8.15C18.6 8.23 18.63 8.34 18.64 8.42C18.63 8.48 18.65 8.66 18.64 8.8Z" fill="currentColor"/></svg>',
            'viber' => '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M12 2C6.64 2 3 5.53 3 10.25c0 2.35.96 4.34 2.71 5.72L5.1 19.5a.99.99 0 0 0 .39.97c.3.22.69.27 1.03.13l3.18-1.35c.74.16 1.49.24 2.3.24 5.36 0 9-3.53 9-8.24S17.36 2 12 2Zm0 15.62c-.72 0-1.38-.08-2.03-.24l-.31-.08-2.15.91.41-2.35-.26-.2c-1.57-1.17-2.39-2.82-2.39-4.8 0-3.69 2.88-6.37 6.73-6.37s6.73 2.68 6.73 6.37-2.88 6.26-6.73 6.26Z" fill="currentColor"/><path d="M9.32 7.56c.2-.11.45-.04.57.15l.56.95a.53.53 0 0 1-.13.69l-.37.29c.26.55.63 1.03 1.12 1.45.48.42 1 .72 1.56.92l.29-.38a.53.53 0 0 1 .67-.15l.99.48c.2.1.29.34.2.55-.24.57-.7.98-1.3 1.08-.95.15-2.16-.37-3.52-1.56-1.33-1.17-1.93-2.29-1.8-3.2.08-.53.46-.99 1.16-1.27Z" fill="currentColor"/><path d="M12.77 7.23c1.34.08 2.14.88 2.23 2.2.02.3-.2.55-.5.57-.29.02-.54-.2-.56-.49-.05-.84-.47-1.26-1.3-1.31a.53.53 0 0 1-.5-.56c.02-.3.28-.52.57-.41Z" fill="currentColor"/><path d="M12.6 9.15c.65.05 1.08.46 1.12 1.1.02.29-.2.54-.49.56-.29.02-.54-.19-.56-.49-.02-.19-.11-.28-.31-.3a.53.53 0 0 1-.49-.56c.02-.29.29-.5.57-.31Z" fill="currentColor"/></svg>',
            'facebook' => '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M7.65232 2C5.62892 2 4.00002 3.6289 4.00002 5.65188V18.3481C4.00002 20.3711 5.62892 22 7.65232 22H14.5332V14.1813H12.4664V11.3663H14.5332V8.96126C14.5332 7.07176 15.7554 5.33688 18.569 5.33688C19.7082 5.33688 20.5513 5.44626 20.5513 5.44626L20.4844 8.07502C20.4844 8.07502 19.6252 8.0669 18.6878 8.0669C17.6735 8.0669 17.5099 8.53446 17.5099 9.31066V11.3663H20.565L20.432 14.1813H17.5099V22H20.3477C22.3711 22 24 20.3711 24 18.3482V5.6519C24 3.62892 22.3711 2.00002 20.3477 2.00002H7.65232V2Z" fill="currentColor"/></svg>',
            'linkedin' => '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path fill-rule="evenodd" clip-rule="evenodd" d="M16.6667 2C17.5507 2 18.3986 2.35119 19.0237 2.97631C19.6488 3.60143 20 4.44928 20 5.33333V18.6667C20 19.5507 19.6488 20.3986 19.0237 21.0237C18.3986 21.6488 17.5507 22 16.6667 22H3.33333C2.44928 22 1.60143 21.6488 0.976311 21.0237C0.351189 20.3986 0 19.5507 0 18.6667V5.33333C0 4.44928 0.351189 3.60143 0.976311 2.97631C1.60143 2.35119 2.44928 2 3.33333 2H16.6667ZM5.55556 9.77778C5.26087 9.77778 4.97826 9.89484 4.76988 10.1032C4.56151 10.3116 4.44444 10.5942 4.44444 10.8889V16.4444C4.44444 16.7391 4.56151 17.0217 4.76988 17.2301C4.97826 17.4385 5.26087 17.5556 5.55556 17.5556C5.85024 17.5556 6.13286 17.4385 6.34123 17.2301C6.5496 17.0217 6.66667 16.7391 6.66667 16.4444V10.8889C6.66667 10.5942 6.5496 10.3116 6.34123 10.1032C6.13286 9.89484 5.85024 9.77778 5.55556 9.77778ZM8.88889 8.66667C8.5942 8.66667 8.31159 8.78373 8.10322 8.9921C7.89484 9.20048 7.77778 9.48309 7.77778 9.77778V16.4444C7.77778 16.7391 7.89484 17.0217 8.10322 17.2301C8.31159 17.4385 8.5942 17.5556 8.88889 17.5556C9.18357 17.5556 9.46619 17.4385 9.67456 17.2301C9.88294 17.0217 10 16.7391 10 16.4444V12.3778C10.3393 11.9956 10.9108 11.5467 11.548 11.2744C11.9183 11.1167 12.4736 11.0522 12.8607 11.1744C12.9893 11.207 13.1039 11.2803 13.1873 11.3833C13.2438 11.4611 13.3333 11.6344 13.3333 12V16.4444C13.3333 16.7391 13.4504 17.0217 13.6588 17.2301C13.8671 17.4385 14.1498 17.5556 14.4444 17.5556C14.7391 17.5556 15.0217 17.4385 15.2301 17.2301C15.4385 17.0217 15.5556 16.7391 15.5556 16.4444V12C15.5556 11.2556 15.367 10.5933 14.9733 10.0622C14.6111 9.58062 14.1052 9.22747 13.5284 9.05444C12.5258 8.74 11.4162 8.91444 10.6738 9.23222C10.437 9.33427 10.2064 9.45002 9.98222 9.57889C9.93626 9.32288 9.80145 9.09133 9.60123 8.92463C9.40102 8.75792 9.14907 8.66663 8.88889 8.66667ZM5.55556 6.44444C5.26087 6.44444 4.97826 6.56151 4.76988 6.76988C4.56151 6.97826 4.44444 7.26087 4.44444 7.55556C4.44444 7.85024 4.56151 8.13286 4.76988 8.34123C4.97826 8.5496 5.26087 8.66667 5.55556 8.66667C5.85024 8.66667 6.13286 8.5496 6.34123 8.34123C6.5496 8.13286 6.66667 7.85024 6.66667 7.55556C6.66667 7.26087 6.5496 6.97826 6.34123 6.76988C6.13286 6.56151 5.85024 6.44444 5.55556 6.44444Z" fill="currentColor"/></svg>',
        ];

        return $icons[$icon] ?? '';
    }
}

$post_id = isset($args['post_id']) ? absint($args['post_id']) : get_the_ID();
$post_url = isset($args['post_url']) ? esc_url_raw((string) $args['post_url']) : get_permalink($post_id);
$post_title = isset($args['post_title']) ? wp_strip_all_tags((string) $args['post_title']) : get_the_title($post_id);
$label = isset($args['label']) ? sanitize_text_field((string) $args['label']) : __('Social share', 'starwishx');
$copy_label = isset($args['copy_label']) ? sanitize_text_field((string) $args['copy_label']) : __('Скопіювати посилання', 'starwishx');
$copied_label = isset($args['copied_label']) ? sanitize_text_field((string) $args['copied_label']) : __('Посилання скопійовано', 'starwishx');
$trigger_class = isset($args['trigger_class']) ? sanitize_html_class((string) $args['trigger_class']) : '';
$wrapper_class = isset($args['wrapper_class']) ? sanitize_html_class((string) $args['wrapper_class']) : '';

if (empty($post_url)) {
    return;
}

$allowed_share_protocols = ['http', 'https', 'viber'];

$encoded_url = rawurlencode($post_url);
$encoded_title = rawurlencode($post_title);
$post_type = sanitize_key((string) get_post_type($post_id));
$panel_id = sprintf('sw-social-share-panel-%1$s-%2$d', $post_type ?: 'post', $post_id);
$status_id = sprintf('sw-social-share-status-%1$s-%2$d', $post_type ?: 'post', $post_id);

$share_items = [
    [
        'type' => 'copy',
        'label' => $copy_label,
        'url' => $post_url,
        'icon' => 'copy',
    ],
    [
        'type' => 'link',
        'label' => __('X', 'starwishx'),
        'url' => 'https://twitter.com/intent/tweet?url=' . $encoded_url . '&text=' . $encoded_title,
        'icon' => 'x',
    ],
    [
        'type' => 'link',
        'label' => __('WhatsApp', 'starwishx'),
        'url' => 'https://wa.me/?text=' . rawurlencode($post_title . ' ' . $post_url),
        'icon' => 'whatsapp',
    ],
    [
        'type' => 'link',
        'label' => __('Telegram', 'starwishx'),
        'url' => 'https://t.me/share/url?url=' . $encoded_url . '&text=' . $encoded_title,
        'icon' => 'telegram',
    ],
    [
        'type' => 'link',
        'label' => __('Viber', 'starwishx'),
        'url' => 'viber://forward?text=' . rawurlencode($post_title . ' ' . $post_url),
        'icon' => 'viber',
    ],
    [
        'type' => 'link',
        'label' => __('Facebook', 'starwishx'),
        'url' => 'https://www.facebook.com/sharer/sharer.php?u=' . $encoded_url,
        'icon' => 'facebook',
    ],
    [
        'type' => 'link',
        'label' => __('LinkedIn', 'starwishx'),
        'url' => 'https://www.linkedin.com/sharing/share-offsite/?url=' . $encoded_url,
        'icon' => 'linkedin',
    ],
];

$wrapper_classes = array_filter([
    'sw-social-share',
    $wrapper_class,
]);

$trigger_classes = array_filter([
    'sw-social-share__trigger',
    $trigger_class,
]);
?>

<div
    class="<?php echo esc_attr(implode(' ', $wrapper_classes)); ?>"
    data-sw-social-share>
    <button
        type="button"
        class="<?php echo esc_attr(implode(' ', $trigger_classes)); ?>"
        data-sw-social-share-trigger
        aria-expanded="false"
        aria-controls="<?php echo esc_attr($panel_id); ?>"
        aria-haspopup="true">
        <span class="sw-social-share__trigger-label"><?php echo esc_html($label); ?></span>
        <?php sw_svg_e('icon-share', 18, 20, 'icon-share'); ?>
    </button>

    <div
        id="<?php echo esc_attr($panel_id); ?>"
        class="sw-social-share__panel"
        data-sw-social-share-panel
        hidden>
        <div class="sw-social-share__links" role="group" aria-label="<?php echo esc_attr($label); ?>">
            <?php foreach ($share_items as $share_item) : ?>
                <?php if ('copy' === $share_item['type']) : ?>
                    <button
                        type="button"
                        class="sw-social-share__action sw-social-share__action--copy"
                        data-sw-copy-button
                        data-copy-url="<?php echo esc_url($share_item['url']); ?>"
                        data-copied-label="<?php echo esc_attr($copied_label); ?>"
                        aria-describedby="<?php echo esc_attr($status_id); ?>"
                        aria-label="<?php echo esc_attr($share_item['label']); ?>">
                        <span class="sw-social-share__icon" aria-hidden="true"><?php echo wp_kses(sw_social_share_icon($share_item['icon']), [
                            'svg' => ['viewBox' => true, 'aria-hidden' => true, 'focusable' => true],
                            'path' => ['d' => true, 'fill' => true, 'fill-rule' => true, 'clip-rule' => true],
                        ]); ?></span>
                        <span class="screen-reader-text"><?php echo esc_html($share_item['label']); ?></span>
                    </button>
                <?php else : ?>
                    <a
                        class="sw-social-share__action"
                        href="<?php echo esc_url($share_item['url'], $allowed_share_protocols); ?>"
                        target="_blank"
                        rel="noopener noreferrer"
                        aria-label="<?php echo esc_attr($share_item['label']); ?>">
                        <span class="sw-social-share__icon" aria-hidden="true"><?php echo wp_kses(sw_social_share_icon($share_item['icon']), [
                            'svg' => ['viewBox' => true, 'aria-hidden' => true, 'focusable' => true],
                            'path' => ['d' => true, 'fill' => true, 'fill-rule' => true, 'clip-rule' => true],
                        ]); ?></span>
                        <span class="screen-reader-text"><?php echo esc_html($share_item['label']); ?></span>
                    </a>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

        <span
            id="<?php echo esc_attr($status_id); ?>"
            class="sw-social-share__status"
            data-sw-copy-status
            aria-live="polite"
            aria-atomic="true"></span>
    </div>
</div>
