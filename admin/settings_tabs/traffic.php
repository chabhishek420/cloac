<div class="settings-section">
    <h3 class="section-header">White Page Configuration</h3>
    <p class="text-muted">Configure what blocked traffic (bots, moderators) sees</p>

    <div class="form-group-inner">
        <div class="row">
            <div class="col-lg-3">
                <label class="login2">White Page Method:</label>
            </div>
            <div class="col-lg-9">
                <div class="form-check">
                    <input type="radio" class="form-check-input" <?=$white_action==='folder'?'checked':''?> value="folder" name="white.action" id="white_folder" onclick="showWhiteOption('folder')">
                    <label class="form-check-label" for="white_folder">Local folder</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" <?=$white_action==='redirect'?'checked':''?> value="redirect" name="white.action" id="white_redirect" onclick="showWhiteOption('redirect')">
                    <label class="form-check-label" for="white_redirect">Redirect</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" <?=$white_action==='curl'?'checked':''?> value="curl" name="white.action" id="white_curl" onclick="showWhiteOption('curl')">
                    <label class="form-check-label" for="white_curl">Load external site (CURL)</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" <?=$white_action==='error'?'checked':''?> value="error" name="white.action" id="white_error" onclick="showWhiteOption('error')">
                    <label class="form-check-label" for="white_error">Return HTTP error code</label>
                </div>
            </div>
        </div>
    </div>

    <div id="white_folder_settings" style="display:<?=$white_action==='folder'?'block':'none'?>;">
        <div class="form-group-inner">
            <div class="row">
                <div class="col-lg-3">
                    <label>Folder name(s):</label>
                </div>
                <div class="col-lg-6">
                    <input type="text" class="form-control" placeholder="white" name="white.folder.names" value="<?=implode(',',$white_folder_names)?>">
                    <small class="form-text text-muted">Comma-separated for multiple folders</small>
                </div>
            </div>
        </div>
    </div>

    <div id="white_redirect_settings" style="display:<?=$white_action==='redirect'?'block':'none'?>;">
        <div class="form-group-inner">
            <div class="row">
                <div class="col-lg-3">
                    <label>Redirect URL(s):</label>
                </div>
                <div class="col-lg-6">
                    <input type="text" class="form-control" placeholder="https://ya.ru" name="white.redirect.urls" value="<?=implode(',',$white_redirect_urls)?>">
                    <small class="form-text text-muted">Comma-separated for multiple URLs</small>
                </div>
            </div>
        </div>
        <div class="form-group-inner">
            <div class="row">
                <div class="col-lg-3">
                    <label>Redirect type:</label>
                </div>
                <div class="col-lg-9">
                    <div class="form-check form-check-inline">
                        <input type="radio" class="form-check-input" <?=$white_redirect_type==='301'?'checked':''?> value="301" name="white.redirect.type" id="redir_301">
                        <label class="form-check-label" for="redir_301">301 (Permanent)</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" class="form-check-input" <?=$white_redirect_type==='302'?'checked':''?> value="302" name="white.redirect.type" id="redir_302">
                        <label class="form-check-label" for="redir_302">302 (Temporary)</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" class="form-check-input" <?=$white_redirect_type==='303'?'checked':''?> value="303" name="white.redirect.type" id="redir_303">
                        <label class="form-check-label" for="redir_303">303</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" class="form-check-input" <?=$white_redirect_type==='307'?'checked':''?> value="307" name="white.redirect.type" id="redir_307">
                        <label class="form-check-label" for="redir_307">307</label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="white_curl_settings" style="display:<?=$white_action==='curl'?'block':'none'?>;">
        <div class="form-group-inner">
            <div class="row">
                <div class="col-lg-3">
                    <label>External URL(s):</label>
                </div>
                <div class="col-lg-6">
                    <input type="text" class="form-control" placeholder="https://ya.ru" name="white.curl.urls" value="<?=implode(',',$white_curl_urls)?>">
                    <small class="form-text text-muted">Comma-separated for multiple URLs</small>
                </div>
            </div>
        </div>
    </div>

    <div id="white_error_settings" style="display:<?=$white_action==='error'?'block':'none'?>;">
        <div class="form-group-inner">
            <div class="row">
                <div class="col-lg-3">
                    <label>HTTP error code(s):</label>
                </div>
                <div class="col-lg-3">
                    <input type="text" class="form-control" placeholder="404" name="white.error.codes" value="<?=implode(',',$white_error_codes)?>">
                    <small class="form-text text-muted">e.g., 404, 403, 500</small>
                </div>
            </div>
        </div>
    </div>

    <hr class="my-4">

    <div class="form-group-inner">
        <div class="row">
            <div class="col-lg-3">
                <label>Domain-specific white pages:</label>
            </div>
            <div class="col-lg-9">
                <div class="form-check">
                    <input type="radio" class="form-check-input" <?=$white_use_domain_specific===false?'checked':''?> value="false" name="white.domainfilter.use" id="domain_off" onclick="document.getElementById('domain_specific_settings').style.display='none'">
                    <label class="form-check-label" for="domain_off">No</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" <?=$white_use_domain_specific===true?'checked':''?> value="true" name="white.domainfilter.use" id="domain_on" onclick="document.getElementById('domain_specific_settings').style.display='block'">
                    <label class="form-check-label" for="domain_on">Yes, use different white pages per domain</label>
                </div>
            </div>
        </div>
    </div>

    <div id="domain_specific_settings" style="display:<?=$white_use_domain_specific===true?'block':'none'?>;">
        <div id="white_domainspecific">
            <?php for($j=0;$j<count($white_domain_specific);$j++){ ?>
            <div class="form-group-inner white-domain-row">
                <div class="row">
                    <div class="col-lg-3">
                        <input type="text" class="form-control" placeholder="domain.com" value="<?=$white_domain_specific[$j]["name"]?>" name="white.domainfilter.domains[<?=$j?>][name]">
                    </div>
                    <div class="col-lg-1 text-center">=></div>
                    <div class="col-lg-3">
                        <input type="text" class="form-control" placeholder="site:white" value="<?=$white_domain_specific[$j]["action"]?>" name="white.domainfilter.domains[<?=$j?>][action]">
                    </div>
                    <div class="col-lg-2">
                        <button type="button" class="btn btn-sm btn-danger remove-domain-item">Remove</button>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
        <button type="button" id="add-domain-item" class="btn btn-sm btn-primary">Add Domain</button>
    </div>

    <hr class="my-4">

    <div class="form-group-inner">
        <div class="row">
            <div class="col-lg-3">
                <label>JavaScript checks:</label>
                <small class="form-text text-muted">Show white page first, then run JS checks before showing black page</small>
            </div>
            <div class="col-lg-9">
                <div class="form-check">
                    <input type="radio" class="form-check-input" <?=$use_js_checks===false?'checked':''?> value="false" name="white.jschecks.enabled" id="js_off" onclick="document.getElementById('js_settings').style.display='none'">
                    <label class="form-check-label" for="js_off">Disabled</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" <?=$use_js_checks===true?'checked':''?> value="true" name="white.jschecks.enabled" id="js_on" onclick="document.getElementById('js_settings').style.display='block'">
                    <label class="form-check-label" for="js_on">Enabled</label>
                </div>
            </div>
        </div>
    </div>

    <div id="js_settings" style="display:<?=$use_js_checks===true?'block':'none'?>;">
        <div class="form-group-inner">
            <div class="row">
                <div class="col-lg-3">
                    <label>Test timeout (ms):</label>
                </div>
                <div class="col-lg-3">
                    <input type="text" class="form-control" placeholder="10000" name="white.jschecks.timeout" value="<?=$js_timeout?>">
                </div>
            </div>
        </div>

        <div class="form-group-inner">
            <div class="row">
                <div class="col-lg-3">
                    <label>Check for:</label>
                </div>
                <div class="col-lg-9">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="white.jschecks.events[]" value="mousemove" <?=in_array('mousemove',$js_checks)?'checked':''?> id="js_mouse">
                        <label class="form-check-label" for="js_mouse">Mouse movement</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="white.jschecks.events[]" value="keydown" <?=in_array('keydown',$js_checks)?'checked':''?> id="js_key">
                        <label class="form-check-label" for="js_key">Keyboard input</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="white.jschecks.events[]" value="scroll" <?=in_array('scroll',$js_checks)?'checked':''?> id="js_scroll">
                        <label class="form-check-label" for="js_scroll">Scrolling</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="white.jschecks.events[]" value="devicemotion" <?=in_array('devicemotion',$js_checks)?'checked':''?> id="js_motion">
                        <label class="form-check-label" for="js_motion">Device motion (Android)</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="white.jschecks.events[]" value="deviceorientation" <?=in_array('deviceorientation',$js_checks)?'checked':''?> id="js_orient">
                        <label class="form-check-label" for="js_orient">Device orientation (Android)</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="white.jschecks.events[]" value="audiocontext" <?=in_array('audiocontext',$js_checks)?'checked':''?> id="js_audio">
                        <label class="form-check-label" for="js_audio">Audio context</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="white.jschecks.events[]" value="timezone" <?=in_array('timezone',$js_checks)?'checked':''?> id="js_tz" onchange="document.getElementById('tz_settings').style.display=this.checked?'block':'none'">
                        <label class="form-check-label" for="js_tz">Timezone</label>
                    </div>
                </div>
            </div>
        </div>

        <div id="tz_settings" style="display:<?=in_array('timezone',$js_checks)?'block':'none'?>;">
            <div class="form-group-inner">
                <div class="row">
                    <div class="col-lg-3">
                        <label>Min timezone:</label>
                    </div>
                    <div class="col-lg-2">
                        <input type="text" class="form-control" placeholder="-3" name="white.jschecks.tzstart" value="<?=$js_tzstart?>">
                    </div>
                    <div class="col-lg-2">
                        <label>Max timezone:</label>
                    </div>
                    <div class="col-lg-2">
                        <input type="text" class="form-control" placeholder="3" name="white.jschecks.tzend" value="<?=$js_tzend?>">
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group-inner">
            <div class="row">
                <div class="col-lg-3">
                    <label>Obfuscate JS code:</label>
                </div>
                <div class="col-lg-9">
                    <div class="form-check form-check-inline">
                        <input type="radio" class="form-check-input" <?=$js_obfuscate===true?'checked':''?> value="true" name="white.jschecks.obfuscate" id="obf_on">
                        <label class="form-check-label" for="obf_on">Yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" class="form-check-input" <?=$js_obfuscate===false?'checked':''?> value="false" name="white.jschecks.obfuscate" id="obf_off">
                        <label class="form-check-label" for="obf_off">No</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function showWhiteOption(option) {
    document.getElementById('white_folder_settings').style.display = option === 'folder' ? 'block' : 'none';
    document.getElementById('white_redirect_settings').style.display = option === 'redirect' ? 'block' : 'none';
    document.getElementById('white_curl_settings').style.display = option === 'curl' ? 'block' : 'none';
    document.getElementById('white_error_settings').style.display = option === 'error' ? 'block' : 'none';
}
</script>

<div class="settings-section mt-4">
    <h3 class="section-header">Black Page Configuration</h3>
    <p class="text-muted">Configure what legitimate traffic (real users) sees</p>

    <div class="form-group-inner">
        <div class="row">
            <div class="col-lg-3">
                <label>Prelanding pages:</label>
            </div>
            <div class="col-lg-9">
                <div class="form-check">
                    <input type="radio" class="form-check-input" <?=$black_preland_action==='none'?'checked':''?> value="none" name="black.prelanding.action" id="preland_none" onclick="document.getElementById('preland_settings').style.display='none'">
                    <label class="form-check-label" for="preland_none">No prelanding (direct to landing)</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" <?=$black_preland_action==='folder'?'checked':''?> value="folder" name="black.prelanding.action" id="preland_folder" onclick="document.getElementById('preland_settings').style.display='block'">
                    <label class="form-check-label" for="preland_folder">Use local prelanding folders</label>
                </div>
            </div>
        </div>
    </div>

    <div id="preland_settings" style="display:<?=$black_preland_action==='folder'?'block':'none'?>;">
        <div class="form-group-inner">
            <div class="row">
                <div class="col-lg-3">
                    <label>Prelanding folder(s):</label>
                </div>
                <div class="col-lg-6">
                    <input type="text" class="form-control" placeholder="p1,p2,p3" name="black.prelanding.folders" value="<?=implode(',',$black_preland_folder_names)?>">
                    <small class="form-text text-muted">Comma-separated for A/B testing</small>
                </div>
            </div>
        </div>
    </div>

    <hr class="my-4">

    <div class="form-group-inner">
        <div class="row">
            <div class="col-lg-3">
                <label>Landing pages:</label>
            </div>
            <div class="col-lg-9">
                <div class="form-check">
                    <input type="radio" class="form-check-input" <?=$black_land_action==='folder'?'checked':''?> value="folder" name="black.landing.action" id="land_folder" onclick="showLandingOption('folder')">
                    <label class="form-check-label" for="land_folder">Local landing folders</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" <?=$black_land_action==='redirect'?'checked':''?> value="redirect" name="black.landing.action" id="land_redirect" onclick="showLandingOption('redirect')">
                    <label class="form-check-label" for="land_redirect">Redirect to external URL</label>
                </div>
            </div>
        </div>
    </div>

    <div id="landing_folder_settings" style="display:<?=$black_land_action==='folder'?'block':'none'?>;">
        <div class="form-group-inner">
            <div class="row">
                <div class="col-lg-3">
                    <label>Landing folder(s):</label>
                </div>
                <div class="col-lg-6">
                    <input type="text" class="form-control" placeholder="l1,l2,l3" name="black.landing.folder.names" value="<?=implode(',',$black_land_folder_names)?>">
                    <small class="form-text text-muted">Comma-separated for A/B testing</small>
                </div>
            </div>
        </div>

        <div class="form-group-inner">
            <div class="row">
                <div class="col-lg-3">
                    <label>Thank you page:</label>
                </div>
                <div class="col-lg-9">
                    <div class="form-check">
                        <input type="radio" class="form-check-input" <?=$black_land_use_custom_thankyou_page===true?'checked':''?> value="true" name="black.landing.folder.customthankyoupage.use" id="ty_custom" onclick="showThankyouOption('custom')">
                        <label class="form-check-label" for="ty_custom">Custom (cloaker-hosted)</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" <?=$black_land_use_custom_thankyou_page===false?'checked':''?> value="false" name="black.landing.folder.customthankyoupage.use" id="ty_external" onclick="showThankyouOption('external')">
                        <label class="form-check-label" for="ty_external">External (affiliate network)</label>
                    </div>
                </div>
            </div>
        </div>

        <div id="thankyou_custom_settings" style="display:<?=$black_land_use_custom_thankyou_page===true?'block':'none'?>;">
            <div class="form-group-inner">
                <div class="row">
                    <div class="col-lg-3">
                        <label>Thank you page language:</label>
                    </div>
                    <div class="col-lg-2">
                        <input type="text" class="form-control" placeholder="EN" name="black.landing.folder.customthankyoupage.language" value="<?=$black_land_thankyou_page_language?>">
                    </div>
                </div>
            </div>

            <div class="form-group-inner">
                <div class="row">
                    <div class="col-lg-3">
                        <label>Conversion script path:</label>
                    </div>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" placeholder="order.php" name="black.landing.folder.conversions.script" value="<?=$black_land_conversion_script?>">
                        <small class="form-text text-muted">Path from landing root to form handler</small>
                    </div>
                </div>
            </div>

            <div class="form-group-inner">
                <div class="row">
                    <div class="col-lg-3">
                        <label>Upsell on thank you page:</label>
                    </div>
                    <div class="col-lg-9">
                        <div class="form-check form-check-inline">
                            <input type="radio" class="form-check-input" <?=$thankyou_upsell===true?'checked':''?> value="true" name="black.landing.folder.customthankyoupage.upsell.use" id="upsell_on" onclick="document.getElementById('upsell_settings').style.display='block'">
                            <label class="form-check-label" for="upsell_on">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" class="form-check-input" <?=$thankyou_upsell===false?'checked':''?> value="false" name="black.landing.folder.customthankyoupage.upsell.use" id="upsell_off" onclick="document.getElementById('upsell_settings').style.display='none'">
                            <label class="form-check-label" for="upsell_off">No</label>
                        </div>
                    </div>
                </div>
            </div>

            <div id="upsell_settings" style="display:<?=$thankyou_upsell===true?'block':'none'?>;">
                <div class="form-group-inner">
                    <div class="row">
                        <div class="col-lg-3"><label>Upsell header:</label></div>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" name="black.landing.folder.customthankyoupage.upsell.header" value="<?=$thankyou_upsell_header?>">
                        </div>
                    </div>
                </div>
                <div class="form-group-inner">
                    <div class="row">
                        <div class="col-lg-3"><label>Upsell text:</label></div>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" name="black.landing.folder.customthankyoupage.upsell.text" value="<?=$thankyou_upsell_text?>">
                        </div>
                    </div>
                </div>
                <div class="form-group-inner">
                    <div class="row">
                        <div class="col-lg-3"><label>Upsell URL:</label></div>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" placeholder="https://..." name="black.landing.folder.customthankyoupage.upsell.url" value="<?=$thankyou_upsell_url?>">
                        </div>
                    </div>
                </div>
                <div class="form-group-inner">
                    <div class="row">
                        <div class="col-lg-3"><label>Image folder:</label></div>
                        <div class="col-lg-3">
                            <input type="text" class="form-control" placeholder="img" name="black.landing.folder.customthankyoupage.upsell.imgdir" value="<?=$thankyou_upsell_imgdir?>">
                            <small class="form-text text-muted">In thankyou/upsell/</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="thankyou_external_settings" style="display:<?=$black_land_use_custom_thankyou_page===false?'block':'none'?>;">
            <div class="form-group-inner">
                <div class="row">
                    <div class="col-lg-3">
                        <label>Log conversions on button click:</label>
                    </div>
                    <div class="col-lg-9">
                        <div class="form-check form-check-inline">
                            <input type="radio" class="form-check-input" <?=$black_land_log_conversions_on_button_click===true?'checked':''?> value="true" name="black.landing.folder.conversions.logonbuttonclick" id="btnlog_on">
                            <label class="form-check-label" for="btnlog_on">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" class="form-check-input" <?=$black_land_log_conversions_on_button_click===false?'checked':''?> value="false" name="black.landing.folder.conversions.logonbuttonclick" id="btnlog_off">
                            <label class="form-check-label" for="btnlog_off">No (log on thank you page)</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="landing_redirect_settings" style="display:<?=$black_land_action==='redirect'?'block':'none'?>;">
        <div class="form-group-inner">
            <div class="row">
                <div class="col-lg-3">
                    <label>Redirect URL(s):</label>
                </div>
                <div class="col-lg-6">
                    <input type="text" class="form-control" placeholder="https://ya.ru,https://google.com" name="black.landing.redirect.urls" value="<?=implode(',',$black_land_redirect_urls)?>">
                    <small class="form-text text-muted">Comma-separated for multiple URLs</small>
                </div>
            </div>
        </div>
        <div class="form-group-inner">
            <div class="row">
                <div class="col-lg-3">
                    <label>Redirect type:</label>
                </div>
                <div class="col-lg-9">
                    <div class="form-check form-check-inline">
                        <input type="radio" class="form-check-input" <?=$black_land_redirect_type==='301'?'checked':''?> value="301" name="black.landing.redirect.type" id="land_redir_301">
                        <label class="form-check-label" for="land_redir_301">301</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" class="form-check-input" <?=$black_land_redirect_type==='302'?'checked':''?> value="302" name="black.landing.redirect.type" id="land_redir_302">
                        <label class="form-check-label" for="land_redir_302">302</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" class="form-check-input" <?=$black_land_redirect_type==='303'?'checked':''?> value="303" name="black.landing.redirect.type" id="land_redir_303">
                        <label class="form-check-label" for="land_redir_303">303</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" class="form-check-input" <?=$black_land_redirect_type==='307'?'checked':''?> value="307" name="black.landing.redirect.type" id="land_redir_307">
                        <label class="form-check-label" for="land_redir_307">307</label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr class="my-4">

    <div class="form-group-inner">
        <div class="row">
            <div class="col-lg-3">
                <label>JS integration mode:</label>
                <small class="form-text text-muted">For website builders (Wix, Shopify, etc.)</small>
            </div>
            <div class="col-lg-9">
                <div class="form-check">
                    <input type="radio" class="form-check-input" <?=$black_jsconnect_action==='redirect'?'checked':''?> value="redirect" name="black.jsconnect" id="js_redirect">
                    <label class="form-check-label" for="js_redirect">Redirect</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" <?=$black_jsconnect_action==='replace'?'checked':''?> value="replace" name="black.jsconnect" id="js_replace">
                    <label class="form-check-label" for="js_replace">Replace content</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" <?=$black_jsconnect_action==='iframe'?'checked':''?> value="iframe" name="black.jsconnect" id="js_iframe">
                    <label class="form-check-label" for="js_iframe">IFrame</label>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function showLandingOption(option) {
    document.getElementById('landing_folder_settings').style.display = option === 'folder' ? 'block' : 'none';
    document.getElementById('landing_redirect_settings').style.display = option === 'redirect' ? 'block' : 'none';
}

function showThankyouOption(option) {
    document.getElementById('thankyou_custom_settings').style.display = option === 'custom' ? 'block' : 'none';
    document.getElementById('thankyou_external_settings').style.display = option === 'external' ? 'block' : 'none';
}
</script>
