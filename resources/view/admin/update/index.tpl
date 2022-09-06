<link rel="stylesheet" href="{$resource_link}css/update_module.css">

<h2>{$__['admin']['update']['title']}</h2>

<div>

</div>
<table class="datatable">
    <thead>
        <tr>
            <th>{$__['admin']['update']['table']['name']}</th>
            <th>{$__['admin']['update']['table']['version']}</th>
            <th>{$__['admin']['update']['table']['action']}</th>
        </tr>
    </thead>
    <tbody>
        {foreach from=$updates item=update}
            <tr>
                <td>{$update['name']}</td>
                <td>{$update['tag']}</td>
                <td>{$update['tag']}</td>
            </tr>
        {/foreach}
    </tbody>
</table>
