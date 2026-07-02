{{--
  Loamkit Terra site footer — editorial chrome on ink (surface-2) bg.

  Replaces Sage 11's stock sections/footer.blade.php. Distinct from the
  footer-editorial *pattern* (which a page can place in content): this is the
  SITE footer every page gets. $siteName comes from App\View\Composers\App.
  The primary nav (seeded into 'primary_navigation') is reused as a real <ul>
  link column. The newsletter form is markup-only (no backend) — action="#"
  and no name attributes, so it posts nowhere. All styling is token-driven and
  lives in .lk-site-footer (appended to resources/css/app.css).
--}}
<footer class="lk-site-footer" role="contentinfo">
  <div class="lk-site-footer__inner">
    <div class="lk-site-footer__brand">
      <a class="lk-site-footer__brand-link" href="{{ home_url('/') }}" rel="home">
        {{ get_bloginfo('name') }}
      </a>
      <p class="lk-site-footer__statement">
        {{ __('Crafted with care. A calmer, warmer way to build on the web — thoughtful design, honest materials, and room to breathe.', 'sage') }}
      </p>

      <form class="lk-site-footer__newsletter" action="#" method="post" aria-label="{{ __('Newsletter signup', 'sage') }}">
        <label class="sr-only" for="lk-newsletter-email">{{ __('Email address', 'sage') }}</label>
        <div class="lk-site-footer__newsletter-row">
          <input
            class="lk-site-footer__newsletter-input"
            id="lk-newsletter-email"
            type="email"
            inputmode="email"
            autocomplete="email"
            placeholder="{{ __('you@example.com', 'sage') }}"
            aria-label="{{ __('Email address', 'sage') }}"
          >
          <button class="lk-site-footer__newsletter-btn wp-element-button" type="submit">
            {{ __('Subscribe', 'sage') }}
          </button>
        </div>
        <p class="lk-site-footer__newsletter-hint">{{ __('No spam — just the occasional note.', 'sage') }}</p>
      </form>
    </div>

    <nav class="lk-site-footer__nav" aria-label="{{ __('Footer', 'sage') }}">
      @if (has_nav_menu('primary_navigation'))
        <div class="lk-site-footer__col">
          <h2 class="lk-site-footer__heading">{{ __('Explore', 'sage') }}</h2>
          {!! wp_nav_menu([
            'theme_location' => 'primary_navigation',
            'container'      => false,
            'menu_class'     => 'lk-site-footer__links',
            'depth'          => 1,
            'fallback_cb'    => false,
            'echo'           => false,
          ]) !!}
        </div>
      @endif

      <div class="lk-site-footer__col">
        <h2 class="lk-site-footer__heading">{{ __('Connect', 'sage') }}</h2>
        <ul class="lk-site-footer__social">
          <li><a href="#" rel="noopener">{{ __('Instagram', 'sage') }}</a></li>
          <li><a href="#" rel="noopener">{{ __('LinkedIn', 'sage') }}</a></li>
          <li><a href="#" rel="noopener">{{ __('Newsletter', 'sage') }}</a></li>
        </ul>
      </div>
    </nav>
  </div>

  <div class="lk-site-footer__baseline">
    <p class="lk-site-footer__small">
      &copy; {{ date('Y') }} {{ get_bloginfo('name') }}. {{ __('All rights reserved.', 'sage') }}
    </p>
    <p class="lk-site-footer__small">
      {{ __('Built with Loamkit.', 'sage') }}
    </p>
  </div>
</footer>
