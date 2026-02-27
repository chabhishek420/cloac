<div class="settings-section">
    <h3 class="section-header">Sub-ID Mapping</h3>
    <p class="text-muted">Map URL parameters to form fields or affiliate network parameters</p>

    <div class="alert alert-info">
        <strong>How it works:</strong>
        <ul class="mb-0">
            <li>Left side: Parameter name in your URL (e.g., <code>?cn=MyCampaign</code>)</li>
            <li>Right side: Field name in forms or affiliate network parameter</li>
            <li>Built-in parameters: <code>subid</code> (unique visitor ID), <code>prelanding</code>, <code>landing</code></li>
        </ul>
    </div>

    <div id="subs_container">
        <?php for ($i=0;$i<count($sub_ids);$i++){?>
        <div class="form-group-inner subs-row">
            <div class="row">
                <div class="col-lg-3">
                    <input type="text" class="form-control" placeholder="subid" value="<?=$sub_ids[$i]["name"]?>" name="subids[<?=$i?>][name]">
                </div>
                <div class="col-lg-1 text-center">=></div>
                <div class="col-lg-3">
                    <input type="text" class="form-control" placeholder="sub1" value="<?=$sub_ids[$i]["rewrite"]?>" name="subids[<?=$i?>][rewrite]">
                </div>
                <div class="col-lg-2">
                    <button type="button" class="btn btn-sm btn-danger remove-sub-item">Remove</button>
                </div>
            </div>
        </div>
        <?php }?>
    </div>
    <button type="button" id="add-sub-item" class="btn btn-sm btn-primary mt-2">Add Sub-ID</button>
</div>

<div class="settings-section mt-4">
    <h3 class="section-header">Statistics & Admin Panel</h3>

    <div class="form-group-inner">
        <div class="row">
            <div class="col-lg-3">
                <label>Admin panel password:</label>
                <small class="form-text text-muted">Access: /admin?password=xxxxx</small>
            </div>
            <div class="col-lg-4">
                <input type="password" class="form-control" placeholder="12345" name="statistics.password" value="<?=$log_password?>">
            </div>
        </div>
    </div>

    <div class="form-group-inner">
        <div class="row">
            <div class="col-lg-3">
                <label>Timezone:</label>
            </div>
            <div class="col-lg-4">
                <?=select_timezone('statistics.timezone',$stats_timezone) ?>
            </div>
        </div>
    </div>

    <hr class="my-3">
    <h5>Statistics Table Configuration</h5>
    <p class="text-muted">Configure which sub-IDs appear as separate tables in statistics</p>

    <div id="stats_subs_container">
        <?php for ($i=0;$i<count($stats_sub_names);$i++){?>
        <div class="form-group-inner stats-subs-row">
            <div class="row">
                <div class="col-lg-3">
                    <input type="text" class="form-control" placeholder="adn" value="<?=$stats_sub_names[$i]["name"]?>" name="statistics.subnames[<?=$i?>][name]">
                    <small class="form-text text-muted">Parameter name</small>
                </div>
                <div class="col-lg-1 text-center">=></div>
                <div class="col-lg-3">
                    <input type="text" class="form-control" placeholder="Adset" value="<?=$stats_sub_names[$i]["value"]?>" name="statistics.subnames[<?=$i?>][value]">
                    <small class="form-text text-muted">Table title (English)</small>
                </div>
                <div class="col-lg-2">
                    <button type="button" class="btn btn-sm btn-danger remove-stats-sub-item">Remove</button>
                </div>
            </div>
        </div>
        <?php }?>
    </div>
    <button type="button" id="add-stats-sub-item" class="btn btn-sm btn-primary mt-2">Add Stats Table</button>
</div>

<div class="settings-section mt-4">
    <h3 class="section-header">Postback Configuration</h3>
    <p class="text-muted">Configure status names that affiliate networks send in postbacks</p>

    <div class="form-group-inner">
        <div class="row">
            <div class="col-lg-3">
                <label>Lead status name:</label>
            </div>
            <div class="col-lg-4">
                <input type="text" class="form-control" placeholder="Lead" name="postback.lead" value="<?=$lead_status_name?>">
            </div>
        </div>
    </div>

    <div class="form-group-inner">
        <div class="row">
            <div class="col-lg-3">
                <label>Purchase status name:</label>
            </div>
            <div class="col-lg-4">
                <input type="text" class="form-control" placeholder="Purchase" name="postback.purchase" value="<?=$purchase_status_name?>">
            </div>
        </div>
    </div>

    <div class="form-group-inner">
        <div class="row">
            <div class="col-lg-3">
                <label>Reject status name:</label>
            </div>
            <div class="col-lg-4">
                <input type="text" class="form-control" placeholder="Reject" name="postback.reject" value="<?=$reject_status_name?>">
            </div>
        </div>
    </div>

    <div class="form-group-inner">
        <div class="row">
            <div class="col-lg-3">
                <label>Trash status name:</label>
            </div>
            <div class="col-lg-4">
                <input type="text" class="form-control" placeholder="Trash" name="postback.trash" value="<?=$trash_status_name?>">
            </div>
        </div>
    </div>

    <hr class="my-3">
    <h5>S2S Postback URLs</h5>
    <p class="text-muted">Send conversion events to external tracking systems</p>

    <div id="s2s_container">
        <?php
        $s2s_postbacks = $conf->get('postback.s2s', []);
        for ($i=0;$i<count($s2s_postbacks);$i++){
        ?>
        <div class="form-group-inner s2s-row">
            <div class="row">
                <div class="col-lg-5">
                    <input type="text" class="form-control" placeholder="https://tracker.com/postback?subid={subid}&status={status}" name="postback.s2s[<?=$i?>][url]" value="<?=$s2s_postbacks[$i]['url']?>">
                    <small class="form-text text-muted">Postback URL (supports macros)</small>
                </div>
                <div class="col-lg-2">
                    <select class="form-control" name="postback.s2s[<?=$i?>][method]">
                        <option value="GET" <?=$s2s_postbacks[$i]['method']==='GET'?'selected':''?>>GET</option>
                        <option value="POST" <?=$s2s_postbacks[$i]['method']==='POST'?'selected':''?>>POST</option>
                    </select>
                </div>
                <div class="col-lg-3">
                    <select class="form-control" name="postback.s2s[<?=$i?>][events][]" multiple>
                        <option value="Lead" <?=in_array('Lead',$s2s_postbacks[$i]['events'])?'selected':''?>>Lead</option>
                        <option value="Purchase" <?=in_array('Purchase',$s2s_postbacks[$i]['events'])?'selected':''?>>Purchase</option>
                    </select>
                    <small class="form-text text-muted">Events to send</small>
                </div>
                <div class="col-lg-2">
                    <button type="button" class="btn btn-sm btn-danger remove-s2s-item">Remove</button>
                </div>
            </div>
        </div>
        <?php }?>
    </div>
    <button type="button" id="add-s2s-item" class="btn btn-sm btn-primary mt-2">Add S2S Postback</button>
</div>

<script>
// Sub-ID management
document.getElementById('add-sub-item').addEventListener('click', function() {
    const container = document.getElementById('subs_container');
    const count = container.querySelectorAll('.subs-row').length;
    const html = `
        <div class="form-group-inner subs-row">
            <div class="row">
                <div class="col-lg-3">
                    <input type="text" class="form-control" placeholder="subid" name="subids[${count}][name]">
                </div>
                <div class="col-lg-1 text-center">=></div>
                <div class="col-lg-3">
                    <input type="text" class="form-control" placeholder="sub1" name="subids[${count}][rewrite]">
                </div>
                <div class="col-lg-2">
                    <button type="button" class="btn btn-sm btn-danger remove-sub-item">Remove</button>
                </div>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', html);
});

document.getElementById('subs_container').addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-sub-item')) {
        e.target.closest('.subs-row').remove();
    }
});

// Stats sub-ID management
document.getElementById('add-stats-sub-item').addEventListener('click', function() {
    const container = document.getElementById('stats_subs_container');
    const count = container.querySelectorAll('.stats-subs-row').length;
    const html = `
        <div class="form-group-inner stats-subs-row">
            <div class="row">
                <div class="col-lg-3">
                    <input type="text" class="form-control" placeholder="adn" name="statistics.subnames[${count}][name]">
                    <small class="form-text text-muted">Parameter name</small>
                </div>
                <div class="col-lg-1 text-center">=></div>
                <div class="col-lg-3">
                    <input type="text" class="form-control" placeholder="Adset" name="statistics.subnames[${count}][value]">
                    <small class="form-text text-muted">Table title (English)</small>
                </div>
                <div class="col-lg-2">
                    <button type="button" class="btn btn-sm btn-danger remove-stats-sub-item">Remove</button>
                </div>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', html);
});

document.getElementById('stats_subs_container').addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-stats-sub-item')) {
        e.target.closest('.stats-subs-row').remove();
    }
});

// S2S postback management
document.getElementById('add-s2s-item').addEventListener('click', function() {
    const container = document.getElementById('s2s_container');
    const count = container.querySelectorAll('.s2s-row').length;
    const html = `
        <div class="form-group-inner s2s-row">
            <div class="row">
                <div class="col-lg-5">
                    <input type="text" class="form-control" placeholder="https://tracker.com/postback?subid={subid}&status={status}" name="postback.s2s[${count}][url]">
                    <small class="form-text text-muted">Postback URL (supports macros)</small>
                </div>
                <div class="col-lg-2">
                    <select class="form-control" name="postback.s2s[${count}][method]">
                        <option value="GET">GET</option>
                        <option value="POST">POST</option>
                    </select>
                </div>
                <div class="col-lg-3">
                    <select class="form-control" name="postback.s2s[${count}][events][]" multiple>
                        <option value="Lead">Lead</option>
                        <option value="Purchase">Purchase</option>
                    </select>
                    <small class="form-text text-muted">Events to send</small>
                </div>
                <div class="col-lg-2">
                    <button type="button" class="btn btn-sm btn-danger remove-s2s-item">Remove</button>
                </div>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', html);
});

document.getElementById('s2s_container').addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-s2s-item')) {
        e.target.closest('.s2s-row').remove();
    }
});
</script>
