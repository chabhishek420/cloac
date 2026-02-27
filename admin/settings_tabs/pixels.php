<div class="settings-section">
    <h3 class="section-header">Analytics & Tag Managers</h3>

    <div class="form-group-inner">
        <div class="row">
            <div class="col-lg-3">
                <label>Google Tag Manager ID:</label>
            </div>
            <div class="col-lg-4">
                <input type="text" class="form-control" placeholder="GTM-XXXXXXX" name="pixels.gtm.id" value="<?=$gtm_id?>">
            </div>
        </div>
    </div>

    <div class="form-group-inner">
        <div class="row">
            <div class="col-lg-3">
                <label>Yandex Metrika ID:</label>
            </div>
            <div class="col-lg-4">
                <input type="text" class="form-control" placeholder="12345678" name="pixels.ya.id" value="<?=$ya_id?>">
            </div>
        </div>
    </div>
</div>

<div class="settings-section mt-4">
    <h3 class="section-header">Facebook Pixel</h3>

    <div class="form-group-inner">
        <div class="row">
            <div class="col-lg-3">
                <label>Pixel ID parameter name:</label>
            </div>
            <div class="col-lg-3">
                <input type="text" class="form-control" placeholder="px" name="pixels.fb.subname" value="<?=$fbpixel_subname?>">
                <small class="form-text text-muted">URL parameter containing pixel ID</small>
            </div>
        </div>
    </div>

    <div class="form-group-inner">
        <div class="row">
            <div class="col-lg-3">
                <label>PageView event:</label>
            </div>
            <div class="col-lg-9">
                <div class="form-check form-check-inline">
                    <input type="radio" class="form-check-input" <?=$fb_use_pageview===true?'checked':''?> value="true" name="pixels.fb.pageview" id="fb_pv_on">
                    <label class="form-check-label" for="fb_pv_on">Enabled</label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="radio" class="form-check-input" <?=$fb_use_pageview===false?'checked':''?> value="false" name="pixels.fb.pageview" id="fb_pv_off">
                    <label class="form-check-label" for="fb_pv_off">Disabled</label>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group-inner">
        <div class="row">
            <div class="col-lg-3">
                <label>ViewContent event:</label>
            </div>
            <div class="col-lg-9">
                <div class="form-check form-check-inline">
                    <input type="radio" class="form-check-input" <?=$fb_use_viewcontent===true?'checked':''?> value="true" name="pixels.fb.viewcontent.use" id="fb_vc_on" onclick="document.getElementById('fb_vc_settings').style.display='block'">
                    <label class="form-check-label" for="fb_vc_on">Enabled</label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="radio" class="form-check-input" <?=$fb_use_viewcontent===false?'checked':''?> value="false" name="pixels.fb.viewcontent.use" id="fb_vc_off" onclick="document.getElementById('fb_vc_settings').style.display='none'">
                    <label class="form-check-label" for="fb_vc_off">Disabled</label>
                </div>
            </div>
        </div>
    </div>

    <div id="fb_vc_settings" style="display:<?=$fb_use_viewcontent===true?'block':'none'?>;">
        <div class="form-group-inner">
            <div class="row">
                <div class="col-lg-3">
                    <label>Time delay (seconds):</label>
                </div>
                <div class="col-lg-2">
                    <input type="text" class="form-control" placeholder="30" name="pixels.fb.viewcontent.time" value="<?=$fb_view_content_time?>">
                    <small class="form-text text-muted">0 = disabled</small>
                </div>
                <div class="col-lg-2">
                    <label>Scroll percent:</label>
                </div>
                <div class="col-lg-2">
                    <input type="text" class="form-control" placeholder="75" name="pixels.fb.viewcontent.percent" value="<?=$fb_view_content_percent?>">
                    <small class="form-text text-muted">0 = disabled</small>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group-inner">
        <div class="row">
            <div class="col-lg-3">
                <label>Conversion event name:</label>
            </div>
            <div class="col-lg-3">
                <input type="text" class="form-control" placeholder="Lead" name="pixels.fb.conversion.event" value="<?=$fb_thankyou_event?>">
                <small class="form-text text-muted">e.g., Lead, Purchase</small>
            </div>
        </div>
    </div>

    <div class="form-group-inner">
        <div class="row">
            <div class="col-lg-3">
                <label>Fire conversion from:</label>
            </div>
            <div class="col-lg-9">
                <div class="form-check">
                    <input type="radio" class="form-check-input" <?=$fb_add_button_pixel===false?'checked':''?> value="false" name="pixels.fb.conversion.fireonbutton" id="fb_conv_ty">
                    <label class="form-check-label" for="fb_conv_ty">Thank you page</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" <?=$fb_add_button_pixel===true?'checked':''?> value="true" name="pixels.fb.conversion.fireonbutton" id="fb_conv_btn">
                    <label class="form-check-label" for="fb_conv_btn">Landing page button</label>
                </div>
            </div>
        </div>
    </div>

    <hr class="my-3">
    <h5>Facebook Conversions API (Server-Side)</h5>

    <div class="form-group-inner">
        <div class="row">
            <div class="col-lg-3">
                <label>Enable CAPI:</label>
            </div>
            <div class="col-lg-9">
                <div class="form-check form-check-inline">
                    <input type="radio" class="form-check-input" <?=$fb_capi_enabled===true?'checked':''?> value="true" name="pixels.fb.capi.enabled" id="capi_on" onclick="document.getElementById('capi_settings').style.display='block'">
                    <label class="form-check-label" for="capi_on">Enabled</label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="radio" class="form-check-input" <?=$fb_capi_enabled===false?'checked':''?> value="false" name="pixels.fb.capi.enabled" id="capi_off" onclick="document.getElementById('capi_settings').style.display='none'">
                    <label class="form-check-label" for="capi_off">Disabled</label>
                </div>
            </div>
        </div>
    </div>

    <div id="capi_settings" style="display:<?=$fb_capi_enabled===true?'block':'none'?>;">
        <div class="form-group-inner">
            <div class="row">
                <div class="col-lg-3">
                    <label>Access Token:</label>
                    <small class="form-text text-muted">From Events Manager → Settings → Conversions API</small>
                </div>
                <div class="col-lg-6">
                    <input type="text" class="form-control" placeholder="EAAxxxxxxxxxxxx" name="pixels.fb.capi.accesstoken" value="<?=$fb_capi_token?>">
                </div>
            </div>
        </div>

        <div class="form-group-inner">
            <div class="row">
                <div class="col-lg-3">
                    <label>Test Event Code:</label>
                    <small class="form-text text-muted">Optional - for testing in Events Manager</small>
                </div>
                <div class="col-lg-4">
                    <input type="text" class="form-control" placeholder="TEST12345" name="pixels.fb.capi.testcode" value="<?=$fb_capi_testcode?>">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="settings-section mt-4">
    <h3 class="section-header">TikTok Pixel</h3>

    <div class="form-group-inner">
        <div class="row">
            <div class="col-lg-3">
                <label>Pixel ID parameter name:</label>
            </div>
            <div class="col-lg-3">
                <input type="text" class="form-control" placeholder="tpx" name="pixels.tt.subname" value="<?=$ttpixel_subname?>">
                <small class="form-text text-muted">URL parameter containing pixel ID</small>
            </div>
        </div>
    </div>

    <div class="form-group-inner">
        <div class="row">
            <div class="col-lg-3">
                <label>PageView event:</label>
            </div>
            <div class="col-lg-9">
                <div class="form-check form-check-inline">
                    <input type="radio" class="form-check-input" <?=$tt_use_pageview===true?'checked':''?> value="true" name="pixels.tt.pageview" id="tt_pv_on">
                    <label class="form-check-label" for="tt_pv_on">Enabled</label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="radio" class="form-check-input" <?=$tt_use_pageview===false?'checked':''?> value="false" name="pixels.tt.pageview" id="tt_pv_off">
                    <label class="form-check-label" for="tt_pv_off">Disabled</label>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group-inner">
        <div class="row">
            <div class="col-lg-3">
                <label>ViewContent event:</label>
            </div>
            <div class="col-lg-9">
                <div class="form-check form-check-inline">
                    <input type="radio" class="form-check-input" <?=$tt_use_viewcontent===true?'checked':''?> value="true" name="pixels.tt.viewcontent.use" id="tt_vc_on" onclick="document.getElementById('tt_vc_settings').style.display='block'">
                    <label class="form-check-label" for="tt_vc_on">Enabled</label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="radio" class="form-check-input" <?=$tt_use_viewcontent===false?'checked':''?> value="false" name="pixels.tt.viewcontent.use" id="tt_vc_off" onclick="document.getElementById('tt_vc_settings').style.display='none'">
                    <label class="form-check-label" for="tt_vc_off">Disabled</label>
                </div>
            </div>
        </div>
    </div>

    <div id="tt_vc_settings" style="display:<?=$tt_use_viewcontent===true?'block':'none'?>;">
        <div class="form-group-inner">
            <div class="row">
                <div class="col-lg-3">
                    <label>Time delay (seconds):</label>
                </div>
                <div class="col-lg-2">
                    <input type="text" class="form-control" placeholder="30" name="pixels.tt.viewcontent.time" value="<?=$tt_view_content_time?>">
                    <small class="form-text text-muted">0 = disabled</small>
                </div>
                <div class="col-lg-2">
                    <label>Scroll percent:</label>
                </div>
                <div class="col-lg-2">
                    <input type="text" class="form-control" placeholder="75" name="pixels.tt.viewcontent.percent" value="<?=$tt_view_content_percent?>">
                    <small class="form-text text-muted">0 = disabled</small>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group-inner">
        <div class="row">
            <div class="col-lg-3">
                <label>Conversion event name:</label>
            </div>
            <div class="col-lg-3">
                <input type="text" class="form-control" placeholder="Purchase" name="pixels.tt.conversion.event" value="<?=$tt_thankyou_event?>">
                <small class="form-text text-muted">e.g., CompletePayment, AddPaymentInfo</small>
            </div>
        </div>
    </div>

    <div class="form-group-inner">
        <div class="row">
            <div class="col-lg-3">
                <label>Fire conversion from:</label>
            </div>
            <div class="col-lg-9">
                <div class="form-check">
                    <input type="radio" class="form-check-input" <?=$tt_add_button_pixel===false?'checked':''?> value="false" name="pixels.tt.conversion.fireonbutton" id="tt_conv_ty">
                    <label class="form-check-label" for="tt_conv_ty">Thank you page</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" <?=$tt_add_button_pixel===true?'checked':''?> value="true" name="pixels.tt.conversion.fireonbutton" id="tt_conv_btn">
                    <label class="form-check-label" for="tt_conv_btn">Landing page button</label>
                </div>
            </div>
        </div>
    </div>

    <hr class="my-3">
    <h5>TikTok Events API (Server-Side)</h5>

    <div class="form-group-inner">
        <div class="row">
            <div class="col-lg-3">
                <label>Enable Events API:</label>
            </div>
            <div class="col-lg-9">
                <div class="form-check form-check-inline">
                    <input type="radio" class="form-check-input" <?=$tt_events_enabled===true?'checked':''?> value="true" name="pixels.tt.eventsapi.enabled" id="ttapi_on" onclick="document.getElementById('ttapi_settings').style.display='block'">
                    <label class="form-check-label" for="ttapi_on">Enabled</label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="radio" class="form-check-input" <?=$tt_events_enabled===false?'checked':''?> value="false" name="pixels.tt.eventsapi.enabled" id="ttapi_off" onclick="document.getElementById('ttapi_settings').style.display='none'">
                    <label class="form-check-label" for="ttapi_off">Disabled</label>
                </div>
            </div>
        </div>
    </div>

    <div id="ttapi_settings" style="display:<?=$tt_events_enabled===true?'block':'none'?>;">
        <div class="form-group-inner">
            <div class="row">
                <div class="col-lg-3">
                    <label>Access Token:</label>
                    <small class="form-text text-muted">From TikTok Events Manager</small>
                </div>
                <div class="col-lg-6">
                    <input type="text" class="form-control" placeholder="Access token" name="pixels.tt.eventsapi.accesstoken" value="<?=$tt_access_token?>">
                </div>
            </div>
        </div>

        <div class="form-group-inner">
            <div class="row">
                <div class="col-lg-3">
                    <label>Test Event Code:</label>
                    <small class="form-text text-muted">Optional - for testing</small>
                </div>
                <div class="col-lg-4">
                    <input type="text" class="form-control" placeholder="TEST12345" name="pixels.tt.eventsapi.testcode" value="<?=$tt_test_code?>">
                </div>
            </div>
        </div>

        <div class="form-group-inner">
            <div class="row">
                <div class="col-lg-3">
                    <label>Lead event name:</label>
                </div>
                <div class="col-lg-3">
                    <input type="text" class="form-control" placeholder="SubmitForm" name="pixels.tt.eventsapi.leadevent" value="<?=$tt_lead_event?>">
                </div>
            </div>
        </div>
    </div>
</div>
