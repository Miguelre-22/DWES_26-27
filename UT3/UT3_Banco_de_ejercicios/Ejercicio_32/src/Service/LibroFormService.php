<?php
declare(strict_types=1);
namespace App\Service;
use DateTimeImmutable;
use ValueError;
final class LibroFormService
{
    public function __construct(private Validator $v) {}

    public function validarPaginas(mixed $entrada): ?string
    {
        $n = is_string($entrada)
            ? filter_var($entrada, FILTER_VALIDATE_INT)
            : false;
        return $n === false || $n < 1 || $n > 3000
            ? 'Entre 1 y 3000 páginas.' : null;
    }

    public function procesar(array $entrada): array
    {
        $valores = [];
        $errores = [];
        foreach (['titulo', 'autor', 'paginas', 'genero',
            'fechaAlta'] as $campo) {
            $valor = $entrada[$campo] ?? '';
            // null explícito también es un tipo incorrecto.
            if (array_key_exists($campo, $entrada)
                && !is_string($entrada[$campo])) {
                $errores[$campo] = 'Debe ser texto.';
                $valor = '';
            }
            $valores[$campo] = trim($valor);
        }
        foreach (['titulo', 'autor'] as $campo) {
            if (isset($errores[$campo])) { continue; }
            $error = $this->v->requerido($valores[$campo],
                'El campo ' . $campo . ' es obligatorio.');
            if ($error !== null) { $errores[$campo] = $error; }
        }
        if (!isset($errores['titulo'])
            && mb_strlen($valores['titulo'], 'UTF-8') > 120) {
            $errores['titulo'] = 'Máximo 120 caracteres.';
        }
        if (!isset($errores['paginas'])) {
            $error = $this->validarPaginas($valores['paginas']);
            if ($error !== null) { $errores['paginas'] = $error; }
        }
        if (!isset($errores['genero']) && !in_array(
            $valores['genero'], ['ciencia', 'fantasia', 'terror'],
            true)) {
            $errores['genero'] = 'Elige un género válido.';
        }
        $fecha = null;
        if (!isset($errores['fechaAlta'])
            && $valores['fechaAlta'] !== '') {
            try {
                $fecha = DateTimeImmutable::createFromFormat(
                    '!Y-m-d', $valores['fechaAlta']);
            } catch (ValueError) { $fecha = false; }
            if ($fecha === false || $fecha->format('Y-m-d')
                !== $valores['fechaAlta']) {
                $errores['fechaAlta'] = 'Fecha no válida.';
            }
        }
        return [
            'valores' => $valores,
            'errores' => $errores,
            'datos' => $errores === [] ? [
                'titulo' => $valores['titulo'],
                'autor' => $valores['autor'],
                'paginas' => (int) $valores['paginas'],
                'genero' => $valores['genero'],
                'fechaAlta' => $fecha,
            ] : null,
        ];
    }
}
