
                {* binford:[[field_key]] *}
                {if $[[field_name]]}
                    <p>[[field_name]]:</p>
                    <ul>
                        <li>ID: {$[[field_name]]->ID}</li>
                        <li>post_title: {$[[field_name]]->post_title}</li>
                        <li>post_author: {$[[field_name]]->post_author}</li>
                        <li>post_date: {$[[field_name]]->post_date}</li>
                        <li>url: {$[[field_name]]->url}</li>
                        
                        {*<li>post_date_gmt: {$[[field_name]]->post_date_gmt}</li>*}
                        {*<li>post_content: {$[[field_name]]->post_content}</li>*}
                        {*<li>post_excerpt: {$[[field_name]]->post_excerpt}</li>*}
                        {*<li>post_status: {$[[field_name]]->post_status}</li>*}
                        {*<li>comment_status: {$[[field_name]]->comment_status}</li>*}
                        {*<li>ping_status: {$[[field_name]]->ping_status}</li>*}
                        {*<li>post_password: {$[[field_name]]->post_password}</li>*}
                        {*<li>post_name: {$[[field_name]]->post_name}</li>*}
                        {*<li>to_ping: {$[[field_name]]->to_ping}</li>*}
                        {*<li>pinged: {$[[field_name]]->pinged}</li>*}
                        {*<li>post_modified: {$[[field_name]]->post_modified}</li>*}
                        {*<li>post_modified_gmt: {$[[field_name]]->post_modified_gmt}</li>*}
                        {*<li>post_content_filtered: {$[[field_name]]->post_content_filtered}</li>*}
                        {*<li>post_parent: {$[[field_name]]->post_parent}</li>*}
                        {*<li>guid: {$[[field_name]]->guid}</li>*}
                        {*<li>menu_order: {$[[field_name]]->menu_order}</li>*}
                        {*<li>post_type: {$[[field_name]]->post_type}</li>*}
                        {*<li>post_mime_type: {$[[field_name]]->post_mime_type}</li>*}
                        {*<li>comment_count: {$[[field_name]]->comment_count}</li>*}
                        {*<li>filter: {$[[field_name]]->filter}</li>*}
                    </ul>
                {/if}
