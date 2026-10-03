<script lang="ts">
  let name = $state('')
  let email = $state('')
  let street = $state('')
  let apt = $state('')
  let city = $state('')
  let region = $state('')
  let zip = $state('')
  let website = $state('')
  let submitting = $state(false)
  let submitted = $state(false)
  let error = $state('')

  const ORDER_ENDPOINT = (import.meta.env.VITE_ORDER_ENDPOINT as string | undefined) ||
    'https://magicpinhole-api.deno.dev/order'

  async function handleSubmit(event: SubmitEvent) {
    event.preventDefault()
    if (submitting || submitted) return
    submitting = true
    error = ''
    try {
      const data = new FormData()
      data.set('name', name)
      data.set('email', email)
      data.set('street', street)
      data.set('apt', apt)
      data.set('city', city)
      data.set('state', region)
      data.set('zip', zip)
      data.set('website', website)
      const response = await fetch(ORDER_ENDPOINT, { method: 'POST', body: data })
      let body: { ok?: boolean; message?: string } = {}
      try {
        body = await response.json()
      } catch {
        throw new Error('The order service is unavailable. Please try again later.')
      }
      if (!response.ok || !body.ok) {
        throw new Error(body.message || 'The order could not be saved. Please try again.')
      }
      submitted = true
    } catch (err) {
      error = err instanceof Error ? err.message : 'The order could not be saved. Please try again.'
    } finally {
      submitting = false
    }
  }
</script>

{#if submitted}
  <div class="result" role="status">
    <p class="result-title">You're on the list!</p>
    <p class="result-note">
      Thanks, {name}. We've saved your spot and will reach out when the first
      batch is ready.
    </p>
  </div>
{:else}
  <form onsubmit={handleSubmit}>
    <div class="fields">
      <label>
        <span>Full name</span>
        <input
          bind:value={name}
          name="name"
          required
          maxlength="100"
          autocomplete="name"
        />
      </label>
      <label>
        <span>Email <em>(optional)</em></span>
        <input
          bind:value={email}
          name="email"
          type="email"
          maxlength="254"
          autocomplete="email"
        />
      </label>
    </div>
    <label>
      <span>Street address</span>
      <input
        bind:value={street}
        name="street"
        required
        maxlength="200"
        autocomplete="street-address"
      />
    </label>
    <label>
      <span>Apt / Unit <em>(optional)</em></span>
      <input
        bind:value={apt}
        name="apt"
        maxlength="30"
        autocomplete="address-line2"
      />
    </label>
    <div class="fields fields-loc">
      <label>
        <span>City</span>
        <input
          bind:value={city}
          name="city"
          required
          maxlength="100"
          autocomplete="address-level2"
        />
      </label>
      <label>
        <span>State / Region <em>(optional)</em></span>
        <input
          bind:value={region}
          name="state"
          maxlength="100"
          autocomplete="address-level1"
        />
      </label>
      <label>
        <span>ZIP / Postal code</span>
        <input
          bind:value={zip}
          name="zip"
          required
          maxlength="20"
          autocomplete="postal-code"
        />
      </label>
    </div>
    <input
      class="honeypot"
      bind:value={website}
      name="website"
      tabindex="-1"
      autocomplete="off"
      aria-hidden="true"
    />
    {#if error}
      <p class="error" role="alert">{error}</p>
    {/if}
    <button type="submit" disabled={submitting}>
      {submitting ? 'Saving…' : 'Order mine'}
    </button>
  </form>
{/if}

<style>
  form {
    display: grid;
    gap: 1.25rem;
    max-width: 32rem;
    margin: 0 auto;
    text-align: left;
  }

  .fields {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 1.25rem;
  }

  .fields-loc {
    grid-template-columns: minmax(0, 1.4fr) minmax(0, 1fr) minmax(0, 1fr);
  }

  label {
    display: grid;
    gap: 0.5rem;
    font-size: 0.95rem;
    font-weight: 500;
    color: var(--text-soft);
  }

  label em {
    font-style: normal;
    font-weight: 400;
    color: var(--muted);
  }

  input {
    font: inherit;
    color: var(--text);
    background: var(--panel-alt);
    border: 1px solid var(--line);
    border-radius: 0.75rem;
    padding: 0.75rem 1rem;
    min-width: 0;
  }

  input:focus-visible {
    outline: 2px solid var(--accent);
    outline-offset: 2px;
    border-color: var(--accent);
  }

  input:user-invalid {
    border-color: #f87171;
  }

  input:user-invalid:focus-visible {
    outline-color: #f87171;
  }

  button {
    justify-self: center;
    font: inherit;
    font-weight: 600;
    color: #ffffff;
    background: linear-gradient(135deg, #7c3aed 0%, #5b21b6 100%);
    border: 0;
    border-radius: 999px;
    padding: 0.75rem 1.75rem;
    cursor: pointer;
    transition: transform 0.2s ease, box-shadow 0.2s ease, opacity 0.2s ease;
  }

  @media (hover: hover) {
    button:not(:disabled):hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 24px rgba(0, 0, 0, 0.35);
    }
  }

  button:not(:disabled):active {
    transform: scale(0.97);
  }

  button:disabled {
    opacity: 0.7;
    cursor: default;
  }

  button:focus-visible {
    outline: 2px solid var(--text);
    outline-offset: 3px;
  }

  @media (prefers-reduced-motion: reduce) {
    button {
      transform: none;
      transition: none;
    }
  }

  .honeypot {
    position: absolute;
    left: -9999px;
    width: 1px;
    height: 1px;
    opacity: 0;
  }

  .error {
    margin: 0;
    color: var(--error);
    font-size: 0.9rem;
    text-align: center;
  }

  .result {
    max-width: 32rem;
    margin: 0 auto;
    text-align: center;
    background: rgba(34, 197, 94, 0.08);
    border: 1px solid rgba(34, 197, 94, 0.35);
    border-radius: 1rem;
    padding: 1.75rem 1.5rem;
  }

  .result-title {
    margin: 0 0 0.5rem;
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--success);
  }

  .result-note {
    margin: 0;
    color: var(--muted);
  }

  @media (max-width: 30rem) {
    .fields {
      grid-template-columns: minmax(0, 1fr);
    }
  }
</style>
