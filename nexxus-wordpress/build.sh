#!/usr/bin/env bash
# Empaqueta el tema. Genera copias de la hoja de estilos y del script con la versión en el nombre,
# para que las cachés del servidor no sigan sirviendo archivos antiguos tras una actualización.
set -euo pipefail
cd "$(dirname "$0")"
VER=$(grep -m1 -oE "Version: [0-9.]+" nexxus/style.css | cut -d' ' -f2)
mkdir -p nexxus/assets/css
rm -f nexxus/assets/css/nexxus-*.css nexxus/assets/js/nexxus-*.js
sed 's#url("assets/#url("../#g' nexxus/style.css > "nexxus/assets/css/nexxus-$VER.css"
cp nexxus/assets/js/main.js "nexxus/assets/js/nexxus-$VER.js"
rm -f nexxus-tema-wordpress.zip
zip -qr nexxus-tema-wordpress.zip nexxus
echo "Tema $VER empaquetado"
