# Magic Pinhole

A simple, natural approach to eyesight improvement — straight from the magic of the pinhole.

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
│   ├── App.svelte      Main component
│   ├── main.ts         App bootstrap
│   └── app.css         Global styles
├── svelte.config.mjs   Svelte + preprocess config
├── vite.config.ts      Vite config
└── tsconfig.json       TypeScript config
```