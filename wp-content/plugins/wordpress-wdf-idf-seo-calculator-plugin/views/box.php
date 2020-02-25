<?php /* @var $this wtb_idf_calculator_actions */ ?>

<div class="plugin-header" >
    <input type="text" id="idf-calculator-word"
           name="idf-calculator-word" value="<?php echo get_post_meta( $post->ID, 'idf-calculator-word', true ); ?>" />
    <div id="idf-calculator-check"><?php echo __('Check WDF*IDF', 'wtb_idf_calculator') ?></div>
    
    <div style="display: none" id="wtb-idf-loader-text"><?php _e('searching', 'wtb_idf_calculator') ?></div>
    
    <label class="wtb_idf_calculator_top_results_holder">
        <?php echo __('Count', 'wtb_idf_calculator') ?>
        <select id="wtb_idf_calculator_top_results">
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="20">20</option>
            <option value="30">30</option>
            <option selected="selected" value="40">40</option>
            <option value="50">50</option>
            <option value="60">60</option>
        </select>
    </label>
</div>

<div class="plugin-footer" >
    <div id="chart_div"></div>
    <div id="chart_legend"></div>

    <div id="chart_div1"></div>
    <div id="chart_legend1"></div>
</div>
