
                {* binford:[[field_key]] *}
                {if $[[field_name]]}
                    <p>[[field_name]]:</p>
                    <ul>
                        <li>ID: {$[[field_name]].ID}</li>
                        <li>display_name: {$[[field_name]].display_name}</li>
                        <li>user_email: {$[[field_name]].user_email}</li>

                        {*<li>user_firstname: {$[[field_name]].user_firstname}</li>*}
                        {*<li>user_lastname: {$[[field_name]].user_lastname}</li>*}
                        {*<li>nickname: {$[[field_name]].nickname}</li>*}
                        {*<li>user_nicename: {$[[field_name]].user_nicename}</li>*}
                        {*<li>user_url: {$[[field_name]].user_url}</li>*}
                        {*<li>user_registered: {$[[field_name]].user_registered}</li>*}
                        {*<li>user_description: {$[[field_name]].user_description}</li>*}
                        {*<li>user_avatar: {$[[field_name]].user_avatar}</li>*}
                    </ul>
                {/if}
