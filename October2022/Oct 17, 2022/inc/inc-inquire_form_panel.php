<?php
$main_title = $section['main_title'];
$form_id = $section['form_id'];
// $ship = get_field('ship_type', $prod_id);
echo '<section class="full-section quote_with_panel">';
    echo '<div class="container">';
        if ($main_title){ printf('<h2>%s</h2>', $main_title); }
        echo '<div class="cover_quote">';
            echo '<div class="quote_form">';
                echo do_shortcode('[gravityform id="' . $form_id . '" title="false" description="false" ajax="true"]');
            echo '</div>'; //quote_form"
            echo '<div class="quote_panel inquire_form_new">';

            echo '</div>'; //quote_panel
        echo '</div>'; //cover_quote

    echo '</div>';
echo '</section>';
?>
<script type="text/javascript">
jQuery(document).on("gform_confirmation_loaded", function(event, formId){
    if(formId == '<?php echo $form_id ?>'){
        setCookie("enquiry_title","",0);
    }
});
jQuery(document).ready(function(){
    let UFGStorage = JSON.parse( localStorage.getItem('UFGStorage') )
    // UFGStorage['action'];
    let title =  getCookie("enquiry_title");
});
</script>