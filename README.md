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