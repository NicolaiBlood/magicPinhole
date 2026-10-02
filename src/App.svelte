<script lang="ts">
  import viewerInHand from './assets/viewer-in-hand.jpg'
  import viewerBothFaces from './assets/viewer-both-faces.jpg'
  import viewerPair from './assets/viewer-pair.jpg'
  import renderFront from './assets/render-front.jpg'
  import renderBack from './assets/render-back.jpg'
  import OrderForm from './OrderForm.svelte'

  type Lightbox = { src: string; alt: string; caption: string }
  let lightbox = $state<Lightbox | null>(null)

  function openLightbox(src: string, alt: string, caption: string) {
    lightbox = { src, alt, caption }
  }

  const openBothFaces = () =>
    openLightbox(
      viewerBothFaces,
      'Four moulded viewers laid out showing the front and back engraving',
      'Moulded in black, engraved on both faces.'
    )

  const openPair = () =>
    openLightbox(
      viewerPair,
      'Two viewers side by side, one showing each face',
      'Front and back, side by side.'
    )

  const reveal = (node: HTMLElement) => {
    const observer = new IntersectionObserver(
      (entries) => {
        for (const entry of entries) {
          if (entry.isIntersecting) {
            node.classList.add('is-visible')
            observer.disconnect()
          }
        }
      },
      { threshold: 0.12 }
    )
    observer.observe(node)
    return { destroy: () => observer.disconnect() }
  }
</script>

<svelte:window
  onkeydown={(event) => {
    if (event.key === 'Escape') lightbox = null
  }}
/>

<header class="site-header">
  <a class="brand" href="#top">Magic Pinhole</a>
  <a class="reserve-link" href="#order">Order yours</a>
</header>

<main>
  <section class="hero" id="top">
    <div class="hero-copy">
      <h1>Magic Pinhole</h1>
      <p class="tagline">
        Forgot your glasses? Look through the hole and the fine print comes
        back.
      </p>
      <p class="status">
        A pocket-sized pinhole viewer — the stand-in for the reading glasses
        you left at home. No lenses, no prescription, no batteries.
      </p>
    </div>

    <figure class="hero-art">
      <img
        src={viewerInHand}
        alt="The Magic Pinhole viewer, a small black disc, held between two fingertips"
        width="1050"
        height="1400"
        fetchpriority="high"
      />
      <figcaption>Small enough to live on a keyring.</figcaption>
    </figure>
  </section>

  <section class="how reveal" use:reveal aria-labelledby="how-heading">
    <h2 id="how-heading">How it works</h2>
    <ol class="steps">
      <li>
        <span class="step-n">1</span>
        <p>
          The hole is a small aperture. It narrows the cone of light reaching
          your retina, so the blur circle around each point shrinks.
        </p>
      </li>
      <li>
        <span class="step-n">2</span>
        <p>
          A smaller blur circle means more depth of field — an eye that can't
          focus at that distance still resolves the detail.
        </p>
      </li>
      <li>
        <span class="step-n">3</span>
        <p>
          It's plain optics, immediate and repeatable. It works while you're
          looking through it, and stops when you aren't.
        </p>
      </li>
    </ol>
    <p class="caveat">
      A viewer, not a treatment. It doesn't change your eyes or replace an eye
      exam.
    </p>
  </section>

  <section class="faces reveal" use:reveal aria-labelledby="faces-heading">
    <h2 id="faces-heading">Both sides</h2>
    <div class="face-grid">
      <figure class="face">
        <img
          src={renderFront}
          alt="Front face of the viewer, engraved: Magic Pinhole, look here, no glasses? use this viewer"
          width="713"
          height="507"
          loading="lazy"
        />
        <figcaption><strong>Front</strong> — the pinhole, centred and ready.</figcaption>
      </figure>
      <figure class="face">
        <img
          src={renderBack}
          alt="Back face of the viewer, engraved: see website for more info, MagicPinhole.com"
          width="644"
          height="586"
          loading="lazy"
        />
        <figcaption><strong>Back</strong> — where to find us again.</figcaption>
      </figure>
    </div>
  </section>

  <section class="gallery reveal" use:reveal aria-labelledby="gallery-heading">
    <h2 id="gallery-heading">The real thing</h2>
    <div class="gallery-stack">
      <figure class="portrait">
        <button
          type="button"
          class="zoom-trigger"
          aria-label="Open larger view"
          onclick={openBothFaces}
        >
          <img
            src={viewerBothFaces}
            alt="Four moulded viewers laid out showing the front and back engraving"
            width="1050"
            height="1400"
            loading="lazy"
          />
        </button>
        <figcaption>Moulded in black, engraved on both faces.</figcaption>
      </figure>
      <figure>
        <button
          type="button"
          class="zoom-trigger"
          aria-label="Open larger view"
          onclick={openPair}
        >
          <img
            src={viewerPair}
            alt="Two viewers side by side, one showing each face"
            width="1800"
            height="1012"
            loading="lazy"
          />
        </button>
        <figcaption>Front and back, side by side.</figcaption>
      </figure>
    </div>
  </section>

  <section id="order" class="order reveal" use:reveal aria-labelledby="order-heading">
    <h2 id="order-heading">Order yours</h2>
    <p class="order-note">
      The first batch isn't made yet. Leave your name and address and we'll
      save you a spot — no payment needed until they're ready to ship.
    </p>
    <OrderForm />
  </section>

  <section class="donate reveal" use:reveal aria-labelledby="donate-heading">
    <h2 id="donate-heading">Support the project</h2>
    <p class="donate-note">
      If you like what we're building, a small donation helps us get the Magic
      Pinhole made.
    </p>
    <div class="donate-card">
      <form action="https://www.paypal.com/donate" method="post" target="_top">
        <input type="hidden" name="business" value="XWYQ8A8JDPMWE" />
        <input type="hidden" name="no_recurring" value="1" />
        <input type="hidden" name="item_name" value="Donate to Magic Pinhole!" />
        <input type="hidden" name="currency_code" value="USD" />
        <input
          type="image"
          src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif"
          name="submit"
          title="PayPal - The safer, easier way to pay online!"
          alt="Donate with PayPal button"
        />
        <img
          alt=""
          src="https://www.paypal.com/en_US/i/scr/pixel.gif"
          width="1"
          height="1"
        />
      </form>
    </div>
    <p class="donate-caption">Payments are processed securely by PayPal.</p>
  </section>

  <footer>
    <p>
      © {new Date().getFullYear()} Magic Pinhole — a viewer, not a medical
      device.
    </p>
  </footer>
</main>

{#if lightbox}
  <div
    class="lightbox"
    role="dialog"
    aria-modal="true"
    aria-label={lightbox.caption}
    tabindex="-1"
    onclick={() => (lightbox = null)}
    onkeydown={(event) => {
      if (event.key === 'Escape') lightbox = null
    }}
  >
    <img src={lightbox.src} alt={lightbox.alt} />
    <p>{lightbox.caption}</p>
  </div>
{/if}

<style>
  .site-header {
    position: sticky;
    top: 1rem;
    z-index: 20;
    width: 100%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 1rem;
    padding: 0.75rem 1rem 0.75rem 1.5rem;
    background: rgba(255, 255, 255, 0.78);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border: 1px solid var(--line);
    border-radius: 999px;
    margin-bottom: 1.5rem;
    box-shadow: var(--shadow-rest);
  }

  .brand {
    font-family: var(--font-display);
    font-weight: 700;
    font-size: 1.05rem;
    letter-spacing: -0.02em;
    color: var(--text);
    text-decoration: none;
  }

  .reserve-link {
    font-weight: 600;
    font-size: 0.95rem;
    color: var(--bg);
    background: linear-gradient(135deg, #7c3aed 0%, #5b21b6 100%);
    border-radius: 999px;
    padding: 0.5rem 1.1rem;
    text-decoration: none;
    white-space: nowrap;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }

  .reserve-link:focus-visible {
    outline: 2px solid var(--text);
    outline-offset: 3px;
  }

  main {
    width: 100%;
    max-width: 68rem;
    min-width: 0;
    display: flex;
    flex-direction: column;
    gap: 2.5rem;
  }

  .hero {
    display: grid;
    grid-template-columns: 1.1fr 0.9fr;
    gap: 2.5rem;
    align-items: center;
  }

  h1 {
    font-family: var(--font-display);
    font-size: clamp(2.5rem, 6vw, 3.75rem);
    line-height: 1.05;
    letter-spacing: -0.03em;
    font-weight: 800;
    margin: 0 0 1rem;
    color: #000000;
  }

  @supports (-webkit-background-clip: text) or (background-clip: text) {
    h1 {
      background: linear-gradient(
        135deg,
        #000000 15%,
        var(--accent-blue) 60%,
        var(--accent-light) 100%
      );
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
    }
  }

  .tagline {
    font-size: 1.2rem;
    font-weight: 500;
    color: var(--text-soft);
    margin: 0 0 1rem;
    max-width: 30rem;
  }

  .status {
    color: var(--muted);
    margin: 0;
    max-width: 30rem;
  }

  .hero-art {
    margin: 0;
  }

  .hero-art img {
    border-radius: 1.25rem;
    width: min(100%, 22rem);
    margin: 0 auto;
    box-shadow:
      var(--shadow-lift),
      0 0 0 1px var(--line);
  }

  .reveal {
    opacity: 0;
    transform: translateY(14px);
    transition: opacity 0.55s ease, transform 0.55s ease;
  }

  .reveal:global(.is-visible) {
    opacity: 1;
    transform: none;
  }

  .how,
  .faces,
  .gallery,
  .order,
  .donate,
  footer {
    padding-top: 2.5rem;
    border-top: 1px solid var(--line);
  }

  h2 {
    font-family: var(--font-display);
    font-size: clamp(1.6rem, 3.5vw, 2rem);
    letter-spacing: -0.01em;
    margin: 0 0 1.5rem;
    text-align: center;
  }

  h2::after {
    content: '';
    display: block;
    width: 3.5rem;
    height: 3px;
    border-radius: 999px;
    background: linear-gradient(90deg, var(--accent) 0%, var(--accent-2) 100%);
    margin: 0.75rem auto 0;
  }

  figcaption {
    color: var(--muted);
    font-size: 0.9rem;
    margin-top: 0.75rem;
    text-align: center;
  }

  .face-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 1.5rem;
    align-items: start;
  }

  .steps {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 1.25rem;
    list-style: none;
    margin: 0;
    padding: 0;
    counter-reset: step;
  }

  .steps li {
    background: var(--panel);
    border: 1px solid var(--line);
    border-radius: 1rem;
    padding: 1.5rem;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }

  .steps p {
    margin: 0;
    color: var(--muted);
  }

  .step-n {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 1.75rem;
    height: 1.75rem;
    border-radius: 999px;
    background: rgba(139, 92, 246, 0.18);
    color: var(--accent-light);
    font-weight: 600;
    font-size: 0.85rem;
    margin-bottom: 0.9rem;
  }

  .steps li:nth-child(1) .step-n {
    background: rgba(59, 130, 246, 0.18);
    color: var(--accent-blue);
  }

  .steps li:nth-child(2) .step-n {
    background: rgba(139, 92, 246, 0.18);
    color: var(--accent-light);
  }

  .steps li:nth-child(3) .step-n {
    background: rgba(245, 158, 11, 0.16);
    color: #b45309;
  }

  .caveat {
    text-align: center;
    color: var(--muted);
    font-size: 0.9rem;
    margin: 1.25rem 0 0;
  }

  .gallery-stack {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
  }

  .face-grid figure,
  .gallery-stack figure {
    margin: 0;
    background: var(--panel);
    border: 1px solid var(--line);
    border-radius: 1rem;
    padding: 1.25rem;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }

  .face img {
    margin: 0 auto;
    max-height: 18rem;
    width: auto;
    max-width: 100%;
  }

  .gallery-stack img {
    border-radius: 0.75rem;
    width: min(100%, 42rem);
    margin: 0 auto;
  }

  .gallery-stack .portrait img {
    width: min(100%, 26rem);
  }

  .zoom-trigger {
    display: block;
    width: 100%;
    padding: 0;
    margin: 0;
    border: 0;
    background: none;
    cursor: zoom-in;
  }

  .zoom-trigger:focus-visible {
    outline: 2px solid var(--accent);
    outline-offset: 4px;
    border-radius: 0.75rem;
  }

  .order-note {
    color: var(--muted);
    margin: 0 auto 1.75rem;
    max-width: 34rem;
    text-align: center;
  }

  .donate {
    text-align: center;
  }

  .donate-note {
    color: var(--muted);
    margin: 0 0 1.25rem;
  }

  .donate-card {
    display: inline-block;
    background: var(--panel);
    border: 1px solid var(--line);
    border-radius: 1rem;
    padding: 1.25rem 2rem;
    box-shadow: var(--shadow-rest);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }

  .donate form {
    margin: 0;
  }

  .donate form input[type='image'] {
    width: 12rem;
    max-width: 100%;
    height: auto;
    padding: 0.75rem 1rem;
    border: 0;
    border-radius: 0.5rem;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }

  .donate form input[type='image']:active {
    transform: scale(0.97);
  }

  .donate form input[type='image']:focus-visible {
    outline: 2px solid var(--accent);
    outline-offset: 3px;
  }

  .donate-caption {
    color: var(--muted);
    font-size: 0.85rem;
    margin: 0.75rem 0 0;
  }

  footer {
    color: var(--muted);
    font-size: 0.85rem;
    text-align: center;
  }

  footer p {
    margin: 0;
  }

  .lightbox {
    position: fixed;
    inset: 0;
    z-index: 100;
    display: grid;
    place-content: center;
    justify-items: center;
    gap: 1rem;
    padding: 2rem;
    background: rgba(255, 255, 255, 0.85);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    cursor: zoom-out;
  }

  .lightbox img {
    max-width: min(90vw, 48rem);
    max-height: 78vh;
    width: auto;
    height: auto;
    border-radius: 0.75rem;
    box-shadow: var(--shadow-lift);
  }

  .lightbox p {
    margin: 0;
    color: var(--muted);
  }

  @media (hover: hover) {
    .reserve-link:hover {
      transform: translateY(-1px);
      box-shadow: var(--shadow-rest);
    }

    .steps li:hover {
      transform: translateY(-3px);
      box-shadow: var(--shadow-lift);
    }

    .face-grid figure:hover,
    .gallery-stack figure:hover {
      transform: translateY(-3px);
      box-shadow: var(--shadow-lift);
    }

    .donate-card:hover {
      transform: translateY(-2px);
      box-shadow: var(--shadow-lift);
    }

    .donate form input[type='image']:hover {
      transform: translateY(-2px);
      box-shadow: var(--shadow-rest);
    }
  }

  @media (prefers-reduced-motion: reduce) {
    .reserve-link,
    .steps li,
    .face-grid figure,
    .gallery-stack figure,
    .donate-card,
    .donate form input[type='image'] {
      transform: none;
      transition: none;
    }
  }

  @media (max-width: 48rem) {
    .hero {
      grid-template-columns: 1fr;
    }

    .face-grid,
    .steps {
      grid-template-columns: 1fr;
    }
  }
</style>
