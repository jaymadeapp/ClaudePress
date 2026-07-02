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
    $lk_eyebrow = trim((string) get_bloginfo('description'));
    $lk_lede    = has_excerpt() ? trim((string) get_the_excerpt()) : '';
  @endphp
  <header class="lk-page-header alignfull">
    <div class="lk-page-header__inner">
      @if($lk_eyebrow)
        <p class="lk-page-header__eyebrow">{{ $lk_eyebrow }}</p>
      @endif
      <h1 class="lk-page-header__title">{!! $title !!}</h1>
      @if($lk_lede)
        <p class="lk-page-header__lede">{{ $lk_lede }}</p>
      @endif
    </div>
  </header>
@endunless
