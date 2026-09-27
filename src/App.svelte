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

  <section class="donate" aria-labelledby="donate-heading">
    <h2 id="donate-heading">Support the project</h2>
    <p class="donate-note">
      If you like what we're building, a small donation helps us get the Magic
      Pinhole made.
    </p>
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
  </section>
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
    background: linear-gradient(180deg, #2e2650 0%, #251e3e 100%);
    border: 1px solid var(--line);
    border-radius: 1.5rem;
    padding: 2.75rem;
    box-shadow:
      0 1px 2px rgba(0, 0, 0, 0.25),
      0 24px 48px rgba(0, 0, 0, 0.35);
  }

  h1 {
    font-size: clamp(2.5rem, 6vw, 3.75rem);
    line-height: 1.05;
    letter-spacing: -0.03em;
    font-weight: 800;
    margin: 0 0 1rem;
    background: linear-gradient(135deg, #f8f6ff 15%, #93c5fd 60%, #c4b5fd 100%);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
  }

  .tagline {
    font-size: 1.2rem;
    font-weight: 500;
    color: #cdc3ea;
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
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.45);
  }

  h2 {
    font-size: 1.35rem;
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
    color: #c4b5fd;
    font-weight: 600;
    font-size: 0.85rem;
    margin-bottom: 0.9rem;
  }

  .steps li:nth-child(1) .step-n {
    background: rgba(59, 130, 246, 0.18);
    color: #93c5fd;
  }

  .steps li:nth-child(2) .step-n {
    background: rgba(139, 92, 246, 0.18);
    color: #c4b5fd;
  }

  .steps li:nth-child(3) .step-n {
    background: rgba(245, 158, 11, 0.16);
    color: #fcd34d;
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

  .donate {
    background: linear-gradient(135deg, #2e2650 0%, #292244 55%, #332a58 100%);
    border: 1px solid var(--line);
    border-radius: 1.5rem;
    padding: 2.25rem;
    text-align: center;
    box-shadow: 0 18px 40px rgba(0, 0, 0, 0.3);
  }

  .donate-note {
    color: var(--muted);
    margin: 0 0 1.25rem;
  }

  .donate form {
    margin: 0;
  }

  .donate form input[type='image'] {
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

  @media (hover: hover) {
    .steps li:hover {
      transform: translateY(-3px);
      box-shadow: 0 14px 28px rgba(0, 0, 0, 0.35);
    }

    .face-grid figure:hover,
    .gallery-stack figure:hover {
      transform: translateY(-3px);
      box-shadow: 0 14px 28px rgba(0, 0, 0, 0.35);
    }

    .donate form input[type='image']:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.4);
    }
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
