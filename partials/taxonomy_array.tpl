
                {* binford:[[field_key]] *}
                {if $[[field_name]]}
                    <p>[[field_name]]:</p>
                    <ul>
                        {foreach from=$[[field_name]] item=i}
                            <ul>
                                <li>term_id: {$i->term_id}</li>
                                <li>name: {$i->name}</li>
                                <li>slug: {$i->slug}</li>

                                {*<li>term_group: {$i->term_group}</li>*}
                                {*<li>term_taxonomy_id: {$i->term_taxonomy_id}</li>*}
                                {*<li>taxonomy: {$i->taxonomy}</li>*}
                                {*<li>description: {$i->description}</li>*}
                                {*<li>parent: {$i->parent}</li>*}
                                {*<li>count: {$i->count}</li>*}
                                {*<li>filter: {$i->filter}</li>*}
                            </ul>
                        {/foreach}
                    </ul>
                {/if}
