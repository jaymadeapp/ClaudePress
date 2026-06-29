{{--
  Loamkit Terra site header — designed, sticky, token-driven.

  Replaces Sage 11's stock sections/header.blade.php. Keeps Sage's contract:
  - $siteName comes from App\View\Composers\App (get_bloginfo).
  - The primary nav renders via wp_nav_menu() against the 'primary_navigation'
    theme location registered in app/setup.php (populated by the content seeder).
  All colors/spacing/type come from the global --wp--preset--* / --wp--custom--*
  CSS vars emitted by theme.json; the only chrome CSS lives in .cp-site-header
  (appended to resources/css/app.css). Mobile uses a no-JS <details> disclosure.
--}}
<header class="cp-site-header" data-cp-header>
  <div class="cp-site-header__inner">
    <a class="cp-site-header__brand" href="{{ home_url('/') }}" rel="home">
      <span class="cp-site-header__mark" aria-hidden="true"></span>
      <span class="cp-site-header__brand-name">{{ get_bloginfo('name') }}</span>
    </a>

    @if (has_nav_menu('primary_navigation'))
      <nav class="cp-site-header__nav" aria-label="{{ wp_get_nav_menu_name('primary_navigation') }}">
        {!! wp_nav_menu([
          'theme_location' => 'primary_navigation',
          'container'      => false,
          'menu_class'     => 'cp-nav',
          'depth'          => 1,
          'fallback_cb'    => false,
          'echo'           => false,
        ]) !!}
      </nav>
    @endif

    <a class="cp-site-header__cta wp-element-button" href="{{ home_url('/contact/') }}">
      {{ __('Get in touch', 'sage') }}
    </a>

    @if (has_nav_menu('primary_navigation'))
      <details class="cp-site-header__disclosure">
        <summary class="cp-site-header__toggle" aria-label="{{ __('Menu', 'sage') }}">
          <span class="cp-site-header__toggle-bars" aria-hidden="true"></span>
          <span class="sr-only">{{ __('Menu', 'sage') }}</span>
        </summary>
        <div class="cp-site-header__drawer">
          {!! wp_nav_menu([
            'theme_location' => 'primary_navigation',
            'container'      => false,
            'menu_class'     => 'cp-nav cp-nav--stacked',
            'depth'          => 1,
            'fallback_cb'    => false,
            'echo'           => false,
          ]) !!}
          <a class="cp-site-header__cta wp-element-button" href="{{ home_url('/contact/') }}">
            {{ __('Get in touch', 'sage') }}
          </a>
        </div>
      </details>
    @endif
  </div>
</header>
