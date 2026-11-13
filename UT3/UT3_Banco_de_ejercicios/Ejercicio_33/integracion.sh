#!/usr/bin/env bash
set -u

EJ21="${1:-../Ejercicio_21}"
URL="http://localhost:8021/formulario-portada.php"
PORTADAS="$EJ21/storage/portadas"

php -S localhost:8021 -t "$EJ21/public" >/dev/null 2>&1 &
SERVIDOR=$!
trap 'kill $SERVIDOR' EXIT
sleep 1

antes=$(ls "$PORTADAS" | wc -l)
respuesta=$(curl -s -w '\n%{http_code}' -F titulo=Dune -F paginas=412 -F "portada=@$EJ21/pruebas/portada.png" "$URL")
estado=$(tail -n1 <<< "$respuesta")
nombre=$(grep -oE '[a-f0-9]{32}\.png' <<< "$respuesta" | head -n1)
despues=$(ls "$PORTADAS" | wc -l)

fallos=0
[ "$estado" = "200" ] || { echo "FALLO: estado $estado"; fallos=1; }
grep -q 'Libro guardado' <<< "$respuesta" || { echo "FALLO: sin confirmación"; fallos=1; }
[ "$despues" -eq $((antes + 1)) ] || { echo "FALLO: no hay un archivo nuevo"; fallos=1; }
[ -n "$nombre" ] && [ -f "$PORTADAS/$nombre" ] || { echo "FALLO: no se encuentra $nombre"; fallos=1; }
[ -n "$nombre" ] && [ "$(file -b --mime-type "$PORTADAS/$nombre")" = "image/png" ] || { echo "FALLO: el archivo movido no es PNG"; fallos=1; }

if [ $fallos -eq 0 ]; then
    echo "OK: subida recibida y movida a storage/portadas/$nombre"
    rm "$PORTADAS/$nombre"
fi
exit $fallos
