<div class="social-media--overview__item">
    <div class="social-media--block {$source}">
        <h2>
            {if !empty($user_url)}
                <a href="{$user_url}" target="_blank" title="{$user_name}">{$user_name}</a>
            {else}
                {$user_name}
            {/if}
        </h2>
        <p>{$time_ago}</p>
        {if !empty($content_html)}
            <p>{$content_html}</p>
        {/if}
        {if !empty($image)}
            {if !empty($video)}
                <p><a href="{$video}" target="_blank"><img src="{$image}" alt="{$user_name}" /></a></p>
            {else}
                <p><a href="{$url}" target="_blank"><img src="{$image}" alt="{$user_name}" /></a></p>
            {/if}
        {/if}
    </div>
</div>