<div class="settings-section">
    <h3 class="section-header">TDS Mode</h3>
    <p class="text-muted">Control traffic distribution system behavior</p>

    <div class="form-group-inner">
        <div class="row">
            <div class="col-lg-3">
                <label>TDS Mode:</label>
            </div>
            <div class="col-lg-9">
                <div class="form-check">
                    <input type="radio" class="form-check-input" <?=$tds_mode==='on'?'checked':''?> value="on" name="tds.mode" id="tds_on">
                    <label class="form-check-label" for="tds_on">Normal (filters active)</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" <?=$tds_mode==='full'?'checked':''?> value="full" name="tds.mode" id="tds_full">
                    <label class="form-check-label" for="tds_full">Full cloak (all traffic to white)</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" <?=$tds_mode==='off'?'checked':''?> value="off" name="tds.mode" id="tds_off">
                    <label class="form-check-label" for="tds_off">Off (all traffic to black - testing only)</label>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group-inner">
        <div class="row">
            <div class="col-lg-3">
                <label>Save user flow:</label>
                <small class="form-text text-muted">Remember which prelanding/landing each visitor saw</small>
            </div>
            <div class="col-lg-9">
                <div class="form-check form-check-inline">
                    <input type="radio" class="form-check-input" <?=$save_user_flow===true?'checked':''?> value="true" name="tds.saveuserflow" id="flow_on">
                    <label class="form-check-label" for="flow_on">Yes</label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="radio" class="form-check-input" <?=$save_user_flow===false?'checked':''?> value="false" name="tds.saveuserflow" id="flow_off">
                    <label class="form-check-label" for="flow_off">No</label>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="settings-section mt-4">
    <h3 class="section-header">Allowed Traffic</h3>
    <p class="text-muted">Define which traffic is allowed to see black pages</p>

    <div class="form-group-inner">
        <div class="row">
            <div class="col-lg-3">
                <label>Allowed countries:</label>
            </div>
            <div class="col-lg-6">
                <input type="text" class="form-control" placeholder="UA,BY,RU" name="tds.filters.allowed.countries" value="<?=implode(',',$country_white)?>">
                <small class="form-text text-muted">ISO 2-letter codes, comma-separated (empty = all allowed)</small>
            </div>
        </div>
    </div>

    <div class="form-group-inner">
        <div class="row">
            <div class="col-lg-3">
                <label>Allowed operating systems:</label>
            </div>
            <div class="col-lg-6">
                <input type="text" class="form-control" placeholder="Android,iOS,Windows" name="tds.filters.allowed.os" value="<?=implode(',',$os_white)?>">
                <small class="form-text text-muted">Comma-separated (empty = all allowed)</small>
            </div>
        </div>
    </div>

    <div class="form-group-inner">
        <div class="row">
            <div class="col-lg-3">
                <label>Allowed languages:</label>
            </div>
            <div class="col-lg-6">
                <input type="text" class="form-control" placeholder="en,ru,uk" name="tds.filters.allowed.languages" value="<?=implode(',',$lang_white)?>">
                <small class="form-text text-muted">ISO 2-letter codes, comma-separated (empty = all allowed)</small>
            </div>
        </div>
    </div>

    <div class="form-group-inner">
        <div class="row">
            <div class="col-lg-3">
                <label>URL must contain:</label>
            </div>
            <div class="col-lg-6">
                <input type="text" class="form-control" placeholder="fbclid,gclid" name="tds.filters.allowed.inurl" value="<?=implode(',',$url_should_contain)?>">
                <small class="form-text text-muted">Comma-separated keywords (empty = no requirement)</small>
            </div>
        </div>
    </div>
</div>

<div class="settings-section mt-4">
    <h3 class="section-header">Blocked Traffic</h3>
    <p class="text-muted">Define which traffic should be blocked and see white pages</p>

    <div class="form-group-inner">
        <div class="row">
            <div class="col-lg-3">
                <label>Block IP ranges file:</label>
            </div>
            <div class="col-lg-6">
                <input type="text" class="form-control" placeholder="bases/bots.txt" name="tds.filters.blocked.ips.filename" value="<?=$ip_black_filename?>">
                <small class="form-text text-muted">Path to file with IP ranges (one per line)</small>
            </div>
            <div class="col-lg-3">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" <?=$ip_black_cidr?'checked':''?> value="true" name="tds.filters.blocked.ips.cidrformat" id="cidr">
                    <label class="form-check-label" for="cidr">CIDR format</label>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group-inner">
        <div class="row">
            <div class="col-lg-3">
                <label>Block URL tokens:</label>
            </div>
            <div class="col-lg-6">
                <input type="text" class="form-control" placeholder="preview,test" name="tds.filters.blocked.tokens" value="<?=implode(',',$tokens_black)?>">
                <small class="form-text text-muted">Block URLs containing these keywords</small>
            </div>
        </div>
    </div>

    <div class="form-group-inner">
        <div class="row">
            <div class="col-lg-3">
                <label>Block user agents:</label>
            </div>
            <div class="col-lg-6">
                <textarea class="form-control" rows="3" name="tds.filters.blocked.useragents" placeholder="facebook,curl,bot"><?=implode(',',$ua_black)?></textarea>
                <small class="form-text text-muted">Comma-separated keywords to block</small>
            </div>
        </div>
    </div>

    <div class="form-group-inner">
        <div class="row">
            <div class="col-lg-3">
                <label>Block ISPs:</label>
            </div>
            <div class="col-lg-6">
                <textarea class="form-control" rows="3" name="tds.filters.blocked.isps" placeholder="facebook,google,amazon"><?=implode(',',$isp_black)?></textarea>
                <small class="form-text text-muted">Block traffic from these ISPs/hosting providers</small>
            </div>
        </div>
    </div>

    <div class="form-group-inner">
        <div class="row">
            <div class="col-lg-3">
                <label>Referrer checks:</label>
            </div>
            <div class="col-lg-9">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" <?=$block_without_referer?'checked':''?> value="true" name="tds.filters.blocked.referer.empty" id="ref_empty">
                    <label class="form-check-label" for="ref_empty">Block empty referrer</label>
                </div>
                <div class="mt-2">
                    <input type="text" class="form-control" placeholder="spam.com,badsite.net" name="tds.filters.blocked.referer.stopwords" value="<?=implode(',',$referer_stopwords)?>">
                    <small class="form-text text-muted">Block referrers containing these keywords</small>
                </div>
            </div>
        </div>
    </div>

    <hr class="my-3">

    <div class="form-group-inner">
        <div class="row">
            <div class="col-lg-3">
                <label>Advanced detection:</label>
            </div>
            <div class="col-lg-9">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" <?=$block_vpnandtor?'checked':''?> value="true" name="tds.filters.blocked.vpntor" id="vpn">
                    <label class="form-check-label" for="vpn">Block VPN/Tor (requires external API)</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" <?=$block_spyservices?'checked':''?> value="true" name="tds.filters.blocked.spyservices" id="spy">
                    <label class="form-check-label" for="spy">Block spy services (AdSpy, BigSpy, etc.)</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" <?=$block_datacenter?'checked':''?> value="true" name="tds.filters.blocked.datacenter" id="dc">
                    <label class="form-check-label" for="dc">Block datacenter IPs</label>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group-inner">
        <div class="row">
            <div class="col-lg-3">
                <label>VPN fallback:</label>
                <small class="form-text text-muted">If primary VPN check fails</small>
            </div>
            <div class="col-lg-9">
                <div class="form-check form-check-inline">
                    <input type="radio" class="form-check-input" <?=$vpn_fallback===true?'checked':''?> value="true" name="tds.filters.blocked.vpnfallback" id="vpnfb_on">
                    <label class="form-check-label" for="vpnfb_on">Allow (show black)</label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="radio" class="form-check-input" <?=$vpn_fallback===false?'checked':''?> value="false" name="tds.filters.blocked.vpnfallback" id="vpnfb_off">
                    <label class="form-check-label" for="vpnfb_off">Block (show white)</label>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group-inner">
        <div class="row">
            <div class="col-lg-3">
                <label>ProxyCheck.io API key:</label>
            </div>
            <div class="col-lg-6">
                <input type="text" class="form-control" placeholder="Optional" name="tds.filters.blocked.proxycheckkey" value="<?=$proxycheck_key?>">
                <small class="form-text text-muted">For VPN/proxy detection</small>
            </div>
        </div>
    </div>

    <div class="form-group-inner">
        <div class="row">
            <div class="col-lg-3">
                <label>IPQualityScore API key:</label>
            </div>
            <div class="col-lg-6">
                <input type="text" class="form-control" placeholder="Optional" name="tds.filters.blocked.ipqskey" value="<?=$ipqs_key?>">
                <small class="form-text text-muted">For fraud detection</small>
            </div>
        </div>
    </div>

    <hr class="my-3">

    <div class="form-group-inner">
        <div class="row">
            <div class="col-lg-3">
                <label>BotD (Bot Detection):</label>
                <small class="form-text text-muted">Advanced fingerprinting for headless browsers</small>
            </div>
            <div class="col-lg-9">
                <div class="form-check form-check-inline">
                    <input type="radio" class="form-check-input" <?=$botd_enabled===true?'checked':''?> value="true" name="tds.filters.blocked.botd.enabled" id="botd_on">
                    <label class="form-check-label" for="botd_on">Enabled</label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="radio" class="form-check-input" <?=$botd_enabled===false?'checked':''?> value="false" name="tds.filters.blocked.botd.enabled" id="botd_off">
                    <label class="form-check-label" for="botd_off">Disabled</label>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group-inner">
        <div class="row">
            <div class="col-lg-3">
                <label>BotD result timeout (seconds):</label>
            </div>
            <div class="col-lg-3">
                <input type="text" class="form-control" placeholder="300" name="tds.filters.blocked.botd.timeout" value="<?=$botd_timeout?>">
                <small class="form-text text-muted">How long to trust detection result</small>
            </div>
        </div>
    </div>
</div>
