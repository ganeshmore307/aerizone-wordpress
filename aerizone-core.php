<?php
/**
 * Plugin Name: Aerizone Core
 * Plugin URI: https://aerizone.in/
 * Description: Original page system, brand styles and interactions for Aerizone.
 * Version: 2.0.0
 * Author: Aerizone
 * Text Domain: aerizone-core
 */

if (!defined('ABSPATH')) exit;

define('AERIZONE_CORE_VERSION', '2.0.0');
define('AERIZONE_CORE_URL', plugin_dir_url(__FILE__));

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('aerizone-core', AERIZONE_CORE_URL . 'assets/css/aerizone.css', array(), AERIZONE_CORE_VERSION);
    wp_enqueue_script('aerizone-core', AERIZONE_CORE_URL . 'assets/js/aerizone.js', array(), AERIZONE_CORE_VERSION, true);
});

function aerizone_page_key() {
    if (!is_page()) return '';
    $slug = get_post_field('post_name', get_queried_object_id());
    $map = array('home' => 'home', 'about-us' => 'about', 'about' => 'about', 'services' => 'services', 'contact-us' => 'contact', 'contact' => 'contact');
    return isset($map[$slug]) ? $map[$slug] : '';
}

add_filter('body_class', function ($classes) {
    $classes[] = 'aerizone-site';
    if (aerizone_page_key()) $classes[] = 'aerizone-built-page';
    return $classes;
});

function aerizone_logo() {
    return '<a class="az-brand" href="' . esc_url(home_url('/')) . '" aria-label="Aerizone home"><span class="az-brand-mark"><i></i><b></b></span><span><strong>Aerizone</strong><small>Automation &amp; Security Systems</small></span></a>';
}

function aerizone_header($active) {
    $links = array('home' => array('/', 'Home'), 'about' => array('/about-us/', 'About'), 'services' => array('/services/', 'Services'), 'contact' => array('/contact-us/', 'Contact'));
    $nav = '';
    foreach ($links as $key => $item) {
        $nav .= '<a ' . ($active === $key ? 'class="is-active" ' : '') . 'href="' . esc_url(home_url($item[0])) . '">' . esc_html($item[1]) . '</a>';
    }
    return '<header class="az-header"><div class="az-wrap">' . aerizone_logo() . '<button class="az-menu" aria-expanded="false" aria-label="Open menu"><span></span><span></span></button><nav class="az-nav">' . $nav . '</nav><a class="az-call" href="tel:+919011512832"><span>Talk to an expert</span><b>+91 90115 12832</b></a></div></header>';
}

function aerizone_footer() {
    return '<footer class="az-footer"><div class="az-wrap az-footer-grid"><div>' . aerizone_logo() . '<p>Thoughtful automation, immersive entertainment and dependable security—designed as one connected experience.</p></div><div><h3>Explore</h3><a href="' . esc_url(home_url('/about-us/')) . '">About Aerizone</a><a href="' . esc_url(home_url('/services/')) . '">Solutions</a><a href="' . esc_url(home_url('/contact-us/')) . '">Contact</a></div><div><h3>Connect</h3><a href="tel:+919011512832">+91 90115 12832</a><a href="mailto:aerzoneadm@gmail.com">aerzoneadm@gmail.com</a><span>Nashik, Maharashtra</span></div></div><div class="az-wrap az-copyright"><span>© ' . esc_html(date('Y')) . ' Aerizone Automation &amp; Security Systems</span><span>Comfort. Control. Confidence.</span></div></footer>';
}

function aerizone_dashboard() {
    return '<div class="az-console" aria-label="Connected home control illustration"><div class="az-console-top"><span><i></i> HOME ONLINE</span><b>21:18</b></div><div class="az-room"><small>Living room</small><strong>Good evening</strong><div class="az-temp">24<sup>°</sup><span>Comfort mode</span></div></div><div class="az-controls"><button class="is-on"><i>◉</i><span>Lighting</span><b>ON</b></button><button><i>◒</i><span>Curtains</span><b>68%</b></button><button><i>⌂</i><span>Main gate</span><b>LOCKED</b></button><button><i>◉</i><span>Security</span><b>ARMED</b></button></div><div class="az-scene"><span>Scene</span><strong>Movie night</strong><i>›</i></div></div>';
}

function aerizone_home() {
    return '<main class="az-main"><section class="az-hero"><div class="az-orbit az-orbit-a"></div><div class="az-orbit az-orbit-b"></div><div class="az-wrap az-hero-grid"><div class="az-hero-copy aerizone-reveal"><p class="az-kicker"><span></span> SMART SPACES, SIMPLIFIED</p><h1>Your space.<br><em>One intelligent</em><br>experience.</h1><p class="az-lead">Control lighting, curtains, entertainment, gates and security from one beautifully integrated system—at home or away.</p><div class="az-actions"><a class="az-btn az-btn-primary" href="' . esc_url(home_url('/contact-us/')) . '">Plan my smart space <span>↗</span></a><a class="az-text-link" href="' . esc_url(home_url('/services/')) . '">Explore solutions <span>→</span></a></div><div class="az-trust"><span><b>7</b> connected solution categories</span><span><b>01</b> expert team from design to support</span></div></div><div class="az-hero-visual aerizone-reveal">' . aerizone_dashboard() . '<div class="az-signal s1"><i></i><span>Gate secured</span></div><div class="az-signal s2"><i></i><span>Lights adjusted</span></div></div></div></section>' . aerizone_solution_strip() . '<section class="az-intro"><div class="az-wrap az-split"><div class="aerizone-reveal"><p class="az-kicker az-dark"><span></span> DESIGNED AROUND YOUR ROUTINE</p><h2>Technology should disappear into the way you live.</h2></div><div class="az-copy aerizone-reveal"><p>Aerizone brings separate devices into one calm, reliable system. Every switch, scene and sensor is planned around your space—not forced into it.</p><a class="az-text-link" href="' . esc_url(home_url('/about-us/')) . '">How we work <span>→</span></a></div></div></section>' . aerizone_feature_grid() . '<section class="az-process"><div class="az-wrap"><p class="az-kicker"><span></span> FROM IDEA TO EVERYDAY USE</p><h2>A connected system,<br>planned end to end.</h2><div class="az-steps"><article><b>01</b><h3>Understand</h3><p>We learn how you live, work and move through the space.</p></article><article><b>02</b><h3>Design</h3><p>We map devices, controls, wiring and the right automation scenes.</p></article><article><b>03</b><h3>Integrate</h3><p>Our team installs, programs and tests every connected touchpoint.</p></article><article><b>04</b><h3>Support</h3><p>We hand over a simple system and remain available when needed.</p></article></div></div></section>' . aerizone_cta() . '</main>';
}

function aerizone_solution_strip() {
    return '<div class="az-strip"><div class="az-track"><span>HOME AUTOMATION</span><i></i><span>LIGHTING CONTROL</span><i></i><span>HOME THEATRE</span><i></i><span>CCTV SECURITY</span><i></i><span>SMART CURTAINS</span><i></i><span>GATE AUTOMATION</span><i></i><span>VIDEO INTERCOM</span></div></div>';
}

function aerizone_feature_grid() {
    return '<section class="az-features"><div class="az-wrap"><div class="az-feature-grid"><article class="az-feature az-feature-main aerizone-reveal"><div class="az-icon">⌁</div><small>01 / AUTOMATION</small><h3>One tap changes the room.</h3><p>Create scenes that coordinate lights, curtains, climate and devices for mornings, evenings, guests or sleep.</p><a href="' . esc_url(home_url('/services/')) . '">Discover automation ↗</a><div class="az-scene-pills"><span>Morning</span><span>Welcome</span><span>Movie</span><span>Away</span></div></article><article class="az-feature az-feature-dark aerizone-reveal"><div class="az-icon">▷</div><small>02 / ENTERTAINMENT</small><h3>Cinema, without compromise.</h3><p>Purpose-built home theatre and AV experiences with 4K projection and immersive sound.</p></article><article class="az-feature az-feature-light aerizone-reveal"><div class="az-icon">◉</div><small>03 / SECURITY</small><h3>See more. Know sooner.</h3><p>CCTV, video intercom and controlled access that keep you informed wherever you are.</p><div class="az-camera"><i></i><span>Live<br><b>Front gate</b></span></div></article></div></div></section>';
}

function aerizone_page_hero($eyebrow, $title, $copy) {
    return '<section class="az-page-hero"><div class="az-grid-lines"></div><div class="az-wrap aerizone-reveal"><p class="az-kicker"><span></span>' . esc_html($eyebrow) . '</p><h1>' . $title . '</h1><p>' . esc_html($copy) . '</p></div></section>';
}

function aerizone_about() {
    return '<main class="az-main">' . aerizone_page_hero('ABOUT AERIZONE', 'We make complex technology<br><em>feel effortless.</em>', 'Aerizone designs connected spaces where automation, entertainment and security work together naturally.') . '<section class="az-story"><div class="az-wrap az-story-grid"><div class="aerizone-reveal"><p class="az-kicker az-dark"><span></span> OUR POINT OF VIEW</p><h2>Built around people,<br>not products.</h2></div><div class="az-copy aerizone-reveal"><p>A smart space is not a collection of gadgets. It is a carefully planned experience that responds consistently, remains easy to use and supports daily life.</p><p>That is why Aerizone takes responsibility from consultation and system design through installation, programming and after-sales support.</p></div></div></section><section class="az-principles"><div class="az-wrap"><article><span>01</span><h3>Thoughtful design</h3><p>Every device has a purpose and every control belongs where it feels natural.</p></article><article><span>02</span><h3>Clean integration</h3><p>Different systems communicate through one simple, dependable experience.</p></article><article><span>03</span><h3>Responsible support</h3><p>Clear handover, practical guidance and help after installation.</p></article></div></section><section class="az-promise"><div class="az-wrap az-promise-grid"><div class="az-promise-visual"><div class="az-radar"><i></i><b></b><span>DESIGN</span><span>INSTALL</span><span>PROGRAM</span><span>SUPPORT</span></div></div><div><p class="az-kicker az-dark"><span></span> THE AERIZONE PROMISE</p><h2>One team. One standard. One connected result.</h2><p>We coordinate the technical details so the finished space feels calm and intuitive from day one.</p><a class="az-btn az-btn-dark" href="' . esc_url(home_url('/contact-us/')) . '">Meet with our team <span>↗</span></a></div></div></section>' . aerizone_cta() . '</main>';
}

function aerizone_services() {
    $services = array(
        array('01','Home Automation & Lighting Control','Scenes, schedules, sensors and app control for lighting, appliances and everyday routines.','⌁'),
        array('02','Home Theatre & AV','Custom cinema rooms with 4K projection, high-definition screens, calibrated sound and considered seating.','▷'),
        array('03','Motorized Curtains & Blinds','Quiet, precise curtain and blind control through switches, remotes, apps, voice commands or automated schedules.','◫'),
        array('04','CCTV & Security Systems','Cameras, remote monitoring and alerts planned to protect important areas without complicating daily access.','◉'),
        array('05','Motorized Gates','Reliable gate access through remote, mobile and RFID control—without stepping out of the vehicle.','↔'),
        array('06','Video Intercom','Multi-apartment and residential video calling that lets occupants verify visitors before granting access.','▣'),
        array('07','Residential Networking','Stable wired and wireless infrastructure designed for connected devices, media and dependable coverage.','⌁')
    );
    $html = '<section class="az-service-list"><div class="az-wrap">';
    foreach ($services as $s) $html .= '<article class="aerizone-reveal"><span class="az-service-no">' . $s[0] . '</span><div class="az-service-icon">' . $s[3] . '</div><div><h2>' . esc_html($s[1]) . '</h2><p>' . esc_html($s[2]) . '</p></div><a href="' . esc_url(home_url('/contact-us/')) . '" aria-label="Enquire about ' . esc_attr($s[1]) . '">↗</a></article>';
    return '<main class="az-main">' . aerizone_page_hero('CONNECTED SOLUTIONS', 'Everything in your space,<br><em>working as one.</em>', 'Choose one focused solution or let us design a complete connected ecosystem for your home, office or residential project.') . $html . '</div></section><section class="az-compat"><div class="az-wrap"><p class="az-kicker az-dark"><span></span> ONE COORDINATED EXPERIENCE</p><h2>Remote. App. Voice. Sensor.<br><em>You choose the interaction.</em></h2><div class="az-methods"><span>REMOTE</span><span>MOBILE</span><span>VOICE</span><span>RFID</span><span>AUTOMATION</span></div></div></section>' . aerizone_cta() . '</main>';
}

function aerizone_contact() {
    return '<main class="az-main">' . aerizone_page_hero('START A CONVERSATION', 'Let’s design a space<br>that responds <em>to you.</em>', 'Tell us what you want to automate, secure or experience. We will help you identify the right next step.') . '<section class="az-contact"><div class="az-wrap az-contact-grid"><div class="az-contact-info"><p class="az-kicker az-dark"><span></span> CONTACT</p><h2>Speak directly with the Aerizone team.</h2><a href="tel:+919011512832"><small>CALL US</small><strong>+91 90115 12832</strong><span>↗</span></a><a href="mailto:aerzoneadm@gmail.com"><small>EMAIL US</small><strong>aerzoneadm@gmail.com</strong><span>↗</span></a><div><small>LOCATION</small><strong>Nashik, Maharashtra, India</strong></div></div><form class="az-form" id="az-enquiry"><div><label for="az-name">Your name</label><input id="az-name" name="name" required placeholder="Enter your name"></div><div><label for="az-phone">Phone number</label><input id="az-phone" name="phone" required inputmode="tel" placeholder="Enter your phone number"></div><div><label for="az-interest">I am interested in</label><select id="az-interest" name="interest"><option>Complete automation</option><option>Lighting control</option><option>Home theatre & AV</option><option>CCTV & security</option><option>Motorized curtains</option><option>Gate automation</option><option>Video intercom</option><option>Residential networking</option></select></div><div><label for="az-message">Tell us about your space</label><textarea id="az-message" name="message" rows="4" placeholder="Home, office, apartment project, renovation..."></textarea></div><button class="az-btn az-btn-primary" type="submit">Send enquiry on WhatsApp <span>↗</span></button><p class="az-form-note">This opens WhatsApp with your project details ready to send.</p></form></div></section></main>';
}

function aerizone_cta() {
    return '<section class="az-cta"><div class="az-wrap"><div><p class="az-kicker"><span></span> READY WHEN YOU ARE</p><h2>Make your next space<br><em>intelligently yours.</em></h2></div><a class="az-btn az-btn-white" href="' . esc_url(home_url('/contact-us/')) . '">Book a consultation <span>↗</span></a></div></section>';
}

add_filter('the_content', function ($content) {
    if (!in_the_loop() || !is_main_query()) return $content;
    $key = aerizone_page_key();
    if (!$key) return $content;
    $render = 'aerizone_' . $key;
    return '<div id="aerizone-app">' . aerizone_header($key) . call_user_func($render) . aerizone_footer() . '</div>';
}, 999);
