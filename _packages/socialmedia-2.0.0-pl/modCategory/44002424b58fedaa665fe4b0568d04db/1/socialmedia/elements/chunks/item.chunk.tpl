<div class="social-media--overview__item">
    <div class="social-media--block [[+source]]">
        <h2>
            [[+user_url:notempty=`
                <a href="[[+user_url]]" target="_blank" title="[[+user_name]]">[[+user_name]]</a>
            `:empty=`
                [[+user_name]]
            `]]
        </h2>
        <p>[[+time_ago]]</p>
        [[+content_html:notempty=`
            <p>[[+content_html]]</p>
        `]]
        [[+image:notempty=`
            [[+video:notempty=`
                <p><a href="[[+video]]" target="_blank"><img src="[[+image]]" alt="[[+user_name]]" /></a></p>
            `:empty=`
                <p><a href="[[+url]]" target="_blank"><img src="[[+image]]" alt="[[+user_name]]" /></a></p>
            `]]
        `]]
    </div>
</div>