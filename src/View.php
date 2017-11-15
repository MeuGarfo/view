<?php
/**
* Basic
* Micro framework em PHP
*/
namespace Basic;

/**
 * Classe View
 */
class View
{
    /**
    * Retorna a primeira palavra de uma frase
    * @param  string $word Frase
    * @return string       Primeira palavra
    */
    public function firstWord(string $word)
    {
        return strtok($word, " ");
    }
    /**
    * Tradução usando o arquivo view/i18n.php
    * @param  string  $key   Nome da chave
    * @param  boolean $print Printar ou não
    * @return string         Texto traduzido
    */
    public function i18n(string $key, bool $print=true)
    {
        $language='pt';
        $filename=ROOT.'view/i18n.php';
        if (file_exists($filename)) {
            $i18n=require $filename;
            if (isset($i18n[$key][$language])) {
                $output=$i18n[$key][$language];
            } elseif (isset($i18n[$key][DEFAULT_LANGUAGE])) {
                $output=$i18n[$key][DEFAULT_LANGUAGE];
            } else {
                $output=$key;
            }
        } else {
            $output=$key;
        }
        if ($print) {
            print $output;
        } else {
            return $output;
        }
    }
    /**
    * Detecta se a requisição web é ajax ou não
    * @return bool Retorna true ou false
    */
    public function isAjax()
    {
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            return true;
        } else {
            return false;
        }
    }
    /**
    * Converte para JSON
    * @param  mixed  $data Dados a serem convertidos
    * @return string       String JSON com header HTTP
    */
    public function json($data)
    {
        header("Content-type:application/json");
        print json_encode($data, JSON_PRETTY_PRINT);
    }
    /**
    * Retorna uma parte da URL
    * @param  mixed  $key Número da parte (opcional)
    * @return mixed       Parte(s) da URL
    */
    public function segment($key = null)
    {
        $uri = @explode('?', $_SERVER ['REQUEST_URI'])[0];
        $uri = @explode('/', $uri);
        $uri = @array_values(array_filter($uri));
        if (is_null($key)) {
            if (count($uri)==0) {
                $uri[0]='/';
            }
            return $uri;
        } else {
            if (isset($uri [$key])) {
                return $uri [$key];
            } else {
                return false;
            }
        }
    }
    /**
    * View
    * @param  string  $name  Nome da view
    * @param  array   $data  Variáveis
    * @param  boolean $print Printar ou não
    * @return string         Conteúdo da view compilada
    */
    public function view(string $name, array $data=[], bool $print=true)
    {
        if ($name=='404') {
            header('HTTP/1.0 404 Not Found');
        }
        $filename='view/'.$name.'.php';
        $data['data']=$data;
        $data['viewName']=$name;
        if (file_exists($filename)) {
            extract($data);
            ob_start();
            require_once($filename);
            $output = ob_get_contents();
            ob_end_clean();
            if ($print) {
                print $output;
            } else {
                return $output;
            }
        } else {
            die('view <b>'.$filename.'</b> not found');
        }
    }
}
