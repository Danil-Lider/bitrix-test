<?php


use classes\SypexGeo;

use Bitrix\Main\Loader;

use Bitrix\Main\Localization\Loc;

// пространства имен highloadblock
use Bitrix\Highloadblock\HighloadBlockTable;

use Bitrix\Main\Entity;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

class GetInformationByIpAjaxController extends \Bitrix\Main\Engine\Controller
{

    // Обязательный метод
    public function configureActions()
    {
        // Сбрасываем фильтры по-умолчанию (ActionFilter\Authentication и ActionFilter\HttpMethod)
        // Предустановленные фильтры находятся в папке /bitrix/modules/main/lib/engine/actionfilter/
        return [
            'sendMessage' => [ // Ajax-метод
                'prefilters' => [],
            ],
        ];
    }

    // Ajax-методы должны быть с постфиксом Action
    public function getInformationByIpAction($post)
    {
        $ip = $post['ip'];

        try {

            // подключаем метод проверки подключения модуля «Информационные блоки»
            $this->checkModules();

            $this->checkValidationIp($ip);

            // подключаем метод подготовки массива $arResult
            return $this->getResult($ip);


        } catch (Exception  $e) {
            return (string) $e->getMessage();
        }

    }

    protected function getResult($ip){

        $result['from'] = 'getResultFromHL';
        $result['result'] = $this->getResultFromHL($ip);

        if(empty($result['result'])){
            $result['from'] = 'getResultFromSypexGeo';
            $result['result'] = $this->getResultFromSypexGeoAndAddInHL($ip);
        }

        $result['result'] = json_decode($result['result']);
        return $result;

    }

    protected function getResultFromHL($ip){

        $result = $this->getHLDataClass()::getList(array(
            "select" => array("UF_TEXT"),
            "order" => array("ID"=>"DESC"),
            "filter" => Array("UF_IP"=> $ip ),

        ));

        while ($arRow = $result->Fetch())
        {
            return $arRow['UF_TEXT'];
        }
    }


    protected function getResultFromSypexGeoAndAddInHL($ip){
        $SG = new SypexGeo();
        $info = $SG->get_info($ip);

        // Массив полей для добавления
        $data = array(
            "UF_IP"=> $ip,
            "UF_TEXT"=> $info,
        );

        // добавление в HL
        $result = $this->getHLDataClass()::add($data);
        return $info;
    }

    protected function checkValidationIp($ip){

        $valid = filter_var($ip, FILTER_VALIDATE_IP);

        if(!$valid){
            throw new Exception('Ip не проходит валидацию');
        }

    }

    protected function checkModules()
    {
        // если модуль не подключен
        if (!Loader::includeModule('highloadblock'))
            // выводим сообщение в catch
            throw new Exception(Loc::getMessage('IBLOCK_MODULE_NOT_INSTALLED'));
    }

    /*
     * Метод для получения наименование класса HL
     * */
    protected function getHLDataClass(){
        // делаем выборку хайлоуд блока с ID 1
        $arHLBlock = Bitrix\Highloadblock\HighloadBlockTable::getById(1)->fetch();
        // инициализируем класс сущности хайлоуд блока с ID 1
        $obEntity = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($arHLBlock);
        // обращаемся к DataManager
        $strEntityDataClass = $obEntity->getDataClass();

        return $strEntityDataClass;
    }


}