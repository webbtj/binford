
                {* binford:[[field_key]] *}
                {if $[[field_name]]}
                    <p>[[field_name]]:</p>
                    <ul>
                        {foreach from=$[[field_name]] item=i}
                            <ul>
                                <li>ID: {$i->ID}</li>
                                <li>post_title: {$i->post_title}</li>
                                <li>post_author: {$i->post_author}</li>
                                <li>post_date: {$i->post_date}</li>
                                <li>url: {$i->url}</li>

                                {*<li>post_date_gmt: {$i->post_date_gmt}</li>*}
                                {*<li>post_content: {$i->post_content}</li>*}
                                {*<li>post_excerpt: {$i->post_excerpt}</li>*}
                                {*<li>post_status: {$i->post_status}</li>*}
                                {*<li>comment_status: {$i->comment_status}</li>*}
                                {*<li>ping_status: {$i->ping_status}</li>*}
                                {*<li>post_password: {$i->post_password}</li>*}
                                {*<li>post_name: {$i->post_name}</li>*}
                                {*<li>to_ping: {$i->to_ping}</li>*}
                                {*<li>pinged: {$i->pinged}</li>*}
                                {*<li>post_modified: {$i->post_modified}</li>*}
                                {*<li>post_modified_gmt: {$i->post_modified_gmt}</li>*}
                                {*<li>post_content_filtered: {$i->post_content_filtered}</li>*}
                                {*<li>post_parent: {$i->post_parent}</li>*}
                                {*<li>guid: {$i->guid}</li>*}
                                {*<li>menu_order: {$i->menu_order}</li>*}
                                {*<li>post_type: {$i->post_type}</li>*}
                                {*<li>post_mime_type: {$i->post_mime_type}</li>*}
                                {*<li>comment_count: {$i->comment_count}</li>*}
                                {*<li>filter: {$i->filter}</li>*}
                            </ul>
                        {/foreach}
                    </ul>
                {/if}
