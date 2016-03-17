
                {* binford:[[field_key]] *}
                {if $[[field_name]]}
                    <p>[[field_name]]:</p>
                    <ul>
                        {foreach from=$[[field_name]] item=i}
                            <li>{$i}</li>
                        {/foreach}
                    </ul>
                {/if}
