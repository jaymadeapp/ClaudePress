{{--
  Terra page header — a designed full-bleed band for inner pages (About, Services,
  Contact, …) so the page title reads as an intentional header section, not a lonely
  strip of body colour abutting the first pattern. Eyebrow (site tagline) + display
  title + optional lede (manual excerpt only — never the auto-generated content dump).
  Suppressed on the front page, where the hero pattern already carries the headline.
  Reuses Sage's $title view-model; safe to fall back to plain WP calls.
--}}
@unless(is_front_page())
  @php
    $cp_eyebrow = trim((string) get_bloginfo('description'));
    $cp_lede    = has_excerpt() ? trim((string) get_the_excerpt()) : '';
  @endphp
  <header class="cp-page-header alignfull">
    <div class="cp-page-header__inner">
      @if($cp_eyebrow)
        <p class="cp-page-header__eyebrow">{{ $cp_eyebrow }}</p>
      @endif
      <h1 class="cp-page-header__title">{!! $title !!}</h1>
      @if($cp_lede)
        <p class="cp-page-header__lede">{{ $cp_lede }}</p>
      @endif
    </div>
  </header>
@endunless
