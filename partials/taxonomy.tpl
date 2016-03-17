
                {* binford:[[field_key]] *}
                {if $[[field_name]]}
                    <p>[[field_name]]:</p>
                    <ul>
                        <li>term_id: {$[[field_name]]->term_id}</li>
                        <li>name: {$[[field_name]]->name}</li>
                        <li>slug: {$[[field_name]]->slug}</li>

                        {*<li>term_group: {$[[field_name]]->term_group}</li>*}
                        {*<li>term_taxonomy_id: {$[[field_name]]->term_taxonomy_id}</li>*}
                        {*<li>taxonomy: {$[[field_name]]->taxonomy}</li>*}
                        {*<li>description: {$[[field_name]]->description}</li>*}
                        {*<li>parent: {$[[field_name]]->parent}</li>*}
                        {*<li>count: {$[[field_name]]->count}</li>*}
                        {*<li>filter: {$[[field_name]]->filter}</li>*}
                    </ul>
                {/if}
