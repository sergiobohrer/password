<?php

/**
 *
 * @author Sérgio Bohrer Reis <sergio.bohrer@gmail.com>
 * @version 1.0
 * 
 * @section LICENSE
 *
 * Este programa é software livre; você pode redistribuí-lo e / ou modificá-lo sob
 * os termos da GNU General Public License conforme publicada pela Free Software Foundation;
 * 
 * @section DESCRIPTION
 * 
 * Classe responsável pela verificação dos limites de caracteres mínimos e máximos de uma senha
 * além da verificação de espaços e o nível de força da mesma.
 */
class passwordUtil
{
    // Armazena a última mensagem de erro
    private $lastError = '';
    // Armazena a quantidade mínima de itens do conjunto necessário para considerar uma senha forte
    private $matchRules = 3;

    /**
     * Construtor da classe
     */
    public function __construct()
    {
    }

    /**
     * Retorna a última mensagem de erro
     *
     * @return (string) - Mensagem de erro.
     *                    Vazio caso nenhum erro tenha sido encontrado.
     */
    public function getLastError()
    {
        return $this->lastError;
    }

    /**
     * Verifica se a senha está dentro do tamanho máximo e mínimo permitido
     *
     * @param (string) Password - Senha que será verificada
     * @param (integer) MinLen - Tamanho mínimo permitido (-1 para ignorar tamanho mínimo)
     * @param (integer) MaxLen - Tamanho máximo permitido (-1 para ignorar tamanho máximo)
     *
     * @return (bool) - True/False de acordo com os limites de tamanho da senha
     */
    private function isValidLenPassword( $password, $minLen, $maxLen )
    {
        $this->lastError = '';

        if ( $minLen != -1 || $maxLen != -1 )
        {
            $passwordLen = strlen( $password );

            if ( ( $minLen != -1 && $maxLen != -1 ) && ( $passwordLen < $minLen || $passwordLen > $maxLen ) )
            {
                $this->lastError = "A senha deve ter mais de $minLen e menos de $maxLen caracteres.";
                return false;
            }

            if ( $minLen != -1 && $passwordLen < $minLen )
            {
                $this->lastError = "A senha deve ter mais de $minLen caracteres.";
                return false;
            }

            if ( $maxLen != -1 && $passwordLen > $maxLen )
            {
                $this->lastError = "A senha deve ter menos que $maxLen caracteres.";
                return false;
            }
        }
        return true;
    }

    /**
     * Determina se uma senha é forte (para ser forte ela deve ter no mínimo X itens dos 5 itens no conjunto, onde X é determinado na variável matchRules)
     * Conjunto = (números, letras minúsculas, letras maiúsculas, não alfanuméricos e caracteres especiais)
     *
     * @param (string) password - Senha a ser verificada
     * @param (int) minLen (opcional) - Tamanho mínimo da senha (default: 8 digitos)
     * @param (int) maxLen (opcional) - Tamanho máximo da senha (default: 15 digitos)
     *
     * @return (bool) - True em caso de sucesso
     *                  False em caso de falha. Utilize getLastError para saber o motivo da falha.
     */
    public function isStrongPassword( $password, $minLen = 8, $maxLen = 15 )
    {
        $this->lastError = '';

        if ( ! is_string( $password ) || trim( $password ) == '' )
        {
            $this->lastError = 'A senha não foi informada.';
            return false;
        }

        if ( ! is_numeric( $minLen ) || ! is_numeric( $maxLen ) )
        {
            $this->lastError = 'Os limites de senha não estão de acordo.';
            return false;
        }

        if ( ! $this->isValidLenPassword( $password, $minLen, $maxLen ) )
        {
            return false;
        }

        if ( strpos( $password, ' ' ) !== false )
        {
            $this->lastError = 'A senha não pode conter espaços.';
            return false;
        }

        $rules = array( '/[0-9]/', '/[A-Z]/', '/[a-z]/', '/[-\/:\-@\[-\`\{-~]/', '/[^0-9A-Za-z-\/:-@\[-`{-~]/' );

        $matches = 0;

        foreach ( $rules as $rule )
        {
            if ( preg_match( $rule, $password ) === 1 )
            {
                $matches++;
            }
        }

        if ( $matches >= $this->matchRules )
        {
            return true;
        }

        $this->lastError = 'A senha informada é fraca. Tente utilizar números, letras minúsculas, letras maiúsculas e caracteres especiais.';
        return false; 
    }
}