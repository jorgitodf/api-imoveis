<?php

namespace App\Helpers;

use DateTime;

class Helpers
{
    public static function data_inicial()
    {
        $ano = date("Y");
        $mes = date("m");
        return "{$ano}-{$mes}-01";
    }

    public static function data_final()
    {
        $ano = date("Y");
        $mes = date("m");
        return "{$ano}-{$mes}-31";
    }

    public static function ano_inicial()
    {
        $ano = date("Y");
        return "{$ano}-01-01";
    }

    public static function ano_final()
    {
        $ano = date("Y");
        return "{$ano}-12-31";
    }

    public static function getAno()
    {
        $ano = date("Y");
        return "{$ano}";
    }

    public static function formatarMoeda($valor)
    {
        if (!empty($valor)) {
            $valor1 = trim(str_replace('R$ ', '', $valor));
            $number = str_replace(',', '.', preg_replace('#[^\d\,]#is', '', $valor1));
            return number_format((float) $number, 2, ".", "");
        }
    }

    public static function formatarMoedaEnPt($valor)
    {
        if (!empty($valor)) {
            return "R$ " . number_format($valor, 2, ",", ".");
        }
    }

    public static function formataData($data)
    {
        if (!empty($data)) {
            $d = explode("/", $data);
            $data_format = (trim($d[2] . "-" . $d[1] . "-" . $d[0]));
            return $data_format;
        }
    }

    public static function formataDataEnPt($data)
    {
        if (!empty($data)) {
            $d = explode("-", $data);
            $data_format = (trim($d[2] . "/" . $d[1] . "/" . $d[0]));
            return $data_format;
        }
    }



    public static function dataPagamento($dataCompra, int $id_cartao)
    {
        $data_pagamento = "";
        $diaFF = "";

        $mes30 = [4,6,9,11];
        $mes31 = [1,3,5,7,8,10,12];

        $dia_compra = date('d', strtotime(Helpers::formataData($dataCompra)));
        $mes_compra = date('m', strtotime(Helpers::formataData($dataCompra)));
        $ano_compra = date('Y', strtotime(Helpers::formataData($dataCompra)));

        if ($id_cartao == 3) {
            if (in_array($mes_compra, $mes30)) {
                $diaFF = '27';
            } elseif (in_array($mes_compra, $mes31)) {
                $diaFF = '26';
            }
        } elseif ($id_cartao == 2) {
            if (in_array($mes_compra, $mes30)) {
                $diaFF = '29';
            } elseif (in_array($mes_compra, $mes31)) {
                $diaFF = '28';
            }
        } elseif ($id_cartao == 1) {
            if (in_array($mes_compra, $mes30)) {
                $diaFF = '28';
            } elseif (in_array($mes_compra, $mes31)) {
                $diaFF = '29';
            }
        }

        if ($id_cartao == 3 && $dia_compra <= $diaFF) {
            $data_pagamento = date('Y-m-d', strtotime("+1 month", strtotime("{$ano_compra}-{$mes_compra}-04")));
        } elseif ($id_cartao == 3 && $dia_compra > $diaFF) {
            $data_pagamento = date('Y-m-d', strtotime("+2 month", strtotime("{$ano_compra}-{$mes_compra}-04")));
        } elseif ($id_cartao == 2 && $dia_compra <= $diaFF) {
            $data_pagamento = date('Y-m-d', strtotime("+1 month", strtotime("{$ano_compra}-{$mes_compra}-08")));
        } elseif ($id_cartao == 2 && $dia_compra > $diaFF) {
            $data_pagamento = date('Y-m-d', strtotime("+2 month", strtotime("{$ano_compra}-{$mes_compra}-08")));
        } elseif ($id_cartao == 1 && $dia_compra <= $diaFF) {
            $data_pagamento = date('Y-m-d', strtotime("+1 month", strtotime("{$ano_compra}-{$mes_compra}-08")));
        } elseif ($id_cartao == 1 && $dia_compra > $diaFF) {
            $data_pagamento = date('Y-m-d', strtotime("+2 month", strtotime("{$ano_compra}-{$mes_compra}-08")));
        }

        // print_r($data_pagamento);
        //exit;

        return $data_pagamento;
    }

    public static function verificaMes()
    {
        $mesAtual = date("m");
        switch ($mesAtual) {
            case '01':
                $mesAtual = 'Janeiro';
                break;
            case '02':
                $mesAtual = 'Fevereiro';
                break;
            case '03':
                $mesAtual = 'Março';
                break;
            case '04':
                $mesAtual = 'Abril';
                break;
            case '05':
                $mesAtual = 'Maio';
                break;
            case '06':
                $mesAtual = 'Junho';
                break;
            case '07':
                $mesAtual = 'Julho';
                break;
            case '08':
                $mesAtual = 'Agosto';
                break;
            case '09':
                $mesAtual = 'Setembro';
                break;
            case '10':
                $mesAtual = 'Outubro';
                break;
            case '11':
                $mesAtual = 'Novembro';
                break;
            case '12':
                $mesAtual = 'Dezembro';
                break;
        }
        return $mesAtual;
    }

    public static function defineMesReferencia()
    {
        $mesAtual = date("m");
        $anoAtual = date("Y");
        $mesReferencia = "";
        switch ($mesAtual) {
            case '01':
                $mesReferencia = "{$anoAtual}-{$mesAtual}";
                break;
            case '02':
                $mesReferencia = "{$anoAtual}-{$mesAtual}";
                break;
            case '03':
                $mesReferencia = "{$anoAtual}-{$mesAtual}";
                break;
            case '04':
                $mesReferencia = "{$anoAtual}-{$mesAtual}";
                break;
            case '05':
                $mesReferencia = "{$anoAtual}-{$mesAtual}";
                break;
            case '06':
                $mesReferencia = "{$anoAtual}-{$mesAtual}";
                break;
            case '07':
                $mesReferencia = "{$anoAtual}-{$mesAtual}";
                break;
            case '08':
                $mesReferencia = "{$anoAtual}-{$mesAtual}";
                break;
            case '09':
                $mesReferencia = "{$anoAtual}-{$mesAtual}";
                break;
            case '10':
                $mesReferencia = "{$anoAtual}-{$mesAtual}";
                break;
            case '11':
                $mesReferencia = "{$anoAtual}-{$mesAtual}";
                break;
            case '12':
                $mesReferencia = "{$anoAtual}-{$mesAtual}";
                break;
        }
        return $mesReferencia;
    }

    public static function verificaMesNumerico()
    {
        $mesAtual = date("m");
        switch ($mesAtual) {
            case '01':
                $mesAtual = '01';
                break;
            case '02':
                $mesAtual = '02';
                break;
            case '03':
                $mesAtual = '03';
                break;
            case '04':
                $mesAtual = '04';
                break;
            case '05':
                $mesAtual = '05';
                break;
            case '06':
                $mesAtual = '06';
                break;
            case '07':
                $mesAtual = '07';
                break;
            case '08':
                $mesAtual = '08';
                break;
            case '09':
                $mesAtual = '09';
                break;
            case '10':
                $mesAtual = '10';
                break;
            case '11':
                $mesAtual = '11';
                break;
            case '12':
                $mesAtual = '12';
                break;
        }
        return $mesAtual;
    }
}
