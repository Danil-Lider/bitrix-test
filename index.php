<?
//define("NO_AGENT_STATISTIC", true);

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
//require($_SERVER["DOCUMENT_ROOT"] . '/bitrix/modules/main/include/prolog_before.php');
$APPLICATION->SetPageProperty("title", "Демонстрационная версия продукта «1С-Битрикс: Управление сайтом»");
$APPLICATION->SetPageProperty("NOT_SHOW_NAV_CHAIN", "Y");
$APPLICATION->SetTitle("Главная страница");
?>


<?


$componentName = 'custom:get.info.by.ip';
$componentTemplate = '';

$APPLICATION->IncludeComponent(
    $componentName,         // имя компонента
    $componentTemplate,     //его шаблон, пустая строка если шаблон по умолчанию
    $arParams=array(),      // параметры
    $parentComponent=null,  // null или объект родительского компонента
    $arFunctionParams=array()
);



?>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>