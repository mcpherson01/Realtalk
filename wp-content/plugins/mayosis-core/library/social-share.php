<?php

// //////////////////////////////////////////////////////////////////////////////////////////
// ////////////////////  Grid Social /////////////////////////////////////////
// /////////////////////////////////////////////////////////////////////////////////////////

function mayosis_gridsocial() {

    $dmsocialURL = urlencode(get_permalink());

    // Get current page title
    $dmsocialTitle = urlencode(html_entity_decode(get_the_title(), ENT_COMPAT, 'UTF-8'));


    // Construct sharing URL without using any script
    $twitterURL = 'https://twitter.com/share?url=' . $dmsocialURL . '&amp;text=' . $dmsocialTitle;
    $facebookURL = 'https://www.facebook.com/sharer/sharer.php?u='.$dmsocialURL;
    $googleURL = 'https://plus.google.com/share?url='.$dmsocialURL;
    $bufferURL = 'https://bufferapp.com/add?url='.$dmsocialURL.'&amp;text='.$dmsocialTitle;
    $whatsappURL = 'whatsapp://send?text='.$dmsocialTitle . ' ' . $dmsocialURL;
    $linkedInURL = 'https://www.linkedin.com/shareArticle?mini=true&url='.$dmsocialURL.'&amp;title='.$dmsocialTitle;

    // Based on popular demand added Pinterest too
    $pinterestURL = 'https://pinterest.com/pin/create/button/?url='.$dmsocialURL.'&amp;description='.$dmsocialTitle;

    echo '<div class="social-button">';
    echo '<i class="zil zi-share"></i>';
    echo '<span>Share</span>';
    echo '<a href="'.$facebookURL.'" target="_blank" class="facebook"><i class="zil zi-facebook"></i></a>';
    echo '<a href="'.$twitterURL.'" target="_blank" class="twitter"><i class="zil zi-twitter"></i></a>';
    echo '<a href=" '.$pinterestURL.'" target="_blank" class="pinterest"><i class="zil zi-pinterest"></i></a>';
    echo'</div>';


};



// //////////////////////////////////////////////////////////////////////////////////////////
// ////////////////////  Floating Social /////////////////////////////////////////
// /////////////////////////////////////////////////////////////////////////////////////////

function mayosis_floatsocial() {

    $dmsocialURL = urlencode(get_permalink());

    // Get current page title
    $dmsocialTitle = urlencode(html_entity_decode(get_the_title(), ENT_COMPAT, 'UTF-8'));


    // Construct sharing URL without using any script
    $twitterURL = 'https://twitter.com/share?url=' . $dmsocialURL . '&amp;text=' . $dmsocialTitle;
    $facebookURL = 'https://www.facebook.com/sharer/sharer.php?u='.$dmsocialURL;
    $googleURL = 'https://plus.google.com/share?url='.$dmsocialURL;
    $bufferURL = 'https://bufferapp.com/add?url='.$dmsocialURL.'&amp;text='.$dmsocialTitle;
    $whatsappURL = 'whatsapp://send?text='.$dmsocialTitle . ' ' . $dmsocialURL;
    $linkedInURL = 'https://www.linkedin.com/shareArticle?mini=true&url='.$dmsocialURL.'&amp;title='.$dmsocialTitle;

    // Based on popular demand added Pinterest too
    $pinterestURL = 'https://pinterest.com/pin/create/button/?url='.$dmsocialURL.'&amp;description='.$dmsocialTitle;
    ?>
    <div class="mayosis-float-social hidden-xs">
        <a href="<?php echo $facebookURL; ?>" onclick="window.open(this.href, 'facebookwindow','left=20,top=20,width=500,height=400,toolbar=0,resizable=1'); return false;" class="facebook"><i class="zil zi-facebook"></i></a>


        <a href="<?php echo $twitterURL; ?>"  onclick="window.open(this.href, 'twitterwindow','left=20,top=20,width=500,height=400,toolbar=0,resizable=1'); return false;" class="twitter"><i class="zil zi-twitter"></i></a>

        

        <a href="<?php echo $pinterestURL; ?>" onclick="window.open(this.href, 'pinterestwindow','left=20,top=20,width=500,height=400,toolbar=0,resizable=1'); return false;" class="pinterest"><i class="zil zi-pinterest"></i></a>

    </div>


<?php }


// //////////////////////////////////////////////////////////////////////////////////////////
// ////////////////////  Product Breadcrumb Social /////////////////////////////////////////
// /////////////////////////////////////////////////////////////////////////////////////////

function mayosis_productbreadcrubm() {

    $dmsocialURL = urlencode(get_permalink());

    // Get current page title
    $dmsocialTitle = urlencode(html_entity_decode(get_the_title(), ENT_COMPAT, 'UTF-8'));


    // Construct sharing URL without using any script
    $twitterURL = 'https://twitter.com/share?url=' . $dmsocialURL . '&amp;text=' . $dmsocialTitle;
    $facebookURL = 'https://www.facebook.com/sharer/sharer.php?u='.$dmsocialURL;
    $googleURL = 'https://plus.google.com/share?url='.$dmsocialURL;
    $bufferURL = 'https://bufferapp.com/add?url='.$dmsocialURL.'&amp;text='.$dmsocialTitle;
    $whatsappURL = 'whatsapp://send?text='.$dmsocialTitle . ' ' . $dmsocialURL;
    $linkedInURL = 'https://www.linkedin.com/shareArticle?mini=true&url='.$dmsocialURL.'&amp;title='.$dmsocialTitle;

    // Based on popular demand added Pinterest too
    $pinterestURL = 'https://pinterest.com/pin/create/button/?url='.$dmsocialURL.'&amp;description='.$dmsocialTitle;
    ?>
    <div class="social-button">
        <a href="<?php echo $facebookURL; ?>" onclick="window.open(this.href, 'facebookwindow','left=20,top=20,width=500,height=400,toolbar=0,resizable=1'); return false;" class="facebook"><i class="zil zi-facebook"></i></a>


        <a href="<?php echo $twitterURL; ?>"  onclick="window.open(this.href, 'twitterwindow','left=20,top=20,width=500,height=400,toolbar=0,resizable=1'); return false;" class="twitter"><i class="zil zi-twitter"></i></a>

        

        <a href="<?php echo $pinterestURL; ?>" onclick="window.open(this.href, 'pinterestwindow','left=20,top=20,width=500,height=400,toolbar=0,resizable=1'); return false;" class="pinterest"><i class="zil zi-pinterest"></i></a>

    </div>


<?php }


// //////////////////////////////////////////////////////////////////////////////////////////
// ////////////////////  Product Bottom Button /////////////////////////////////////////
// /////////////////////////////////////////////////////////////////////////////////////////

function mayosis_productbottombutton() {

    $dmsocialURL = urlencode(get_permalink());

    // Get current page title
    $dmsocialTitle =urlencode(html_entity_decode(get_the_title(), ENT_COMPAT, 'UTF-8'));


    // Construct sharing URL without using any script
    $twitterURL = 'https://twitter.com/share?url=' . $dmsocialURL . '&amp;text=' . $dmsocialTitle;
    $facebookURL = 'https://www.facebook.com/sharer/sharer.php?u='.$dmsocialURL;
    $googleURL = 'https://plus.google.com/share?url='.$dmsocialURL;
    $bufferURL = 'https://bufferapp.com/add?url='.$dmsocialURL.'&amp;text='.$dmsocialTitle;
    $whatsappURL = 'whatsapp://send?text='.$dmsocialTitle . ' ' . $dmsocialURL;
    $linkedInURL = 'https://www.linkedin.com/shareArticle?mini=true&url='.$dmsocialURL.'&amp;title='.$dmsocialTitle;

    // Based on popular demand added Pinterest too
    $pinterestURL = 'https://pinterest.com/pin/create/button/?url='.$dmsocialURL.'&amp;description='.$dmsocialTitle;
    ?>
    <div class="social-button-bottom">
        <span>Share</span>
        <a href="<?php echo $facebookURL; ?>" onclick="window.open(this.href, 'facebookwindow','left=20,top=20,width=500,height=400,toolbar=0,resizable=1'); return false;" class="facebook"><i class="zil zi-facebook"></i></a>


        <a href="<?php echo $twitterURL; ?>"  onclick="window.open(this.href, 'twitterwindow','left=20,top=20,width=500,height=400,toolbar=0,resizable=1'); return false;" class="twitter"><i class="zil zi-twitter"></i></a>

        

        <a href="<?php echo $pinterestURL; ?>" onclick="window.open(this.href, 'pinterestwindow','left=20,top=20,width=500,height=400,toolbar=0,resizable=1'); return false;" class="pinterest"><i class="zil zi-pinterest"></i></a>
    </div>


<?php }


// //////////////////////////////////////////////////////////////////////////////////////////
// ////////////////////  Photo Social /////////////////////////////////////////
// /////////////////////////////////////////////////////////////////////////////////////////

function mayosis_photosocial() {

    $dmsocialURL = urlencode(get_permalink());

    // Get current page title
    $dmsocialTitle = urlencode(html_entity_decode(get_the_title(), ENT_COMPAT, 'UTF-8'));


    // Construct sharing URL without using any script
    $twitterURL = 'https://twitter.com/share?url=' . $dmsocialURL . '&amp;text=' . $dmsocialTitle;
    $facebookURL = 'https://www.facebook.com/sharer/sharer.php?u='.$dmsocialURL;
    $googleURL = 'https://plus.google.com/share?url='.$dmsocialURL;
    $bufferURL = 'https://bufferapp.com/add?url='.$dmsocialURL.'&amp;text='.$dmsocialTitle;
    $whatsappURL = 'whatsapp://send?text='.$dmsocialTitle . ' ' . $dmsocialURL;
    $linkedInURL = 'https://www.linkedin.com/shareArticle?mini=true&url='.$dmsocialURL.'&amp;title='.$dmsocialTitle;

    // Based on popular demand added Pinterest too
    $pinterestURL = 'https://pinterest.com/pin/create/button/?url='.$dmsocialURL.'&amp;description='.$dmsocialTitle;
    ?>
    <div class="photo-template-social">
        <a href="<?php echo $facebookURL; ?>" onclick="window.open(this.href, 'facebookwindow','left=20,top=20,width=500,height=400,toolbar=0,resizable=1'); return false;" class="facebook"><i class="zil zi-facebook"></i></a>


        <a href="<?php echo $twitterURL; ?>"  onclick="window.open(this.href, 'twitterwindow','left=20,top=20,width=500,height=400,toolbar=0,resizable=1'); return false;" class="twitter"><i class="zil zi-twitter"></i></a>

        

        <a href="<?php echo $pinterestURL; ?>" onclick="window.open(this.href, 'pinterestwindow','left=20,top=20,width=500,height=400,toolbar=0,resizable=1'); return false;" class="pinterest"><i class="zil zi-pinterest"></i></a>
    </div>


<?php }

