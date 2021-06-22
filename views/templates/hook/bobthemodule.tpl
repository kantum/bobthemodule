<!-- Block bobthemodule -->
<div id="bobthemodule_block_home" class="block-categories">
  <h4>{l s='Welcome!' mod='bobthemodule'}</h4>
  <div class="block_content">
    <p>Hello,
           {if isset($my_module_name) && $my_module_name}
               {$my_module_name}
           {else}
               World
           {/if}!
    </p>
    <p>How your dog {$bob_dog_name} is doing? <br>
    And what about your cat {$bob_cat_name}?
    </p>
    <p>
    {$my_module_message}
    </p>
    <ul>
      <li><a href="{$my_module_link}" title="Click this link">Click me!</a></li>
    </ul>
  </div>
</div>
<!-- /Block bobthemodule -->
