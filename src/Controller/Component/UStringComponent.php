<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;
use Cake\Utility\Security;

class UStringComponent extends Component
{
    
    public static function SelectEstados()
    {
    	return array("AC"=>"Acre", "AL"=>"Alagoas", "AM"=>"Amazonas", "AP"=>"Amapá","BA"=>"Bahia","CE"=>"Ceará","DF"=>"Distrito Federal","ES"=>"Espírito Santo","GO"=>"Goiás","MA"=>"Maranhão","MT"=>"Mato Grosso","MS"=>"Mato Grosso do Sul","MG"=>"Minas Gerais","PA"=>"Pará","PB"=>"Paraíba","PR"=>"Paraná","PE"=>"Pernambuco","PI"=>"Piauí","RJ"=>"Rio de Janeiro","RN"=>"Rio Grande do Norte","RO"=>"Rondônia","RS"=>"Rio Grande do Sul","RR"=>"Roraima","SC"=>"Santa Catarina","SE"=>"Sergipe","SP"=>"São Paulo","TO"=>"Tocantins");
    }

    public static function SelectUF($codigoPais)
    {
        $conn = TableRegistry::get("uf");

        $pais = TableRegistry::get("pais")->find('all')->where(['codigo' => $codigoPais])->first();

        if($pais == null)
            return null;

        $ufs = $conn->find('all')->select(['Sigla', 'Nome'])->where(['CodigoPais' => $pais->Codigo]);

        return $ufs->toArray();
    }

    public static function SelectCidades($sigla)
    {
        $conn = TableRegistry::get("Cidade");

        $UF = TableRegistry::get("uf")->find('all')->where(['sigla' => strtoupper($sigla)])->first();

        if($UF == null)
            return null;

        $cidades = $conn->find('all')->select(['Codigo', 'Nome'])->where(['CodigoUF' => $UF->Codigo]);

        return $cidades->toArray();
    }

    // remove caracteres especiais
    public static function AntiXSS($valor){
    	$valor = !UStringComponent::VazioOuNulo($valor) ? htmlspecialchars($valor) : "";
    	return $valor;
    }

    // coloca os caracteres especiais e limita o tamanho
    public static function AntiXSSComLimite($valor, $tamanho){
        return UStringComponent::LimitarTamanho(UStringComponent::AntiXSS($valor), $tamanho);
    }

    // diminui o tamanho de entrada de um valor
    public static function LimitarTamanho($valor, $tamanho){
        $valor = strlen($valor) <= $tamanho ? $valor : substr($valor, 0, $tamanho);
        return $valor;
    }

    public static function ValidarSenha($senha){
        //return preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&+()*=]).{6,}/', $senha);
        return preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]){6,}/', $senha);
    }

    public static function VazioOuNulo($valor){
    	return !isset($valor) || empty($valor) || $valor == null;
    }

    public static function GerarSlug($valor){
        return strtolower(preg_replace("/[^a-zA-Z0-9_]/", "", $valor));
    }

    public static function ValidarEmail($email){
        return preg_match('/^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/', $email);
    }

    public static function registrarErro($pagina, Exception $ex, $variaveis){
        $log = TableRegistry::get('LogsErro');

        try{
            $novoLog = $log->newEntity();
            $novoLog->Pagina = $pagina;
            if($ex != null){
                $novoLog->Stack = $ex->StackTrace;
                $novoLog->Mensagem = $ex->Mensagem;
            }
            $novoLog->Variaveis = $variaveis;

            $log->save($novoLog);

        }catch(Exception $ex){
            // nada a fazer
        }
    }

    // http://php.net/manual/en/function.com-create-guid.php
    public static function guid(){
        if (function_exists('com_create_guid') === true)
        {
            return trim(com_create_guid(), '{}');
        }

        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }

    // http://stackoverflow.com/questions/3371697/replacing-accented-characters-php
    public static function AcentoPraLetra($texto) 
    {
        $unwanted_array = array('Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E','Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U','Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c','è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o','ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );
        $texto = strtr($texto, $unwanted_array);

        return $texto;
    }

    public static function Slugfy($texto){

        if(strlen($texto) == 0){
            return $texto;
        }else{
            $texto = str_replace("-", " ", $texto);
            $texto = str_replace(" ", "-", $texto);
           
            $texto = UStringComponent::AcentoPraLetra($texto);
            $texto = preg_replace("/[^A-Za-z0-9\-]/", "", $texto);

            $texto = str_replace("--", "-", $texto);
            
            return strtolower($texto);
        }

    }

    public static function AntiXSSEmArrayComLimite($array, $nome, $limite){

        if(array_key_exists($nome, $array))
        {
            return UStringComponent::AntiXSSComLimite($array[$nome], $limite);
        }

        return null;
    }

    public static function Encrypt($valor, $salt)
    {
        return Security::encrypt($valor, $salt);
    }
}

?>