<script lang="ts">
  import viewerInHand from './assets/viewer-in-hand.jpg'
  import viewerBothFaces from './assets/viewer-both-faces.jpg'
  import viewerPair from './assets/viewer-pair.jpg'
  import renderFront from './assets/render-front.jpg'
  import renderBack from './assets/render-back.jpg'
</script>

<main>
  <section class="hero">
    <div class="hero-copy">
      <div class="badge">Coming soon</div>
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

  <section class="how" aria-labelledby="how-heading">
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

  <section class="faces" aria-labelledby="faces-heading">
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

  <section class="gallery" aria-labelledby="gallery-heading">
    <h2 id="gallery-heading">The real thing</h2>
    <div class="gallery-stack">
      <figure class="portrait">
        <img
          src={viewerBothFaces}
          alt="Four moulded viewers laid out showing the front and back engraving"
          width="1050"
          height="1400"
          loading="lazy"
        />
        <figcaption>Moulded in black, engraved on both faces.</figcaption>
      </figure>
      <figure>
        <img
          src={viewerPair}
          alt="Two viewers side by side, one showing each face"
          width="1800"
          height="1012"
          loading="lazy"
        />
        <figcaption>Front and back, side by side.</figcaption>
      </figure>
    </div>
  </section>

  <p class="footnote">We're still building this site. Check back soon.</p>
</main>

<style>
  main {
    width: 100%;
    max-width: 68rem;
    min-width: 0;
    display: flex;
    flex-direction: column;
    gap: 3.5rem;
  }

  .hero {
    display: grid;
    grid-template-columns: 1.1fr 0.9fr;
    gap: 2.5rem;
    align-items: center;
    background: var(--panel);
    border: 1px solid var(--line);
    border-radius: 1.25rem;
    padding: 2.5rem;
    box-shadow: 0 18px 40px rgba(15, 23, 42, 0.08);
  }

  .badge {
    display: inline-block;
    background: var(--accent-soft);
    color: #075985;
    font-weight: 600;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    padding: 0.3rem 0.8rem;
    border-radius: 999px;
    margin-bottom: 1.25rem;
  }

  h1 {
    font-size: clamp(2.25rem, 5vw, 3.25rem);
    line-height: 1.1;
    margin: 0 0 0.9rem;
  }

  .tagline {
    font-size: 1.15rem;
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
    border-radius: 1rem;
    width: min(100%, 22rem);
    margin: 0 auto;
  }

  h2 {
    font-size: 1.35rem;
    margin: 0 0 1.25rem;
    text-align: center;
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
    background: var(--accent-soft);
    color: #075985;
    font-weight: 600;
    font-size: 0.85rem;
    margin-bottom: 0.9rem;
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

  .footnote {
    color: var(--muted);
    text-align: center;
    font-size: 0.95rem;
    margin: 0;
  }

  @media (max-width: 48rem) {
    .hero {
      grid-template-columns: 1fr;
      padding: 1.75rem;
    }

    .face-grid,
    .steps {
      grid-template-columns: 1fr;
    }
  }
</style>
