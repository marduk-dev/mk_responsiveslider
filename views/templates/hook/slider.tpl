{if $mk_slider.slides}
  <div id="{$mk_slider.slider_id}" class="mk_responsiveslider carousel slide" data-bs-ride="carousel" data-bs-interval="{$mk_slider.speed}" data-bs-wrap="{(string)$mk_slider.wrap}" data-bs-pause="{$mk_slider.pause}">
    <div class="carousel-indicators">
    {foreach from=$mk_slider.slides item=slide key=idxSlide name='mk_slider'}
      <button type="button" data-bs-target="#{$mk_slider.slider_id}" data-bs-slide-to="{$idxSlide}"{if $idxSlide == 0} class="active" aria-current="true"{/if} aria-label="{$slide.title}"></button>
    {/foreach}
    </div>
    <div class="carousel-inner">
    {foreach from=$mk_slider.slides item=slide key=idxSlide name='mk_slider'}
      <div class="carousel-item{if $idxSlide == 0} active{/if}">
      {if !empty($slide.url)}<a href="{$slide.url}">{/if}
        <img src="{$slide.desktop_img}" class="d-block w-100 desktop" alt="{$slide.legend|escape}" loading="lazy">
        <img src="{$slide.mobile_img}" class="d-block w-100 mobile" alt="{$slide.legend|escape}" loading="lazy">
        {if ($slide.is_text_visible) && ($slide.title || $slide.description)}
        <div class="carousel-caption d-md-block">
          <h5>{$slide.title}</h5>
          <p>{$slide.description nofilter}</p>
        </div>
        {/if}
      {if !empty($slide.url)}</a>{/if}
      </div>
    {/foreach}
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#{$mk_slider.slider_id}" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">{l s='Previous' d='Shop.Theme.Global'}</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#{$mk_slider.slider_id}" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">{l s='Next' d='Shop.Theme.Global'}</span>
    </button>
  </div>
{else}
  <h2 d-hidden>{l s='No slides available' js=1 d='Modules.Mkresponsiveslider.Slider'}</h2>
{/if}
