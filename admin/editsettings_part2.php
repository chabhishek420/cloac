
<div class="form-group-inner">
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <label class="login2 pull-left pull-left-pro">Добавлять событие ViewContent после просмотра страницы в течении указанного ниже времени? </label>
        </div>
        <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
            <div class="bt-df-checkbox pull-left">

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="i-checks pull-left">
                            <label>
                                    <input type="radio" <?=$tt_use_viewcontent===false?'checked':''?> value="false" name="pixels.tt.viewcontent.use" onclick="(document.getElementById('tt_8-2').style.display='none')"> Нет </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="i-checks pull-left">
                            <label>
                                    <input type="radio" <?=$tt_use_viewcontent===true?'checked':''?> value="true" name="pixels.tt.viewcontent.use" onclick="(document.getElementById('tt_8-2').style.display='block')"> Да, добавлять </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="tt_8-2" style="display:<?=$tt_use_viewcontent===true?'block':'none'?>;">
<div class="form-group-inner">
    <div class="row">
        <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
            <label class="login2 pull-left pull-left-pro">Время в сек после которго отправляется ViewContent:<br><small>если 0, то событие не будет вызвано</small> </label>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <div class="input-group custom-go-button">
                <input type="text" class="form-control" placeholder="30" name="pixels.tt.viewcontent.time" value="<?=$tt_view_content_time?>">
            </div>
        </div>
    </div>
</div>

<div class="form-group-inner">
    <div class="row">
        <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
            <label class="login2 pull-left pull-left-pro">Процент проскролливания страницы, до вызова события ViewContent:<br><small>если 0, то событие не будет вызвано</small> </label>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <div class="input-group custom-go-button">
                <input type="text" class="form-control" placeholder="75" name="pixels.tt.viewcontent.percent" value="<?=$tt_view_content_percent?>">
            </div>
        </div>
    </div>
</div>
</div>
<div class="form-group-inner">
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <label class="login2 pull-left pull-left-pro">Какое событие будем использовать для конверсии в TikTok? <small>Например: CompletePayment или AddPaymentInfo</small></label>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <div class="input-group custom-go-button">
                <input type="text" class="form-control" placeholder="Lead" name="pixels.tt.conversion.event" value="<?=$tt_thankyou_event?>">
            </div>
        </div>
    </div>
</div>
<br>
<hr>
<h4>#4 Настройка TDS</h4>
<div class="form-group-inner">
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <label class="login2 pull-left pull-left-pro">Режим работы TDS:</label>
        </div>
        <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
            <div class="bt-df-checkbox pull-left">

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="i-checks pull-left">
                            <label>
                                    <input type="radio" <?=$tds_mode==='on'?'checked':''?> value="on" name="tds.mode"> Обычный </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="i-checks pull-left">
                            <label>
                                    <input type="radio" <?=$tds_mode==='full'?'checked':''?> value="full" name="tds.mode"> Посылать всех на вайт</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="i-checks pull-left">
                            <label>
                                    <input type="radio" <?=$tds_mode==='off'?'checked':''?> value="off" name="tds.mode"> Посылать всех на блэк (TDS отключена)</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-group-inner">
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <label class="login2 pull-left pull-left-pro">Посылать одного и того же юзера на одни и те же проклы-ленды?</label>
        </div>
        <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
            <div class="bt-df-checkbox pull-left">

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="i-checks pull-left">
                            <label>
                                    <input type="radio" <?=$save_user_flow===false?'checked':''?> value="false" name="tds.saveuserflow"> Нет </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="i-checks pull-left">
                            <label>
                                    <input type="radio" <?=$save_user_flow===true?'checked':''?> value="true" name="tds.saveuserflow"> Да, посылать </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<br>
<hr>
<h4>#5 Настройка фильтров</h4>
<div class="form-group-inner">
    <div class="row">
        <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
            <label class="login2 pull-left pull-left-pro">Список разрешённых ОС:</label>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="input-group custom-go-button">
                <input type="text" name="tds.filters.allowed.os" class="form-control" placeholder="Android,iOS,Windows,OS X" value="<?=implode(',',$os_white)?>">
            </div>
        </div>
    </div>
</div>

<div class="form-group-inner">
    <div class="row">
        <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
            <label class="login2 pull-left pull-left-pro">Список разрешённых стран: <small>(WW или пустое значение для всего мира)</small></label>
        </div>
        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
            <div class="input-group custom-go-button">
                <input type="text" name="tds.filters.allowed.countries" class="form-control" placeholder="RU,UA" value="<?=implode(',',$country_white)?>">
            </div>
        </div>
    </div>
</div>

<div class="form-group-inner">
    <div class="row">
        <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
            <label class="login2 pull-left pull-left-pro">Список разрешённых языков: <small>(any или пустое значение для всех языков)</small></label>
        </div>
        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
            <div class="input-group custom-go-button">
                <input type="text" name="tds.filters.allowed.languages" class="form-control" placeholder="en,ru,de" value="<?=implode(',',$lang_white)?>">
            </div>
        </div>
    </div>
</div>

<div class="form-group-inner">
    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
            <label class="login2 pull-left pull-left-pro">Имя файла дополнительной базы с запрещёнными IP-адресами <small>файл должен лежать в папке bases</small></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <div class="input-group custom-go-button">
                <input type="text" name="tds.filters.blocked.ips.filename" class="form-control" placeholder="blackbase.txt" value="<?=$ip_black_filename?>">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <label class="login2 pull-left pull-left-pro">Дополнительная база запрещённых IP в формате CIDR?</label>
        </div>
        <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
            <div class="bt-df-checkbox pull-left">

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="i-checks pull-left">
                            <label>
                                    <input type="radio" <?=$ip_black_cidr===false?'checked':''?> value="false" name="tds.filters.blocked.ips.cidrformat"> Нет </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="i-checks pull-left">
                            <label>
                                    <input type="radio" <?=$ip_black_cidr===true?'checked':''?> value="true" name="tds.filters.blocked.ips.cidrformat"> Да </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-group-inner">
    <div class="row">
        <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
            <label class="login2 pull-left pull-left-pro">Слова через запятую, при наличии которых в адресе перехода (в ссылке, по которой перешли), юзер будет отправлен на whitepage</label>
        </div>
        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
            <div class="input-group custom-go-button">
                <input type="text" name="tds.filters.blocked.tokens" class="form-control" placeholder="" value="<?=implode(',',$tokens_black)?>">
            </div>
        </div>
    </div>
</div>

<div class="form-group-inner">
    <div class="row">
        <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
            <label class="login2 pull-left pull-left-pro">Слова через запятую, которые обязательно должны быть в адресе. Если хотя бы чего-то нет - показывается вайт</label>
        </div>
        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
            <div class="input-group custom-go-button">
                <input type="text" name="tds.filters.allowed.inurl" class="form-control" placeholder="" value="<?=implode(',',$url_should_contain)?>">
            </div>
        </div>
    </div>
</div>

<div class="form-group-inner">
    <div class="row">
        <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
            <label class="login2 pull-left pull-left-pro">Слова через запятую, при наличии которых в UserAgent, юзер будет отправлен на whitepage</label>
        </div>
        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
            <div class="input-group custom-go-button">
                <input type="text" class="form-control" placeholder="facebook,Facebot,curl,gce-spider,yandex.com/bots" name="tds.filters.blocked.useragents" value="<?=implode(',',$ua_black)?>">
            </div>
        </div>
    </div>
</div>

<div class="form-group-inner">
    <div class="row">
        <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
            <label class="login2 pull-left pull-left-pro">Блокировка по провадеру (ISP), например: facebook,google</label>
        </div>
        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
            <div class="input-group custom-go-button">
                <input type="text" name="tds.filters.blocked.isps" class="form-control" placeholder="facebook,google,yandex,amazon,azure,digitalocean" value="<?=implode(',',$isp_black)?>">
            </div>
        </div>
    </div>
</div>

<div class="form-group-inner">
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <label class="login2 pull-left pull-left-pro">Посылать все запросы без referer на whitepage?</label>
        </div>
        <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
            <div class="bt-df-checkbox pull-left">

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="i-checks pull-left">
                            <label>
                                    <input type="radio" <?=$block_without_referer===false?'checked':''?> value="false" name="tds.filters.blocked.referer.empty"> Нет </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="i-checks pull-left">
                            <label>
                                    <input type="radio" <?=$block_without_referer===true?'checked':''?> value="true" name="tds.filters.blocked.referer.empty"> Да </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-group-inner">
    <div class="row">
        <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
            <label class="login2 pull-left pull-left-pro">Слова через запятую, при наличии которых в реферере, юзер будет отправлен на whitepage</label>
        </div>
        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
            <div class="input-group custom-go-button">
                <input type="text" name="tds.filters.blocked.referer.stopwords" class="form-control" placeholder="adheart" value="<?=implode(',',$referer_stopwords)?>">
            </div>
        </div>
    </div>
</div>

<div class="form-group-inner">
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <label class="login2 pull-left pull-left-pro">Посылать всех, использующих VPN и Tor на вайт?</label>
        </div>
        <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
            <div class="bt-df-checkbox pull-left">

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="i-checks pull-left">
                            <label>
                                    <input type="radio" <?=$block_vpnandtor===false?'checked':''?> value="false" name="tds.filters.blocked.vpntor"> Нет </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="i-checks pull-left">
                            <label>
                                    <input type="radio" <?=$block_vpnandtor===true?'checked':''?> value="true" name="tds.filters.blocked.vpntor"> Да </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-group-inner">
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <label class="login2 pull-left pull-left-pro">Блокировать шпионские сервисы (AdSpy, AdPlexity, Anstrex, SEO-боты)?</label>
        </div>
        <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
            <div class="bt-df-checkbox pull-left">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="i-checks pull-left">
                            <label>
                                    <input type="radio" <?=$block_spyservices===false?'checked':''?> value="false" name="tds.filters.blocked.spyservices"> Нет </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="i-checks pull-left">
                            <label>
                                    <input type="radio" <?=$block_spyservices===true?'checked':''?> value="true" name="tds.filters.blocked.spyservices"> Да </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-group-inner">
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <label class="login2 pull-left pull-left-pro">Блокировать IP датацентров (AWS, Google Cloud, Azure, DigitalOcean, Oracle, Vultr, Linode)?</label>
        </div>
        <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
            <div class="bt-df-checkbox pull-left">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="i-checks pull-left">
                            <label>
                                    <input type="radio" <?=$block_datacenter===false?'checked':''?> value="false" name="tds.filters.blocked.datacenter"> Нет </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="i-checks pull-left">
                            <label>
                                    <input type="radio" <?=$block_datacenter===true?'checked':''?> value="true" name="tds.filters.blocked.datacenter"> Да </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-group-inner">
    <div class="row">
        <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
            <label class="login2 pull-left pull-left-pro">Обновить базы IP датацентров с GitHub (lord-alfred/ipranges)</label>
        </div>
        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
            <a href="../bases/updatebases.php?password=<?=$log_password?>" class="btn btn-warning" target="_blank">Обновить базы IP</a>
            <?php
            $dc_file = __DIR__.'/../bases/datacenter.txt';
            if(file_exists($dc_file)){
                $dc_lines = count(file($dc_file, FILE_SKIP_EMPTY_LINES));
                $dc_date = date('Y-m-d H:i', filemtime($dc_file));
                echo '<span style="margin-left:15px;color:#888;">Последнее обновление: '.$dc_date.' ('.$dc_lines.' диапазонов)</span>';
            } else {
                echo '<span style="margin-left:15px;color:#c00;">Файл datacenter.txt не найден. Нажмите кнопку для загрузки.</span>';
            }
            ?>
        </div>
    </div>
</div>

<div class="form-group-inner">
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <label class="login2 pull-left pull-left-pro">Использовать фоллбэк VPN API (ProxyCheck.io / IPQualityScore) когда blackbox недоступен?</label>
        </div>
        <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
            <div class="bt-df-checkbox pull-left">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="i-checks pull-left">
                            <label>
                                    <input type="radio" <?=$vpn_fallback===false?'checked':''?> value="false" name="tds.filters.blocked.vpnfallback"> Нет </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="i-checks pull-left">
                            <label>
                                    <input type="radio" <?=$vpn_fallback===true?'checked':''?> value="true" name="tds.filters.blocked.vpnfallback"> Да </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-group-inner">
    <div class="row">
        <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
            <label class="login2 pull-left pull-left-pro">ProxyCheck.io API ключ (бесплатно 1000 запросов/день на proxycheck.io)</label>
        </div>
        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
            <div class="input-group custom-go-button">
                <input type="text" name="tds.filters.blocked.proxycheckkey" class="form-control" placeholder="Оставьте пустым, если не используете" value="<?=$proxycheck_key?>">
            </div>
        </div>
    </div>
</div>

<div class="form-group-inner">
    <div class="row">
        <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
            <label class="login2 pull-left pull-left-pro">IPQualityScore API ключ (бесплатно 5000 запросов/месяц на ipqualityscore.com)</label>
        </div>
        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
            <div class="input-group custom-go-button">
                <input type="text" name="tds.filters.blocked.ipqskey" class="form-control" placeholder="Оставьте пустым, если не используете" value="<?=$ipqs_key?>">
            </div>
        </div>
    </div>
</div>

<br>
<hr>
<h4>#6 Настройка дополнительных скриптов</h4>
<div class="form-group-inner">
<div class="row">
<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
<label class="login2 pull-left pull-left-pro">Что делать с кнопкой Назад?</label>
</div>
<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
<div class="bt-df-checkbox pull-left">

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="i-checks pull-left">
                <label>
                        <input type="radio" <?=$back_button_action==='off'?'checked':''?> value="off" name="scripts.back.action" onclick="(document.getElementById('b_9').style.display='none')"> Оставить по умолчанию </label>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="i-checks pull-left">
                <label>
                        <input type="radio" <?=$back_button_action==='disable'?'checked':''?> value="disable" name="scripts.back.action" onclick="(document.getElementById('b_9').style.display='none')"> Отключить (перестает нажиматься)</label>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="i-checks pull-left">
                <label>
                        <input type="radio" <?=$back_button_action==='replace'?'checked':''?> value="replace" name="scripts.back.action" onclick="(document.getElementById('b_9').style.display='block')"> Повесить на нее редирект на URL</label>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
<div id="b_9" style="display:<?=$back_button_action==='replace'?'block':'none'?>;">
<div class="form-group-inner">
<div class="row">
<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
<label class="login2 pull-left pull-left-pro">Куда направлять при нажатии Назад?</label>
</div>
<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
<div class="input-group custom-go-button">
    <input type="text" name="scripts.back.value" class="form-control" placeholder="http://ya.ru?pixel={px}&subid={subid}&prelanding={prelanding}" value="<?=$replace_back_address?>">
</div>
</div>
</div>
</div>
</div>
<div class="form-group-inner">
<div class="row">
<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
<label class="login2 pull-left pull-left-pro">Запретить выделять и сохранять текст по Ctrl+S, убирать контекстное меню?</label>
</div>
<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
<div class="bt-df-checkbox pull-left">

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="i-checks pull-left">
                <label>
                        <input type="radio" <?=$disable_text_copy===false?'checked':''?> value="false" name="scripts.disabletextcopy"> Нет </label>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="i-checks pull-left">
                <label>
                        <input type="radio" <?=$disable_text_copy===true?'checked':''?> value="true" name="scripts.disabletextcopy"> Да, запретить </label>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>

<div class="form-group-inner">
<div class="row">
<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
<label class="login2 pull-left pull-left-pro">Открывать ссылки на ленд в новом окне с подменой в старом окне проклы на URL указанный ниже?</label>
</div>
<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
<div class="bt-df-checkbox pull-left">

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="i-checks pull-left">
                <label>
                        <input type="radio" <?=$replace_prelanding===false?'checked':''?> value="false" name="scripts.prelandingreplace.use" onclick="(document.getElementById('b_10').style.display='none')"> Нет </label>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="i-checks pull-left">
                <label>
                        <input type="radio" <?=$replace_prelanding===true?'checked':''?> value="true" name="scripts.prelandingreplace.use" onclick="(document.getElementById('b_10').style.display='block')"> Да, открывать  </label>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
<div id="b_10" style="display:<?=$replace_prelanding===true?'block':'none'?>;">
<div class="form-group-inner">
<div class="row">
<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
<label class="login2 pull-left pull-left-pro">URL который откроется в старом окне:</label>
</div>
<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
<div class="input-group custom-go-button">
    <input type="text" name="scripts.prelandingreplace.url" class="form-control" placeholder="http://ya.ru?pixel={px}&subid={subid}&prelanding={prelanding}" value="<?=$replace_prelanding_address?>">
</div>
</div>
</div>
</div>
</div>


<div class="form-group-inner">
<div class="row">
<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
<label class="login2 pull-left pull-left-pro">Открывать страницу Спасибо ленда в новом окне с подменой в старом окне ленда на URL указанный ниже?</label>
</div>
<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
<div class="bt-df-checkbox pull-left">

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="i-checks pull-left">
                <label>
                        <input type="radio" <?=$replace_landing===false?'checked':''?> value="false" name="scripts.landingreplace.use" onclick="(document.getElementById('b_1010').style.display='none')"> Нет </label>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="i-checks pull-left">
                <label>
                        <input type="radio" <?=$replace_landing===true?'checked':''?> value="true" name="scripts.landingreplace.use" onclick="(document.getElementById('b_1010').style.display='block')"> Да, открывать  </label>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
<div id="b_1010" style="display:<?=$replace_landing===true?'block':'none'?>;">
<div class="form-group-inner">
<div class="row">
<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
<label class="login2 pull-left pull-left-pro">URL который откроется в старом окне:</label>
</div>
<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
<div class="input-group custom-go-button">
    <input type="text" name="scripts.landingreplace.url" class="form-control" placeholder="http://ya.ru?pixel={px}&subid={subid}&prelanding={prelanding}" value="<?=$replace_landing_address?>">
</div>
</div>
</div>
</div>
</div>

<div class="form-group-inner">
<div class="row">
<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
<label class="login2 pull-left pull-left-pro">К полю ввода телефона НА ЛЕНДИНГЕ будет добавлена маска указанная ниже</label>
</div>
<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
<div class="bt-df-checkbox pull-left">

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="i-checks pull-left">
                <label>
                        <input type="radio" <?=$black_land_use_phone_mask===false?'checked':''?> value="false" name="scripts.phonemask.use" onclick="(document.getElementById('b_11').style.display='none')"> Нет </label>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="i-checks pull-left">
                <label>
                        <input type="radio" <?=$black_land_use_phone_mask===true?'checked':''?> value="true" name="scripts.phonemask.use" onclick="(document.getElementById('b_11').style.display='block')"> Да, добавить маску </label>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>

<div id="b_11" style="display:<?=$black_land_use_phone_mask===true?'block':'none'?>;">
<div class="form-group-inner">
<div class="row">
<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
<label class="login2 pull-left pull-left-pro">Укажите маску:</label>
</div>
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
<div class="input-group custom-go-button">
<input type="text" name="scripts.phonemask.mask" class="form-control" placeholder="+421 999 999 999" value="<?=$black_land_phone_mask?>">
</div>
</div>
</div>
</div>
</div>
<div class="form-group-inner">
<div class="row">
<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
<label class="login2 pull-left pull-left-pro">Включить скрипт Comebacker?</label>
</div>
<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
<div class="bt-df-checkbox pull-left">

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="i-checks pull-left">
            <label>
                    <input type="radio" <?=$comebacker===false?'checked':''?> value="false" name="scripts.comebacker"> Нет </label>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="i-checks pull-left">
            <label>
                    <input type="radio" <?=$comebacker===true?'checked':''?> value="true" name="scripts.comebacker"> Да</label>
        </div>
    </div>
</div>
</div>
</div>
</div>
</div>
<div class="form-group-inner">
<div class="row">
<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
<label class="login2 pull-left pull-left-pro">Включить скрипт Callbacker?</label>
</div>
<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
<div class="bt-df-checkbox pull-left">

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="i-checks pull-left">
            <label>
                    <input type="radio" <?=$callbacker===false?'checked':''?> value="false" name="scripts.callbacker"> Нет </label>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="i-checks pull-left">
            <label>
                    <input type="radio" <?=$callbacker===true?'checked':''?> value="true" name="scripts.callbacker"> Да</label>
        </div>
    </div>
</div>
</div>
</div>
</div>
</div>
<div class="form-group-inner">
<div class="row">
<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
<label class="login2 pull-left pull-left-pro">Включить скрипт, показывающий всплывающие сообщения о том, что кто-то приобрёл товар?</label>
</div>
<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
<div class="bt-df-checkbox pull-left">

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="i-checks pull-left">
            <label>
                    <input type="radio" <?=$addedtocart===false?'checked':''?> value="false" name="scripts.addedtocart"> Нет </label>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="i-checks pull-left">
            <label>
                    <input type="radio" <?=$addedtocart===true?'checked':''?> value="true" name="scripts.addedtocart"> Да</label>
        </div>
    </div>
</div>
</div>
</div>
</div>
</div>
<div class="form-group-inner">
<div class="row">
<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
<label class="login2 pull-left pull-left-pro">Использовать отложенную загрузку (lazy loading) для картинок на прелендах/лендах?</label>
</div>
<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
<div class="bt-df-checkbox pull-left">

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="i-checks pull-left">
            <label>
                    <input type="radio" <?=$images_lazy_load===false?'checked':''?> value="false" name="scripts.imageslazyload"> Нет </label>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="i-checks pull-left">
            <label>
                    <input type="radio" <?=$images_lazy_load===true?'checked':''?> value="true" name="scripts.imageslazyload"> Да</label>
        </div>
    </div>
</div>
</div>
</div>
</div>
</div>
<br>
<hr>
<h4>#7 Настройка суб-меток</h4>
<p>Кло берёт из адресной строки те субметки, что слева и:<br>
1. Если у вас локальный ленд, то кло записывает значения меток в каждую форму на ленде в поля с именами, которые справа<br>
2. Если у вас ленд в ПП, то кло дописывает значения меток к ссылке ПП с именами, которые справа<br>
Таким образом мы передаём значения субметок в ПП, чтобы в стате ПП отображалась нужная нам инфа <br>
Ну и плюс это нужно для того, чтобы передавать subid для постбэка<br>
Есть 3 "зашитые" метки: <br>
- subid - уникальный идентификатор пользователя, создаётся при заходе пользователя на блэк, хранится в куки<br>
- prelanding - название папки преленда<br>
- landing - название папки ленда<br><br />
Пример: <br>
у вас в адресной строке было http://xxx.com?cn=MyCampaign<br>
вы написали в настройке: cn => utm_campaign <br />
в форме на ленде добавится <pre>&lt;input type="hidden" name="utm_campaign" value="MyCampaign"/&gt;</pre>
</p>
<div id="subs_container">
<?php  for ($i=0;$i<count($sub_ids);$i++){?>
<div class="form-group-inner subs">
<div class="row">
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
     <div class="input-group">
        <input type="text" class="form-control" placeholder="subid" value="<?=$sub_ids[$i]["name"]?>" name="subids[<?=$i?>][name]">
    </div>
</div>
<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
    <p>=></p>
</div>
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
    <div class="input-group custom-go-button">
        <input type="text" class="form-control" placeholder="sub_id" value="<?=$sub_ids[$i]["rewrite"]?>" name="subids[<?=$i?>][rewrite]">
    </div>
</div>
<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
    <a href="javascript:void(0)" class="remove-sub-item btn btn-sm btn-primary">Удалить</a>
</div>
</div>
</div>
<?php }?>
</div>
<a id="add-sub-item" class="btn btn-sm btn-primary" href="javascript:;">Добавить</a>

<br>
<hr>
<h4>#8 Настройка статистики</h4>
<div class="form-group-inner">
<div class="row">
<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
<label class="login2 pull-left pull-left-pro">Пароль от админ-панели: <br><small>добавлять как: /admin?password=xxxxx</small></label>
</div>
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
<div class="input-group custom-go-button">
<input type="password" name="statistics.password" class="form-control" placeholder="12345" value="<?=$log_password?>">
</div>
</div>
</div>
</div>
<div class="form-group-inner">
<div class="row">
<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
<label class="login2 pull-left pull-left-pro">Часовой пояс для отображения статы</label>
</div>
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
<div class="input-group custom-go-button">
<?=select_timezone('statistics.timezone',$stats_timezone) ?>
</div>
</div>
</div>
</div>
<br/>
<div class="form-group-inner">
<div class="row">
<div class="col-lg-5 col-md-12 col-sm-12 col-xs-12">
<label class="login2 pull-left pull-left-pro">Настройка отображения таблиц по субметкам в стате:</label>
<br/>
<br/>
<p>Слева название метки, которую кло возьмёт из адреса перехода.</p>
<p>Справа название НА АНГЛИЙСКОМ таблицы, в которой будут показаны все значения выбранной метки и их стата: клики, конверсии</p>
</div>
</div>

<div id="stats_subs_container">
<?php  for ($i=0;$i<count($stats_sub_names);$i++){?>
<div class="form-group-inner stats_subs">
<div class="row">
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
     <div class="input-group">
        <input type="text" class="form-control" placeholder="camp" value="<?=$stats_sub_names[$i]["name"]?>" name="statistics.subnames[<?=$i?>][name]">
    </div>
</div>
<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
    <p>=></p>
</div>
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
    <div class="input-group custom-go-button">
        <input type="text" class="form-control" placeholder="Campaigns" value="<?=$stats_sub_names[$i]["value"]?>" name="statistics.subnames[<?=$i?>][value]">
    </div>
</div>
<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
    <a href="javascript:void(0)" class="remove-stats-sub-item btn btn-sm btn-primary">Удалить</a>
</div>
</div>
</div>
<?php }?>
</div>
<a id="add-stats-sub-item" class="btn btn-sm btn-primary" href="javascript:;">Добавить</a>
</div>
<br>
<hr>
<h4>#9 Настройка постбэков</h4>
<div class="form-group-inner">
<div class="row">
<div class="col-lg-5 col-md-12 col-sm-12 col-xs-12">
<label class="login2 pull-left pull-left-pro">Здесь необходимо прописать статусы лидов, в том виде, как их вам отправляет в постбэке ПП:</label>
</div>
</div>
</div>
<div class="form-group-inner">
<div class="row">
<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
<label class="login2 pull-left pull-left-pro">Lead</label>
</div>
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
<div class="input-group custom-go-button">
<input type="text" name="postback.lead" class="form-control" placeholder="Lead" value="<?=$lead_status_name?>">
</div>
</div>
</div>
</div>

<div class="form-group-inner">
<div class="row">
<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
<label class="login2 pull-left pull-left-pro">Purchase</label>
</div>
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
<div class="input-group custom-go-button">
<input type="text" name="postback.purchase" class="form-control" placeholder="Purchase" value="<?=$purchase_status_name?>">
</div>
</div>
</div>
</div>

<div class="form-group-inner">
<div class="row">
<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
<label class="login2 pull-left pull-left-pro">Reject</label>
</div>
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
<div class="input-group custom-go-button">
<input type="text" name="postback.reject" class="form-control" placeholder="Reject" value="<?=$reject_status_name?>">
</div>
</div>
</div>
</div>

<div class="form-group-inner">
<div class="row">
<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
<label class="login2 pull-left pull-left-pro">Trash</label>
</div>
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
<div class="input-group custom-go-button">
<input type="text" name="postback.trash" class="form-control" placeholder="Trash" value="<?=$trash_status_name?>">
</div>
</div>
</div>
</div>
<div class="form-group-inner">
<div class="row">
<div class="col-lg-5 col-md-12 col-sm-12 col-xs-12">
<label class="login2 pull-left pull-left-pro">Настойка S2S-постбеков:</label>
<br/>
</div>
</div>

<div id="s2s_container">
<?php  for ($i=0;$i<count($s2s_postbacks);$i++){?>
<div class="form-group-inner s2s">
<div class="row">
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
    <label class="login2 pull-left pull-left-pro">Адрес:</label>
    <br/><br/>
<p>Внутри адреса постбэка можно использовать следующие макросы:
{subid}, {prelanding}, {landing}, {px}, {domain}, {status}</p>
</div>
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
     <div class="input-group">
        <input type="text" class="form-control" placeholder="https://s2s-postback.com" value="<?=$s2s_postbacks[$i]["url"]?>" name="postback.s2s[<?=$i?>][url]">
    </div>
</div>
<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
    <a href="javascript:void(0)" class="remove-s2s-item btn btn-sm btn-primary">Удалить</a>
</div>
</div>
<div class="row">
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
    <label class="login2 pull-left pull-left-pro">Метод отправки постбэка:</label>
</div>
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
     <div class="input-group">
        <select class="form-control" name="postback.s2s[<?=$i?>][method]">
            <option value="GET" <?=($s2s_postbacks[$i]["method"]==="GET"?' selected':'')?>>GET</option>
            <option value="POST"<?=($s2s_postbacks[$i]["method"]==="POST"?' selected':'')?>>POST</option>
        </select>
    </div>
</div>
</div>
<div class="row">
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
    <label class="login2 pull-left pull-left-pro">События, при которых будет отправлен постбэк:</label>
</div>
<div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
    <br/>
    <br/>
        <?php
            function s2s_postback_contains($conv_event,$s2s_postback){
                if (!array_key_exists("events",$s2s_postback)) return false;
                return in_array($conv_event,$s2s_postback["events"]);
            }
        ?>
         <label class="form-check-input">
        <input type="checkbox" class="form-check-input" name="postback.s2s[<?=$i?>][events][]" value="Lead"<?=(s2s_postback_contains("Lead",$s2s_postbacks[$i])?' checked':'')?>>Lead</label>&nbsp;&nbsp;
         <label class="form-check-input">
        <input type="checkbox" class="form-check-input" name="postback.s2s[<?=$i?>][events][]" value="Purchase"<?=(s2s_postback_contains("Purchase",$s2s_postbacks[$i])?' checked':'')?>>Purchase</label>&nbsp;&nbsp;
         <label class="form-check-input">
        <input type="checkbox" class="form-check-input" name="postback.s2s[<?=$i?>][events][]" value="Reject"<?=(s2s_postback_contains("Reject",$s2s_postbacks[$i])?' checked':'')?>>Reject</label>&nbsp;&nbsp;
         <label class="form-check-input">
        <input type="checkbox" class="form-check-input" name="postback.s2s[<?=$i?>][events][]" value="Trash"<?=(s2s_postback_contains("Trash",$s2s_postbacks[$i])?' checked':'')?>>Trash
</label>
</div>
</div>
<?php }?>
</div>
<a id="add-s2s-item" class="btn btn-sm btn-primary" href="javascript:;">Добавить</a>
</div>

<hr>
<div class="form-group-inner">
<div class="login-btn-inner">
<div class="row">
<div class="col-lg-3"></div>
<div class="col-lg-9">
<div class="login-horizental cancel-wp pull-left">
    <button class="btn btn-sm btn-primary" type="submit"><strong>Сохранить настройки</strong></button>
</div>
</div>
</div>
</div>
</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</form>

</div>
<!-- jquery
    ============================================ -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<!-- bootstrap JS
    ============================================ -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!--cloneData-->
<script src="js/cloneData.js"></script>
<script>
$('#add-domain-item').cloneData({
    mainContainerId: 'white_domainspecific',
    cloneContainer: 'white',
    removeButtonClass: 'remove-domain-item',
    maxLimit: 5,
    minLimit: 1,
    removeConfirm: false
});

$('#add-sub-item').cloneData({
    mainContainerId: 'subs_container',
    cloneContainer: 'subs',
    removeButtonClass: 'remove-sub-item',
    maxLimit: 10,
    minLimit: 1,
    removeConfirm: false
});

$('#add-stats-sub-item').cloneData({
    mainContainerId: 'stats_subs_container',
    cloneContainer: 'stats_subs',
    removeButtonClass: 'remove-stats-sub-item',
    maxLimit: 10,
    minLimit: 1,
    removeConfirm: false
});

$('#add-s2s-item').cloneData({
    mainContainerId: 's2s_container',
    cloneContainer: 's2s',
    removeButtonClass: 'remove-s2s-item',
    maxLimit: 5,
    minLimit: 1,
    removeConfirm: false
});
</script>
<!-- meanmenu JS
    ============================================ -->
<script src="js/jquery.meanmenu.js"></script>
<!-- sticky JS
    ============================================ -->
<script src="js/jquery.sticky.js"></script>
<!-- metisMenu JS
    ============================================ -->
<script src="js/metisMenu/metisMenu.min.js"></script>
<script src="js/metisMenu/metisMenu-active.js"></script>
<!-- plugins JS
    ============================================ -->
<script src="js/plugins.js"></script>
<!-- main JS
    ============================================ -->
<script src="js/main.js"></script>
</body>

<?php
function select_timezone($selectname,$selected = '') {
$zones = timezone_identifiers_list();
$select= "<select name='".$selectname."' class='form-control'>";
foreach($zones as $zone)
{
    $tz=new DateTimeZone($zone);
    $offset=$tz->getOffset(new DateTime)/3600;
    $select .='<option value="'.$zone.'"';
    $select .= ($zone == $selected ? ' selected' : '');
    $select .= '>'.$zone.' '.$offset.'</option>';
}  
$select.='</select>';
return $select;
}
?>

</html>
