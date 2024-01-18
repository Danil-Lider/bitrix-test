<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?
CJSCore::Init(array("jquery"));
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

<section>

    <div class="input-group mb-3">
        <input id="input_ip" type="text" class="form-control" placeholder="Введите ip адресс"  aria-describedby="basic-addon2">
        <div class="input-group-append">
            <button id="btn-get-info-by-ip" class="btn btn-outline-secondary" type="button">Получить информацию</button>
        </div>
    </div>

    <div class="row">
        <div id="result-info-by-ip" class="">

        </div>
    </div>


<script>

    $("#btn-get-info-by-ip").on( "click", function() {

        var ip = $("#input_ip").val();

        BX.ajax.runComponentAction('custom:get.info.by.ip',
            'getInformationByIp', { // Вызывается без постфикса Action
                mode: 'ajax',
                data: {
                    post: {ip}
                }, // ключи объекта data соответствуют параметрам метода
            })
            .then(

                function(response) {

                    console.log(response)

                    if(!response.data.result){

                        $('#result-info-by-ip').html('<div class="alert alert-danger">' + response.data + '</div>')

                    }else{

                        showInformation(response.data.result)
                    }
                }

            );

    } );

    function showInformation(text){
        let region = text.region.name_ru;
        let country = text.country.name_ru;
        let city = text.city.name_ru;

        let html = '<div class="alert alert-success">';
        html+= '<div class="text-nowrap"> <b>Страна: </b>' + country + '</div>';
        html+= '<div class="text-nowrap"> <b>Регион: </b>' + region + '</div>';
        html+= '<div class="text-nowrap"> <b>Город: </b>' + city + '</div>';
        html+= '</div>';

        $('#result-info-by-ip').html(html)

    }

</script>

</section>