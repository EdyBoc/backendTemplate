<?php

namespace App\Services;

use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\SvgWriter;

class ServicioDobleFactor
{
    private const ALFABETO_BASE32 = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';

    public function generarSecreto(int $longitud = 32): string
    {
        $secreto = '';
        $maximo = strlen(self::ALFABETO_BASE32) - 1;

        for ($indice = 0; $indice < $longitud; $indice++) {
            $secreto .= self::ALFABETO_BASE32[random_int(0, $maximo)];
        }

        return $secreto;
    }

    public function verificarCodigo(string $secreto, string $codigo, int $ventana = 1): bool
    {
        if (! preg_match('/^\d{6}$/', $codigo)) {
            return false;
        }

        $contadorActual = (int) floor(time() / 30);

        for ($desplazamiento = -$ventana; $desplazamiento <= $ventana; $desplazamiento++) {
            $codigoEsperado = $this->generarCodigo($secreto, $contadorActual + $desplazamiento);

            if (hash_equals($codigoEsperado, $codigo)) {
                return true;
            }
        }

        return false;
    }

    public function generarUri(string $correoElectronico, string $secreto, string $emisor): string
    {
        $etiqueta = rawurlencode($emisor . ':' . $correoElectronico);

        return 'otpauth://totp/' . $etiqueta
            . '?secret=' . $secreto
            . '&issuer=' . rawurlencode($emisor)
            . '&digits=6&period=30';
    }

    private function generarCodigo(string $secreto, int $contador): string
    {
        $clave = $this->decodificarBase32($secreto);
        $parteAlta = ($contador >> 32) & 0xffffffff;
        $parteBaja = $contador & 0xffffffff;
        $contadorBinario = pack('N2', $parteAlta, $parteBaja);

        $hash = hash_hmac('sha1', $contadorBinario, $clave, true);
        $desplazamiento = ord($hash[19]) & 0x0f;
        $segmento = substr($hash, $desplazamiento, 4);
        $valor = unpack('N', $segmento)[1] & 0x7fffffff;
        $codigo = (string) ($valor % 1000000);

        return str_pad($codigo, 6, '0', STR_PAD_LEFT);
    }

    private function decodificarBase32(string $valor): string
    {
        $valor = strtoupper(preg_replace('/[^A-Z2-7]/', '', $valor) ?? '');
        $bits = '';

        foreach (str_split($valor) as $caracter) {
            $posicion = strpos(self::ALFABETO_BASE32, $caracter);

            if ($posicion === false) {
                continue;
            }

            $bits .= str_pad(decbin($posicion), 5, '0', STR_PAD_LEFT);
        }

        $resultado = '';

        for ($indice = 0; $indice + 8 <= strlen($bits); $indice += 8) {
            $resultado .= chr(bindec(substr($bits, $indice, 8)));
        }

        return $resultado;
    }

    public function generarCodigoQr(string $uriConfiguracion): string
    {
        $codigoQr = QrCode::create($uriConfiguracion)
            ->setEncoding(new Encoding('UTF-8'))
            ->setErrorCorrectionLevel(ErrorCorrectionLevel::High)
            ->setSize(260)
            ->setMargin(10)
            ->setRoundBlockSizeMode(RoundBlockSizeMode::Margin);

        $resultado = (new SvgWriter())->write($codigoQr);

        return $resultado->getDataUri();
    }
}
