<div class="settings-section">
    <h3 class="section-header">Page Behavior Scripts</h3>

    <div class="form-group-inner">
        <div class="row">
            <div class="col-lg-3">
                <label>Back button behavior:</label>
            </div>
            <div class="col-lg-9">
                <div class="form-check">
                    <input type="radio" class="form-check-input" <?=$back_button_action==='off'?'checked':''?> value="off" name="scripts.back.action" id="back_off" onclick="document.getElementById('back_settings').style.display='none'">
                    <label class="form-check-label" for="back_off">Default (browser back)</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" <?=$back_button_action==='disable'?'checked':''?> value="disable" name="scripts.back.action" id="back_disable" onclick="document.getElementById('back_settings').style.display='none'">
                    <label class="form-check-label" for="back_disable">Disable (prevent back navigation)</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" <?=$back_button_action==='replace'?'checked':''?> value="replace" name="scripts.back.action" id="back_replace" onclick="document.getElementById('back_settings').style.display='block'">
                    <label class="form-check-label" for="back_replace">Redirect to custom URL</label>
                </div>
            </div>
        </div>
    </div>

    <div id="back_settings" style="display:<?=$back_button_action==='replace'?'block':'none'?>;">
        <div class="form-group-inner">
            <div class="row">
                <div class="col-lg-3">
                    <label>Back button URL:</label>
                </div>
                <div class="col-lg-6">
                    <input type="text" class="form-control" placeholder="https://ya.ru?pixel={px}&subid={subid}" name="scripts.back.value" value="<?=$replace_back_address?>">
                    <small class="form-text text-muted">Supports macros: {px}, {subid}, {prelanding}, {landing}</small>
                </div>
            </div>
        </div>
    </div>

    <hr class="my-3">

    <div class="form-group-inner">
        <div class="row">
            <div class="col-lg-3">
                <label>Disable text copy:</label>
                <small class="form-text text-muted">Prevent text selection, Ctrl+S, right-click menu</small>
            </div>
            <div class="col-lg-9">
                <div class="form-check form-check-inline">
                    <input type="radio" class="form-check-input" <?=$disable_text_copy===true?'checked':''?> value="true" name="scripts.disabletextcopy" id="copy_off">
                    <label class="form-check-label" for="copy_off">Enabled</label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="radio" class="form-check-input" <?=$disable_text_copy===false?'checked':''?> value="false" name="scripts.disabletextcopy" id="copy_on">
                    <label class="form-check-label" for="copy_on">Disabled</label>
                </div>
            </div>
        </div>
    </div>

    <hr class="my-3">

    <div class="form-group-inner">
        <div class="row">
            <div class="col-lg-3">
                <label>Prelanding window replacement:</label>
                <small class="form-text text-muted">Open landing in new window, replace prelanding with URL</small>
            </div>
            <div class="col-lg-9">
                <div class="form-check form-check-inline">
                    <input type="radio" class="form-check-input" <?=$replace_prelanding===true?'checked':''?> value="true" name="scripts.prelandingreplace.use" id="preland_repl_on" onclick="document.getElementById('preland_repl_settings').style.display='block'">
                    <label class="form-check-label" for="preland_repl_on">Enabled</label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="radio" class="form-check-input" <?=$replace_prelanding===false?'checked':''?> value="false" name="scripts.prelandingreplace.use" id="preland_repl_off" onclick="document.getElementById('preland_repl_settings').style.display='none'">
                    <label class="form-check-label" for="preland_repl_off">Disabled</label>
                </div>
            </div>
        </div>
    </div>

    <div id="preland_repl_settings" style="display:<?=$replace_prelanding===true?'block':'none'?>;">
        <div class="form-group-inner">
            <div class="row">
                <div class="col-lg-3">
                    <label>Replacement URL:</label>
                </div>
                <div class="col-lg-6">
                    <input type="text" class="form-control" placeholder="https://ya.ru?pixel={px}&subid={subid}" name="scripts.prelandingreplace.url" value="<?=$replace_prelanding_address?>">
                    <small class="form-text text-muted">URL to show in old window after landing opens</small>
                </div>
            </div>
        </div>
    </div>

    <hr class="my-3">

    <div class="form-group-inner">
        <div class="row">
            <div class="col-lg-3">
                <label>Landing window replacement:</label>
                <small class="form-text text-muted">Open thank you in new window, replace landing with URL</small>
            </div>
            <div class="col-lg-9">
                <div class="form-check form-check-inline">
                    <input type="radio" class="form-check-input" <?=$replace_landing===true?'checked':''?> value="true" name="scripts.landingreplace.use" id="land_repl_on" onclick="document.getElementById('land_repl_settings').style.display='block'">
                    <label class="form-check-label" for="land_repl_on">Enabled</label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="radio" class="form-check-input" <?=$replace_landing===false?'checked':''?> value="false" name="scripts.landingreplace.use" id="land_repl_off" onclick="document.getElementById('land_repl_settings').style.display='none'">
                    <label class="form-check-label" for="land_repl_off">Disabled</label>
                </div>
            </div>
        </div>
    </div>

    <div id="land_repl_settings" style="display:<?=$replace_landing===true?'block':'none'?>;">
        <div class="form-group-inner">
            <div class="row">
                <div class="col-lg-3">
                    <label>Replacement URL:</label>
                </div>
                <div class="col-lg-6">
                    <input type="text" class="form-control" placeholder="https://ya.ru?pixel={px}&subid={subid}" name="scripts.landingreplace.url" value="<?=$replace_landing_address?>">
                    <small class="form-text text-muted">URL to show in old window after thank you opens</small>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="settings-section mt-4">
    <h3 class="section-header">Form & Input Features</h3>

    <div class="form-group-inner">
        <div class="row">
            <div class="col-lg-3">
                <label>Phone input mask:</label>
            </div>
            <div class="col-lg-9">
                <div class="form-check form-check-inline">
                    <input type="radio" class="form-check-input" <?=$black_land_use_phone_mask===true?'checked':''?> value="true" name="scripts.phonemask.use" id="mask_on" onclick="document.getElementById('mask_settings').style.display='block'">
                    <label class="form-check-label" for="mask_on">Enabled</label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="radio" class="form-check-input" <?=$black_land_use_phone_mask===false?'checked':''?> value="false" name="scripts.phonemask.use" id="mask_off" onclick="document.getElementById('mask_settings').style.display='none'">
                    <label class="form-check-label" for="mask_off">Disabled</label>
                </div>
            </div>
        </div>
    </div>

    <div id="mask_settings" style="display:<?=$black_land_use_phone_mask===true?'block':'none'?>;">
        <div class="form-group-inner">
            <div class="row">
                <div class="col-lg-3">
                    <label>Phone mask pattern:</label>
                </div>
                <div class="col-lg-4">
                    <input type="text" class="form-control" placeholder="+7(999)999-99-99" name="scripts.phonemask.mask" value="<?=$black_land_phone_mask?>">
                    <small class="form-text text-muted">Use 9 for digits, other chars as-is</small>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="settings-section mt-4">
    <h3 class="section-header">Engagement Scripts</h3>

    <div class="form-group-inner">
        <div class="row">
            <div class="col-lg-3">
                <label>Comebacker:</label>
                <small class="form-text text-muted">Exit-intent popup to retain visitors</small>
            </div>
            <div class="col-lg-9">
                <div class="form-check form-check-inline">
                    <input type="radio" class="form-check-input" <?=$comebacker===true?'checked':''?> value="true" name="scripts.comebacker" id="comebacker_on">
                    <label class="form-check-label" for="comebacker_on">Enabled</label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="radio" class="form-check-input" <?=$comebacker===false?'checked':''?> value="false" name="scripts.comebacker" id="comebacker_off">
                    <label class="form-check-label" for="comebacker_off">Disabled</label>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group-inner">
        <div class="row">
            <div class="col-lg-3">
                <label>Callbacker:</label>
                <small class="form-text text-muted">Callback request widget</small>
            </div>
            <div class="col-lg-9">
                <div class="form-check form-check-inline">
                    <input type="radio" class="form-check-input" <?=$callbacker===true?'checked':''?> value="true" name="scripts.callbacker" id="callbacker_on">
                    <label class="form-check-label" for="callbacker_on">Enabled</label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="radio" class="form-check-input" <?=$callbacker===false?'checked':''?> value="false" name="scripts.callbacker" id="callbacker_off">
                    <label class="form-check-label" for="callbacker_off">Disabled</label>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group-inner">
        <div class="row">
            <div class="col-lg-3">
                <label>Social proof notifications:</label>
                <small class="form-text text-muted">Show "Someone just purchased" popups</small>
            </div>
            <div class="col-lg-9">
                <div class="form-check form-check-inline">
                    <input type="radio" class="form-check-input" <?=$addedtocart===true?'checked':''?> value="true" name="scripts.addedtocart" id="social_on">
                    <label class="form-check-label" for="social_on">Enabled</label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="radio" class="form-check-input" <?=$addedtocart===false?'checked':''?> value="false" name="scripts.addedtocart" id="social_off">
                    <label class="form-check-label" for="social_off">Disabled</label>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="settings-section mt-4">
    <h3 class="section-header">Performance Optimization</h3>

    <div class="form-group-inner">
        <div class="row">
            <div class="col-lg-3">
                <label>Lazy load images:</label>
                <small class="form-text text-muted">Defer offscreen image loading for faster page load</small>
            </div>
            <div class="col-lg-9">
                <div class="form-check form-check-inline">
                    <input type="radio" class="form-check-input" <?=$images_lazy_load===true?'checked':''?> value="true" name="scripts.imageslazyload" id="lazy_on">
                    <label class="form-check-label" for="lazy_on">Enabled</label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="radio" class="form-check-input" <?=$images_lazy_load===false?'checked':''?> value="false" name="scripts.imageslazyload" id="lazy_off">
                    <label class="form-check-label" for="lazy_off">Disabled</label>
                </div>
            </div>
        </div>
    </div>
</div>
