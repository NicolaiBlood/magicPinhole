# Build stage: serve the static site with nginx
FROM nginx:1.27-alpine

LABEL org.opencontainers.image.title="magicPinhole" \
      org.opencontainers.image.description="Magic Pinhole eyesight improvement product website" \
      org.opencontainers.image.source="https://github.com/NicolaiBlood/magicPinhole"

COPY index.html /usr/share/nginx/html/index.html

EXPOSE 80

HEALTHCHECK --interval=30s --timeout=3s --start-period=5s --retries=3 \
  CMD wget -qO- http://127.0.0.1/ >/dev/null 2>&1 || exit 1

CMD ["nginx", "-g", "daemon off;"]
