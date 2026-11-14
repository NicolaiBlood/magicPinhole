<script lang="ts">
  import viewerBothFaces from './assets/viewer-both-faces.jpg'
  import viewerBothFaces480 from './assets/viewer-both-faces-480.jpg'
  import viewerBothFaces768 from './assets/viewer-both-faces-768.jpg'
  import viewerPair from './assets/viewer-pair.jpg'
  import viewerPair640 from './assets/viewer-pair-640.jpg'
  import viewerPair960 from './assets/viewer-pair-960.jpg'
  import renderFront from './assets/render-front.jpg'
  import renderBack from './assets/render-back.jpg'

  const base = import.meta.env.BASE_URL
  const heroSrc = `${base}viewer-in-hand.jpg`
  const heroSrcset = `${base}viewer-in-hand-480.jpg 480w, ${base}viewer-in-hand-768.jpg 768w, ${heroSrc} 1050w`

  type Lightbox = { src: string; alt: string; caption: string; width: number; height: number }
  let lightbox = $state<Lightbox | null>(null)
  let lightboxTrigger = $state<HTMLElement | null>(null)
  let lightboxEl = $state<HTMLElement | null>(null)
  let headerEl = $state<HTMLElement | null>(null)
  let mainEl = $state<HTMLElement | null>(null)

  function openLightbox(
    src: string,
    alt: string,
    caption: string,
    width: number,
    height: number,
    trigger: HTMLElement
  ) {
    lightboxTrigger = trigger
    lightbox = { src, alt, caption, width, height }
  }

  function closeLightbox() {
    lightbox = null
    lightboxTrigger?.focus()
    lightboxTrigger = null
  }

  const openBothFaces = (event: MouseEvent) =>
    openLightbox(
      viewerBothFaces,
      'Four moulded viewers laid out showing the front and back engraving',
      'Moulded in black, engraved on both faces.',
      1050,
      1400,
      event.currentTarget as HTMLElement
    )

  const openPair = (event: MouseEvent) =>
    openLightbox(
      viewerPair,
      'Two viewers side by side, one showing each face',
      'Front and back, side by side.',
      1800,
      1012,
      event.currentTarget as HTMLElement
    )

  // While the lightbox is open: focus it, lock background scroll, and make the
  // rest of the page inert so keyboard/screen-reader users can't reach it.
  $effect(() => {
    if (lightbox && lightboxEl) {
      lightboxEl.focus()
      const previousOverflow = document.body.style.overflow
      document.body.style.overflow = 'hidden'
      headerEl?.setAttribute('inert', '')
      mainEl?.setAttribute('inert', '')
      return () => {
        document.body.style.overflow = previousOverflow
        headerEl?.removeAttribute('inert')
        mainEl?.removeAttribute('inert')
      }
    }
  })

  // Keep Tab focus cycling inside the dialog (focus trap).
  function onLightboxKeydown(event: KeyboardEvent) {
    if (event.key !== 'Tab' || !lightboxEl) return
    const focusables = lightboxEl.querySelectorAll<HTMLElement>(
      'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
    )
    if (focusables.length === 0) return
    const first = focusables[0]
    const last = focusables[focusables.length - 1]
    if (event.shiftKey && document.activeElement === first) {
      event.preventDefault()
      last.focus()
    } else if (!event.shiftKey && document.activeElement === last) {
      event.preventDefault()
      first.focus()
    }
  }

  const reveal = (node: HTMLElement) => {
    if (typeof IntersectionObserver === 'undefined') {
      node.classList.add('is-visible')
      return
    }
    const observer = new IntersectionObserver(
      (entries) => {
        try {
          for (const entry of entries) {
            if (entry.isIntersecting) {
              node.classList.add('is-visible')
              observer.disconnect()
            }
          }
        } catch {
          // Never leave content hidden if the observer misbehaves.
          node.classList.add('is-visible')
          observer.disconnect()
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
    if (event.key === 'Escape' && lightbox) closeLightbox()
  }}
/>

<a class="skip-link" href="#main">Skip to content</a>

<header class="site-header" bind:this={headerEl}>
  <a class="brand" href="#top">Magic Pinhole</a>
  <a class="header-cta" href="#donate">Support</a>
</header>

<main id="main" bind:this={mainEl}>
  <section class="hero" id="top">
    <div class="hero-copy">
      <h1>Magic Pinhole</h1>
      <p class="tagline">
        Forgot your glasses? Look through the hole and the fine print comes
        back. A pocket pinhole viewer — no lenses, no prescription, no
        batteries.
      </p>
      <p class="status">
        The stand-in for the reading glasses you left at home. Works instantly
        using plain optics to increase your depth of field, so you can read
        menus, labels, and fine print without prescription readers.
      </p>
      <p class="hero-cta">
        <a class="cta" href="#donate">Support the project</a>
      </p>
    </div>

    <figure class="hero-art">
      <img
        src={heroSrc}
        srcset={heroSrcset}
        sizes="(min-width: 48rem) 22rem, calc(100vw - 2.5rem)"
        alt="The Magic Pinhole viewer, a small black disc, held between two fingertips"
        width="1050"
        height="1400"
        fetchpriority="high"
        decoding="async"
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
          decoding="async"
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
          decoding="async"
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
          aria-label="Enlarge photo: all four viewers, front and back engraving"
          onclick={openBothFaces}
        >
          <img
            src={viewerBothFaces}
            srcset={`${viewerBothFaces480} 480w, ${viewerBothFaces768} 768w, ${viewerBothFaces} 1050w`}
            sizes="(min-width: 48rem) 26rem, calc(100vw - 6rem)"
            alt="Four moulded viewers laid out showing the front and back engraving"
            width="1050"
            height="1400"
            loading="lazy"
            decoding="async"
          />
        </button>
        <figcaption>Moulded in black, engraved on both faces.</figcaption>
      </figure>
      <figure>
        <button
          type="button"
          class="zoom-trigger"
          aria-label="Enlarge photo: viewer pair, front and back side by side"
          onclick={openPair}
        >
          <img
            src={viewerPair}
            srcset={`${viewerPair640} 640w, ${viewerPair960} 960w, ${viewerPair} 1800w`}
            sizes="(min-width: 48rem) 42rem, calc(100vw - 6rem)"
            alt="Two viewers side by side, one showing each face"
            width="1800"
            height="1012"
            loading="lazy"
            decoding="async"
          />
        </button>
        <figcaption>Front and back, side by side.</figcaption>
      </figure>
    </div>
  </section>

  <section class="benefits reveal" use:reveal aria-labelledby="benefits-heading">
    <h2 id="benefits-heading">Why the Magic Pinhole</h2>
    <p class="section-intro">
      A pinhole viewer is the simplest reading aid there is. Here's what makes
      the Magic Pinhole different from reading glasses, magnifiers, and phone
      apps.
    </p>
    <ul class="benefit-grid">
      <li>
        <h3>No prescription needed</h3>
        <p>
          No lenses means no optometrist visit and no prescription to match —
          the plain optics work for most people as-is.
        </p>
      </li>
      <li>
        <h3>No batteries, ever</h3>
        <p>
          It's pure optics. There's nothing to charge, nothing to switch on, and
          nothing to run out.
        </p>
      </li>
      <li>
        <h3>Pocket-sized</h3>
        <p>
          Small enough to live on a keyring. Keep one in your pocket, your bag,
          or your car — always there when you forget your glasses.
        </p>
      </li>
      <li>
        <h3>Works instantly</h3>
        <p>
          Look through the hole and the fine print comes back. No focusing
          dials, no setup, no waiting.
        </p>
      </li>
      <li>
        <h3>Increases depth of field</h3>
        <p>
          The small aperture narrows the cone of light reaching your eye, so
          more of what you're reading stays sharp at once.
        </p>
      </li>
      <li>
        <h3>Nothing to break</h3>
        <p>
          One moulded disc, engraved on both faces. No hinges, no screens, no
          fragile parts.
        </p>
      </li>
    </ul>
  </section>

  <section class="use-cases reveal" use:reveal aria-labelledby="use-cases-heading">
    <h2 id="use-cases-heading">When you'll reach for it</h2>
    <p class="section-intro">
      Any time you need to read something small and your glasses aren't with
      you.
    </p>
    <ul class="use-case-list">
      <li>Reading a restaurant menu when your glasses are at home</li>
      <li>Reading medicine labels and dosage instructions</li>
      <li>Reading price tags and product packaging in shops</li>
      <li>Reading your phone or watch face without readers</li>
      <li>Reading maps, tickets, and receipts on the go</li>
      <li>Reading fine print on contracts and forms</li>
      <li>Travelling — a light, no-power backup for your glasses</li>
      <li>Keeping in the car, desk drawer, or bedside table</li>
    </ul>
  </section>

  <section class="faq reveal" use:reveal aria-labelledby="faq-heading">
    <h2 id="faq-heading">Frequently asked questions</h2>
    <div class="faq-list">
      <details class="faq-item">
        <summary>What is a pinhole viewer?</summary>
        <p>
          A pinhole viewer is a small disc with a tiny hole in the centre. When
          you look through the hole, it acts as a small aperture that narrows
          the cone of light entering your eye, reducing the blur circle and
          increasing your depth of field. This lets you read fine print more
          clearly — without lenses, batteries, or a prescription.
        </p>
      </details>
      <details class="faq-item">
        <summary>Can a pinhole viewer replace reading glasses?</summary>
        <p>
          A pinhole viewer is a handy stand-in for reading glasses when you've
          left them at home. It works using plain optics — it doesn't change
          your eyesight, it just makes it easier to focus on near objects.
          It's a viewer, not a treatment, and doesn't replace an eye exam.
        </p>
      </details>
      <details class="faq-item">
        <summary>Do pinhole glasses need a prescription?</summary>
        <p>
          No. A pinhole viewer like the Magic Pinhole has no lenses and needs no
          prescription. It works for anyone by using a small aperture to
          increase depth of field.
        </p>
      </details>
      <details class="faq-item">
        <summary>How does a pinhole viewer work?</summary>
        <p>
          The hole is a small aperture. It narrows the cone of light reaching
          your retina, so the blur circle around each point shrinks. A smaller
          blur circle means more depth of field — an eye that can't focus at
          that distance still resolves the detail. It's plain optics,
          immediate and repeatable.
        </p>
      </details>
      <details class="faq-item">
        <summary>Do pinhole viewers need batteries?</summary>
        <p>
          No. A pinhole viewer is pure optics — no lenses, no prescription, no
          batteries. It works the moment you look through it.
        </p>
      </details>
      <details class="faq-item">
        <summary>Is the Magic Pinhole a medical device?</summary>
        <p>
          No. The Magic Pinhole is a viewer, not a medical device or treatment.
          It doesn't change your eyes or replace an eye exam.
        </p>
      </details>
      <details class="faq-item">
        <summary>How do I use the Magic Pinhole?</summary>
        <p>
          Hold the viewer up to your eye and look through the small hole at the
          text you want to read. Bring the viewer close to your eye and the
          object into comfortable focus. It works best in good light.
        </p>
      </details>
      <details class="faq-item">
        <summary>Is the Magic Pinhole portable?</summary>
        <p>
          Yes — it's small enough to live on a keyring. It's a pocket-sized
          viewer you can carry anywhere, so you always have a reading aid when
          you've forgotten your glasses.
        </p>
      </details>
    </div>
  </section>

  <section class="donate reveal" id="donate" use:reveal aria-labelledby="donate-heading">
    <h2 id="donate-heading">Support the project</h2>
    <p class="donate-note">
      If you like what we're building, a small donation helps us get the Magic
      Pinhole made.
    </p>
    <div class="donate-card">
      <a
        class="donate-btn"
        href="https://www.paypal.com/donate?business=XWYQ8A8JDPMWE&amp;no_recurring=1&amp;item_name=Donate%20to%20Magic%20Pinhole!&amp;currency_code=USD"
        target="_blank"
        rel="noopener"
      >
        Donate with PayPal
      </a>
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
    bind:this={lightboxEl}
    onkeydown={onLightboxKeydown}
    onclick={(event) => {
      if (event.target === event.currentTarget) closeLightbox()
    }}
  >
    <button
      type="button"
      class="lightbox-close"
      aria-label="Close"
      onclick={closeLightbox}
    >
      <svg viewBox="0 0 24 24" width="24" height="24" aria-hidden="true">
        <path d="M6 6l12 12M18 6L6 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
      </svg>
    </button>
    <img src={lightbox.src} alt={lightbox.alt} width={lightbox.width} height={lightbox.height} />
    <p>{lightbox.caption}</p>
  </div>
{/if}

<style>
  .skip-link {
    position: absolute;
    top: -100%;
    left: 1rem;
    z-index: 200;
    padding: 0.6rem 1rem;
    background: var(--text);
    color: var(--bg);
    border-radius: 0.5rem;
    font-weight: 600;
    text-decoration: none;
  }

  .skip-link:focus-visible {
    top: 1rem;
    outline: 2px solid var(--accent);
    outline-offset: 2px;
  }

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

  .header-cta {
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--text);
    text-decoration: none;
    padding: 0.4rem 0.9rem;
    border: 1px solid var(--line);
    border-radius: 999px;
    background: var(--panel);
    transition: box-shadow 0.2s ease, transform 0.2s ease;
  }

  .header-cta:hover {
    box-shadow: var(--shadow-rest);
  }

  .header-cta:focus-visible {
    outline: 2px solid var(--accent);
    outline-offset: 3px;
  }

  .hero-cta {
    margin: 1.5rem 0 0;
  }

  .cta {
    display: inline-block;
    font-weight: 600;
    color: #ffffff;
    text-decoration: none;
    padding: 0.75rem 1.5rem;
    border-radius: 999px;
    background: linear-gradient(135deg, var(--accent) 0%, var(--accent-2) 100%);
    box-shadow: var(--shadow-rest);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }

  .cta:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lift);
  }

  .cta:focus-visible {
    outline: 2px solid var(--accent);
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
  .benefits,
  .use-cases,
  .faq,
  .donate,
  footer {
    padding-top: 2.5rem;
    border-top: 1px solid var(--line);
  }

  .section-intro {
    color: var(--muted);
    text-align: center;
    max-width: 36rem;
    margin: 0 auto 2rem;
  }

  .benefit-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 1.25rem;
    list-style: none;
    margin: 0;
    padding: 0;
  }

  .benefit-grid li {
    background: var(--panel);
    border: 1px solid var(--line);
    border-radius: 1rem;
    padding: 1.5rem;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }

  .benefit-grid h3 {
    font-family: var(--font-display);
    font-size: 1.05rem;
    margin: 0 0 0.5rem;
    color: var(--text);
  }

  .benefit-grid p {
    margin: 0;
    color: var(--muted);
    font-size: 0.95rem;
  }

  .use-case-list {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 0.75rem 2rem;
    list-style: none;
    margin: 0 auto;
    padding: 0;
    max-width: 44rem;
  }

  .use-case-list li {
    position: relative;
    padding-left: 1.5rem;
    color: var(--muted);
  }

  .use-case-list li::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0.55em;
    width: 0.5rem;
    height: 0.5rem;
    border-radius: 999px;
    background: linear-gradient(135deg, var(--accent) 0%, var(--accent-2) 100%);
  }

  .faq-list {
    max-width: 44rem;
    margin: 0 auto;
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
  }

  .faq-item {
    background: var(--panel);
    border: 1px solid var(--line);
    border-radius: 1rem;
    padding: 1rem 1.25rem;
  }

  .faq-item summary {
    font-weight: 600;
    cursor: pointer;
    color: var(--text);
  }

  .faq-item summary:focus-visible {
    outline: 2px solid var(--accent);
    outline-offset: 3px;
    border-radius: 0.25rem;
  }

  .faq-item p {
    margin: 0.75rem 0 0;
    color: var(--muted);
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

  .donate-btn {
    display: inline-block;
    min-width: 12rem;
    padding: 0.8rem 1.5rem;
    border-radius: 0.75rem;
    background: linear-gradient(135deg, var(--accent) 0%, var(--accent-2) 100%);
    color: #ffffff;
    font-weight: 600;
    text-decoration: none;
    text-align: center;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }

  .donate-btn:active {
    transform: scale(0.97);
  }

  .donate-btn:hover {
    box-shadow: var(--shadow-rest);
  }

  .donate-btn:focus-visible {
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
    place-content: safe center;
    justify-items: center;
    gap: 1rem;
    padding: 2rem;
    overflow-y: auto;
    overscroll-behavior: contain;
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

  .lightbox-close {
    position: fixed;
    top: 1.25rem;
    right: 1.25rem;
    display: grid;
    place-items: center;
    width: 3rem;
    height: 3rem;
    padding: 0;
    border: 1px solid var(--line);
    border-radius: 999px;
    background: var(--panel);
    color: var(--text);
    cursor: pointer;
    box-shadow: var(--shadow-rest);
    transition: transform 0.15s ease, box-shadow 0.15s ease;
  }

  .lightbox-close:hover {
    transform: scale(1.06);
    box-shadow: var(--shadow-lift);
  }

  .lightbox-close:focus-visible {
    outline: 2px solid var(--accent);
    outline-offset: 3px;
  }

  @media (hover: hover) {
    .steps li:hover,
    .benefit-grid li:hover {
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

    .header-cta:hover,
    .cta:hover,
    .donate-btn:hover {
      transform: translateY(-2px);
    }
  }

  @media (prefers-reduced-motion: reduce) {
    .steps li,
    .benefit-grid li,
    .face-grid figure,
    .gallery-stack figure,
    .donate-card,
    .header-cta,
    .cta,
    .donate-btn {
      transform: none;
      transition: none;
    }
  }

  /* High-contrast / forced-colors: undo gradient text and decorative
     gradient fills so content stays visible. */
  @media (forced-colors: active) {
    h1 {
      background: none;
      -webkit-background-clip: border-box;
      background-clip: border-box;
      color: CanvasText;
    }

    h2::after,
    .use-case-list li::before {
      background: CanvasText;
    }

    .step-n {
      background: Canvas;
      color: CanvasText;
      border: 1px solid CanvasText;
    }

    .cta,
    .donate-btn {
      background: ButtonFace;
      color: ButtonText;
      border: 1px solid ButtonText;
    }
  }

  @media print {
    .reveal {
      opacity: 1 !important;
      transform: none !important;
    }

    .lightbox,
    .skip-link {
      display: none;
    }
  }

  @media (max-width: 48rem) {
    .hero {
      grid-template-columns: 1fr;
    }

    .face-grid,
    .steps,
    .benefit-grid,
    .use-case-list {
      grid-template-columns: 1fr;
    }
  }
</style>
