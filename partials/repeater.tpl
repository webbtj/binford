
                {* binford:[[field_key]] *}
                {if $[[field_name]]}
                    <p>[[field_name]]:</p>
                    <ul>
                        {foreach from=$[[field_name]] item=i key=k}
                            <li>
                                <ul>
                                    {foreach from=$i item=v key=j}
                                        <li>{$j}: {$v} (Direct Variable: $[[field_name]].{$k}.{$j})</li>
                                    {/foreach}
                                </ul>
                            </li>
                        {/foreach}
                    </ul>
                {/if}
