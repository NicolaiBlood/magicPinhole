# Magic Pinhole

A pocket-sized pinhole viewer — the stand-in for the reading glasses you left at home.

Looking through a small aperture shrinks the blur circle and deepens your depth of field, so a
defocused eye resolves more detail. Plain optics: it works while you look through it, and stops
when you don't. It is a viewer, not a treatment — it makes no claim to change your eyesight.

Built with Svelte 5 + TypeScript + Vite.

## Prerequisites

- Node.js 18 or later
- npm

## Getting started

Install dependencies:

```bash
npm install
```

## Development

Start the Vite dev server with hot module reloading:

```bash
npm run dev
```

The app runs at `http://localhost:5173` by default. Edit files under `src/` and changes appear live in the browser.

## Building

Produce an optimized production build in `dist/`:

```bash
npm run build
```

Preview the production build locally:

```bash
npm run preview
```

## Type checking

Run `svelte-check` to type-check Svelte and TypeScript files:

```bash
npm run check
```

## Deployment

Both targets deploy automatically on every push to `main` (and via "Run workflow"):

### GitHub Pages

`.github/workflows/deploy.yml` builds with `--base=/magicPinhole/` and publishes to
GitHub Pages. `dist/.htaccess` is removed because Pages cannot execute Apache config.

### GoDaddy (cPanel) — magicpinhole.com

`.github/workflows/deploy-godaddy.yml` builds with the default base `/` (the site is
served from the domain root) and uploads `dist/` over FTPS (explicit TLS, port 21) using
[SamKirkland/FTP-Deploy-Action](https://github.com/SamKirkland/FTP-Deploy-Action).
`dist/.htaccess` is kept — the Apache server on GoDaddy uses it for cache headers.

Required repository secrets (Settings → Secrets and variables → Actions):

| Secret | Value |
| --- | --- |
| `GODADDY_FTP_SERVER` | FTP hostname, e.g. `ftp.magicpinhole.com` or the server name from cPanel → General Information |
| `GODADDY_FTP_USERNAME` | A dedicated cPanel FTP account scoped to the site's directory (not the master cPanel login) |
| `GODADDY_FTP_PASSWORD` | That account's password |
| `GODADDY_REMOTE_DIR` | The site's document root relative to the FTP home, with a trailing slash, e.g. `public_html/` |

Create the FTP account in cPanel under FTP Accounts, with its directory set to the site's
document root. `GODADDY_REMOTE_DIR`'s contents are wiped on every deploy
(`dangerous-clean-slate`), so never set it to `/` or leave it empty — the workflow refuses
those values. If the deploy fails with a TLS certificate error, add `security: loose` to
the action in the workflow (GoDaddy's FTP endpoint sometimes presents a certificate that
does not match the hostname). If the site ever moves into a subfolder of the domain,
change the build step to `npx vite build --base=/subfolder/`.

## Project structure

```
├── index.html          Vite entry HTML
├── src/
│   ├── App.svelte      Landing page
│   ├── main.ts         App bootstrap
│   ├── app.css         Global styles
│   └── assets/         Web-sized product images (imported by components)
├── svelte.config.mjs   Svelte + preprocess config
├── vite.config.ts      Vite config
└── tsconfig.json       TypeScript config
```