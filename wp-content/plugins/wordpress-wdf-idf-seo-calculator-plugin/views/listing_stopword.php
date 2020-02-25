<?php /* @var $this wtb_idf_calculator_actions */ ?>

<div class="wrap">

    <?php if (isset($_GET['message']) && $_GET['message'] == 1) { ?>
        <div class="updated"><p><?php _e('Stopword is successfully updated', 'wtb_idf_calculator') ?></p></div>
        <?php $_SERVER['REQUEST_URI'] = remove_query_arg(array('message'), $_SERVER['REQUEST_URI']);
    } else if (isset($_GET['message']) && $_GET['message'] == 2) { ?>
        <div class="updated"><p><?php _e('Stopword is successfully created', 'wtb_idf_calculator') ?></p></div>
        <?php $_SERVER['REQUEST_URI'] = remove_query_arg(array('message'), $_SERVER['REQUEST_URI']);
    } ?>
    
    <h2><?php echo __('Stopwords', 'wtb_idf_calculator') ?></h2>

    <div id='col-container'>
        <div id='col-right'>
            <div class='col-wrap'>

                <form id="stop-keywords-filter" method="get">

                    <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />

                    <?php $stopKeywordsTable->display(); ?>
                </form>
            </div>
        </div>

        <div id='col-left'>
            <div class='col-wrap'>
                <form method="post" action="admin.php?page=wtb-idf-stop-keywords" class="validate">
                    <input type="hidden" name="page" value="wtb-idf-stop-keywords" />
                    <input type="hidden" name="action" value="create" />
                    <table class="form-table">
                        <tr class="form-field form-required">
                            <th scope="row" valign="top"><label for="keyword"><?php _e('Stopword', 'wtb_idf_calculator'); ?></label></th>
                            <td><input name="keyword" id="keyword" type="text" value="" size="20" aria-required="true" />
                        </tr>
<!--                        <tr class="form-field">
                            <th scope="row" valign="top"><label for="language"><?php _e('Language', 'wtb_idf_calculator'); ?></label></th>
                            <td><input name="language" id="language" type="text" value="" size="20" />
                        </tr>-->
                    </table>
                    <?php
                        submit_button( _x('Create Stopword', 'Shown on create stop keyword button', 'wtb_idf_calculator' ));
                    ?>
                </form>
            </div>
        </div>
    </div>
</div>