FROM alpine:3.20
LABEL org.opencontainers.image.title="php-stakeholder"
LABEL org.opencontainers.image.description="Scaffold-only placeholder container for php-stakeholder"
CMD ["sh", "-lc", "echo 'php-stakeholder scaffold-only baseline';"]
