<link rel="stylesheet" href="{$resource_link}css/update_module.css">
<script src="{$resource_link}js/update_module.js"></script>

<h2 class="header-page">- {$__['admin']['update']['title']}</h2>

{if empty($updates)}
    <div>{$__['admin']['update']['table']['name']}</div>
{else}
    {*<pre>
    {var_dump($updates)}
    </pre>*}
    <div class="update-module">
        <div class="update-module-name">{$updates['name']}</div>
        <button class="update-module-button">Start Update</button>
    </div>
    <div class="update-result">
        <div class="step-upgrade" data-type="start">
            <div>Start update</div>
            <div></div>
        </div>
        <div class="step-upgrade" data-type="download">
            <div>Downloading update file</div>
            <div></div>
        </div>
        <div class="step-upgrade" data-type="extract">
            <div>Extract download file</div>
            <div></div>
        </div>
        <div class="step-upgrade" data-type="finish">
            <div>Finish update</div>
            <div></div>
        </div>
    </div>
{/if}