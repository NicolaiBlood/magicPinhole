# Build stage: compile the Vite + Svelte + TS app to static assets
FROM node:20-alpine AS build
WORKDIR /app

COPY package.json package-lock.json ./
RUN npm ci

COPY . .
RUN npm run build

# Runtime stage: serve the built static assets with nginx
FROM nginx:1.27-alpine AS runtime

LABEL org.opencontainers.image.title="magicPinhole" \
      org.opencontainers.image.description="Magic Pinhole eyesight improvement product website" \
      org.opencontainers.image.source="https://github.com/NicolaiBlood/magicPinhole"

COPY --from=build /app/dist /usr/share/nginx/html

EXPOSE 80

HEALTHCHECK --interval=30s --timeout=3s --start-period=5s --retries=3 \
  CMD wget -qO- http://127.0.0.1/ >/dev/null 2>&1 || exit 1

CMD ["nginx", "-g", "daemon off;"]
